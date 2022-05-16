<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// use Auth;
use App\Models\User;
use \App\Models\Role;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
// use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App;
use Stripe;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\Return_;
use App\Mail\EmailVerificationMail;
use App\Models\Address;
use App\Models\Brand;
use App\Models\Card;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Favourite;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\RecentProducts;
use App\Models\Store;
use App\Models\VariantItems;
use GrahamCampbell\ResultType\Success;
use Illuminate\Cache\RateLimiting\Limit;
use Symfony\Contracts\Service\Attribute\Required;

class ClientController extends ApiController
{
    public $successStatus = 200;
    private $LoginAttributes  = ['id','fname','lname','email','phonecode','mobile_no','profile_picture','marital_status','type','status','token','created_at','updated_at'];


    public function ClientViewProfile(Request $request){

        try{
            $user = User::select($this->LoginAttributes)->where('id',Auth::id())->first();
            return parent::success("Profile View successfully!",['user' => $user]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }

    public function UpdateClientProfile(Request $request){
        $rules = ['marital_status' => 'required','fname' =>'required','lname' =>'required','email'=>'required','phonecode' =>'required','mobile_no' =>'required'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();

            if (isset($request->profile_picture)):
                $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('vendor'), false);
            endif;
            $phonecode =  str_replace('+','', $request->phonecode);
            $phonecode = '+'.$phonecode;
            $input['phonecode'] = $phonecode;
            $user  = User::FindOrfail(Auth::id());
            $user->fill($input);
            $user->save();
            $update = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            return parent::success("Profile edit successfully!",['user' => $update]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }

    public function Address(Request $request){

        $rules = ['type'=>'required|in:1,2','marital_status'=> 'required|in:1,2,3','fname'=>'required','lname' => 'required','email' =>'required','phonecode'=>'required','mobile_no'=>'required','address' =>'required','city' =>'required','state' =>'required','zipcode' => 'required','country' =>'required','status' =>'required|in:1,2'];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules),true);

        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{
            $input = $request->all();

            if($input['status'] === '1' ):
                Address::where('user_id', Auth::id())->update(['status' => '2']);
            endif;
           
            $input['user_id'] = Auth::id();
            $phonecode = str_replace('+', '', $input['phonecode']);
            $input['phonecode'] = '+'.$phonecode;
            // dd($input['phonecode']);
            
            $address = Address::create($input);
            return parent::success("Address added successfully!",['address' => $address]);
        }catch(\exception $ex){
            return parent::error($ex->getMessage());
        }
    }

    public function EditAddress(Request $request){
        $rules = ['address_id' => 'required|exists:addresses,id','type'=>'required|in:1,2','marital_status'=> 'required|in:1,2,3','fname'=>'required','lname' => 'required','email' =>'required','phonecode'=>'required','mobile_no'=>'required','address' =>'required','city' =>'required','state' =>'required','zipcode' => 'required','country' =>'required'];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules),true);

        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $address = Address::FindOrfail($input['address_id']);
            $phonecode = str_replace('+','', $input['phonecode']);
            $input['phonecode'] = '+'.$phonecode;
          
            $address->fill($input);
            $address->save();
            // $updated = $address->first();
            return parent::success("Address edited successfully!",['address' => $address]);
        }catch(\exception $ex){
            return parent::error($ex->getMessage());
        }
    }

    public function ViewAddress(Request $request){
        $rules= [];
        $validateAttributes= parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{
            $addresses = Address::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
            return parent::success('View addresses successfully!',['addresses' => $addresses]);         
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function Contact(Request $request){
        $rules= ['image'=>'', 'name'=>'required','email' =>'required','phonecode'=>'required','mobile_no' =>'required','order_no' =>'required','comment' =>''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{
            
            $input = $request->all();
            $input['user_id'] =  Auth::id();

            if (isset($request->image)):
                       $input['image'] = parent::__uploadImage($request->file('image'), public_path('vendor'), false);
                   endif;

            $contact = Contact::create($input);
            return parent::success("Your query successfully! submitted!",['contact' => $contact]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());

        }
    }

    public function Home(Request $request){
        // dd(Auth::id());
        $rules = [];
        $validateAttributes=parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{
        //   DB::enableQueryLog();
            $products = Product::
                    select('products.id','products.name','products.image as images','products.amount', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite, favourites.id as favourite_id'))
                    ->leftJoin('ratings', 'ratings.product_id', 'products.id')
                    ->leftJoin('favourites', 'favourites.product_id', 'products.id')
                    ->where('products.status', '1')
                    ->groupBy('products.id')
                    ->orderBy('AverageRating', 'desc')
                    ->take(5)
                    ->get();
                    // dd(DB::getQueryLog($products));
            $category = Category::select('id','title','image')->get();


            $brands = Brand::whereIn('id',[9372,11739,41,9496,2494,162])->get();
         
            
            $recentView = RecentProducts::select('products.id','products.name','products.image','products.amount','recent_products.id','recent_products.user_id','recent_products.product_id','favourites.id as favourite_id',DB::raw('(favourites.status) as favourite'))
            ->where('recent_products.user_id', Auth::id())
            ->leftJoin('favourites', 'favourites.product_id', 'recent_products.product_id')
            ->join('products', 'products.id', '=', 'recent_products.product_id')
            ->where('recent_products.user_id', Auth::id())
            ->take(5)
            ->get();
            $arr = array(
            array('name' => 'Category','type'=> 1,'items'=> $category),
            array('name' =>'Most Popular','type'=> 2,'items' =>$products),
            array('name' => 'Brands','type' => 3,'items' => $brands),
            array('name' => 'Recent Viewed','type' => 4, 'items' => $recentView)
        );
        $cart = Cart::where('user_id', Auth::id())->count();
            return parent::success("Product view successfully",['home' => $arr,'cart_count' => $cart]);
        }catch(\exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function ProductById(Request $request){

        $rules = ['product_id'=> 'required|exists:products,id'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{

            $input = $request->all();
            $product = Product::FindOrfail($input['product_id']);
            $cart_status = Cart::where('product_id',$product->id)->where('user_id', Auth::id())->first();
            $product['CartStatus'] = ($cart_status)? 'added_to_cart':'not_in_cart';
            $product['rating'] = number_format($product->Rating()->avg('rating'),1);
            $product['RatingCount'] = $product->Rating()->count('product_id');
            $product['comment'] = $product->Rating()->select('id','product_id','from','upload','rating','comment','created_at')
            ->get();

            // product variant attributes

            $Attrvariants = VariantItems::select('id','product_id','quantity','price')
                        ->where('variant_items.product_id', $input['product_id'])
                        ->with(['variants'])
                        ->get();

            // end code
            $product['product_variants'] = $Attrvariants;

            foreach($product['comment'] as $key => $commentUser):
               
            $product['comment'][$key]['user'] = User::where('id', $commentUser->from)->select('id', 'fname','lname','profile_picture')->first();
            endforeach;
            $product['soldBy'] = Store::select('id','banner','name')->where('id', $product->store_id)->first();
            $product['soldByOtherSellers'] = Product::select('id','user_id','image','amount')
                                            ->where('name','LIKE','%'.$product->name.'%')
                                            ->whereNotIn('id',[$product->id])
                                            ->with('User')
                                            ->get();

            $OtherProducts = Product::select('products.id','products.user_id','products.name','products.image','products.amount',DB::raw('FORMAT(AVG(ratings.rating),1) as AverageRating, COUNT(product_id) as TotalRating'))
                    ->leftJoin('ratings','ratings.product_id','products.id')
                    ->where('products.user_id', $product->user_id)
                    ->groupBy('products.id')
                    ->get();

            $product['otherProducts'] = $OtherProducts;
            $product['SimilarProducts'] = Product::select('products.id','products.user_id','products.name','products.image','products.amount',DB::raw('FORMAT(AVG(ratings.rating),1) as AverageRating, COUNT(product_id) as TotalRating'))
            ->leftJoin('ratings','ratings.product_id','products.id')
            ->where('products.name','LIKE', '%'.$product->name.'%')
            ->groupBy('products.id')
            ->get();
            RecentProducts::updateOrCreate(['user_id'=> Auth::id(),'product_id' => $request->product_id],[
                'user_id' => Auth::id(),
                'product' => $request->product_id,
                'updated_at' => Carbon::now()
            ]);

            return parent::success("Product view successfully!",['product' => $product]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }



    public function Rating(Request $request){
        $rules = ['product_id'=> 'required|exists:products,id', 'rating'=>'required','upload'=>'','review'=>''];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $input['from'] = Auth::id();
            $input['to'] = $input['product_id'];

            if (isset($request->upload)):
                $input['upload'] = parent::__uploadImage($request->file('upload'), public_path('rating'), false);
            else:
                $input['upload']= "";
            endif;

            $Rating = Rating::create($input);
            return parent::success("Product ratings successfully!",['rating'=> $Rating]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }

    public function Favourite(Request $request){
        $rules = ['product_id' => 'required|exists:products,id','status'=>'required|in:1,2'];

        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $input['by'] = Auth::id();
            $input['to'] = $input['product_id'];
            $favourite = Favourite::updateOrCreate(['by' => Auth::id(),'product_id'=> $input['product_id']],$input);
            return parent::success("Product favourite successfully!",['favourite' => $favourite]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }

    }


    public function FavouriteList(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request,'GET', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
           $input = $request->all();
          $limit =  (isset($input['limit']))? (int)$input['limit']:15; 
       
            $favourites = Favourite::where('by', Auth::id())->where('status','1')->with('Product')
            // ->simplePaginate($limit);   
            ->get();
            foreach($favourites as $key => $favourite):
                $rating = Rating::where('product_id', $favourite->product->id)->avg('rating');
                $comment = Rating::where('product_id', $favourite->product->id)->count('comment');
                $favourites[$key]['product']['rating'] = number_format($rating,1);
                $favourites[$key]['product']['comment'] = $comment;
            endforeach;
            return parent::success("View favourite list successfully",['favourite' => $favourites]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function DeleteFavourite(Request $request){
     
        $rules = ['favourite_id' => 'required|exists:favourites,id'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;

        endif;
        try{
            // DB::enableQueryLog();
            $input = $request->all();
          
            $favourite = Favourite::where('id',$input['favourite_id'])
                                    ->where('by', Auth::id())
                                    ->delete();
            // dd(DB::getQueryLog($favourite));
            return parent::success("Favourite delete successfully!");
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function Card(Request $request)
   {
       $rules = ['card_no' => 'required', 'card_holder_name' => 'required','expiry_date'=>'required','status' => 'required|in:1,2'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);

       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input =  $request->all();
           $input['user_id'] =  Auth::id();
           if($input['status'] === '1'):
            Card::where('user_id', Auth::id())->update(['status' => '2']);
           endif;

           $card = Card::create($input);
        return parent::success("Card Added successfully",['card' => $card]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }

   public function EditCard(Request $request)
   {
       $rules = ['card_id'=>'required|exists:cards,id','card_no' => 'required', 'card_holder_name' => 'required','expiry_date'=>'required'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);

       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input =  $request->all();
    
           $card = Card::find($input['card_id']);
           $card->fill($input);
           $card->save();
        return parent::success("Card edited successfully",['card' => $card]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }

   public function DeleteCard(Request $request)
   {
    $rules = ['card_id'=>'required|exists:cards,id'];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);

    if($validateAttributes):
     return $validateAttributes;
    endif;
    try{
        $input =  $request->all();
 
        $card = Card::find($input['card_id']);
        $card->delete();
     return parent::SuccessMessage("Card deleted successfully");
    }catch(\Exception $ex){
     return parent::error($ex->getMessage());
    }
   }

   public function ViewCard(Request $request)
   {
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);

    if($validateAttributes):
     return $validateAttributes;
    endif;
    try{
 
        $card = Card::where('user_id',Auth::id())->orderby('created_at','DESC')->get();
       
     return parent::success("Card view successfully",['card' => $card]);
    }catch(\Exception $ex){
     return parent::error($ex->getMessage());
    }
   }


   public function Search(Request $request){
    $rules = ['search' => ''];
    $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $seacrh = $input['search'];
        if(isset($seacrh)):
            $product = Product::where('name','LIKE', '%'.$seacrh.'%')->get();
        else:
            $product = Product::get();
        endif;
        
        return parent::success("View search result successfully!",['result' => $product]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }

   public function AddToCart(Request $request)
   {
    $rules=['product_id' => 'required|exists:products,id','quantity' =>'required','vendor_id' => 'required|exists:users,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();

        $cart = Cart::where('product_id',$input['product_id'])->where('user_id', Auth::id());
        if($cart->count() > 0):
            return parent::error("The product already added in your cart");
        endif;
        // dd($cart);

        $input['user_id'] = Auth::id();
        $cart = Cart::create($input);
        return parent::success("Product add to cart successfully!");
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }

   public function AddQuantity(Request $request)
   {
    $rules=['cart_id' => 'required|exists:carts,id','quantity' =>'required|numeric|min:1'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        
        $cart = Cart::FindOrfail($input['cart_id']);
        $cart->quantity = $input['quantity'];
        $cart->save();
        $cart = Cart::where('user_id', Auth::id())->with('product')->orderBy('created_at','DESC')->get();
        return parent::success("Quantity added to cart successfully!",['cart' => $cart]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }


   public function DeleteCartItems(Request $request)
   {
    $rules=['cart_id' => 'required|exists:carts,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        
        $cart = Cart::FindOrfail($input['cart_id']);
        $cart->delete();
       
        $cart = Cart::where('user_id', Auth::id())->with('Product')->get();
        return parent::success("Delete cart item successfully!",['cart' => $cart]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }    

   public function OpenCart(Request $request)
   {
       $rules = [];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $cart = Cart::where('user_id' , Auth::id())
           ->with('Product')
           ->orderBy('created_at','DESC')->get();
           return parent::success("View cart successfully!",['cart' => $cart]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }

   public function TotalCartItems(Request $request)
   {
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
    if($validateAttributes):
     return $validateAttributes;
    endif;
    try{
        $cart = Cart::where('user_id', Auth::id())->count();
     return parent::success("View Total cart successfully!",['cart' => $cart]);
    }catch(\Exception $ex){
     return parent::error($ex->getMessage());
    }
   }


   public function Checkout(Request $request){
    //    dd(Auth::id());
        $rules = [];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $address = Address::select('id','fname','lname','email','phonecode','mobile_no','address','city','state','country','zipcode','status')->where('user_id', Auth::id())
            ->where('status','1')
            ->first();

            $carts = Cart::select('id','user_id','product_id','vendor_id')
            ->where('user_id', Auth::id())
            ->with(['VendorName'])
            ->groupBy('vendor_id')
            ->get();
           
            foreach($carts as $key =>  $cart){

                $carts[$key]['soldBy'] = Cart::select('id','vendor_id','product_id','quantity')
                ->where('vendor_id', $cart->vendor_id)
                ->where('user_id', Auth::id())
                ->with(['Product'])
                ->get();
            }
            
            return parent::success("View Cart successfully!",['address' => $address,'cart' => $carts,'coupon_amount' => 0]);
        }catch(\Exception  $ex){
            return parent::error($ex->getMessage());
        }
   }

   public function Order(Request $request)
   {
       $rules = ['address_id' => 'required|exists:addresses,id', 'card_id' =>'required|exists:cards,id','items' =>'required','sub_total' => 'required','coupon_id' =>'','shipping_cost' => 'required','total_amount' => 'required','stripeToken' => 'required'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
            $input = $request->all();
           
            // Charge for product
       
            $stripe =  \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET'));
            

            // Token is created using Stripe Checkout or Elements!
            // Get the payment token ID submitted by the form:
        $token = $input['stripeToken'];
        // $charge = \Stripe\Charge::create([
        // 'amount' => $input['total_amount']*100,
        // 'currency' => 'usd',
        // 'description' => 'Charge customer to place order',
        // 'source' => $token,
        // ]);
        $input['charge_id'] = md5(rand(11111,99999)); //$token['id'];
        $input['user_id'] = Auth::id();
        $order = Order::create($input);
     
        if(!empty($order)):
            
            $items = Cart::where('user_id', Auth::id())->get();
         
            foreach($items as $item):
                $product = Product::where('id', $item->product_id)->first();
            
                Item::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'address_id' => $input['address_id'],
                    'vendor_id' => $item->vendor_id,
                    'price' => $product->amount,
                    'quantity' => $item->quantity
                ]);
            endforeach;

            Cart::where('user_id', Auth::id())->delete();

           
        endif;
       
            
        return parent::success("Your order Placed successfully!");
       }catch(\Exception $ex){
           return parent::error($ex->getMessage());
       }
   }


   public function ViewOrder(Request $request)
   {
       $rules = [];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $items = Item::where('user_id',Auth::id())->with(['Product'])->get();
            return parent::success("View Orders successfully!",['orders' => $items]);
       }catch(\Exception $ex){
           return parent::error($ex->getMessage());
       }
   }

   public function SetDefaultAddress(Request $request){
     
    $rules = ['address_id' => 'required|exists:addresses,id','status' => 'required|in:1,2'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();

        if($request->status == '1'):
            Address::where('user_id', Auth::id())->update(['status' => '2']);
        endif;
        
        $address = Address::where('id',$request->address_id)
        ->where('user_id',Auth::id())
        ->update(['status' => $request->status]);
        
        $addr = Address::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();
        

        return parent::success("Address set as default",['addresses' => $addr]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }

   }

   public function ViewOrderById(Request $request)
   {
       $rules = ['order_id' => 'required|exists:items,id'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
        $item = Item::where('user_id',Auth::id())
                ->where('id', $input['order_id'])
                ->with(['Product'])
                ->first();
        $address = Address::where('id', $item->address_id)
                ->where('user_id', Auth::id())
                ->first();

        $store = Store::select('id','store_image','name','description')
        ->where('id', $item->product->store_id)
        ->first();
        return parent::success("View order details successfully",['store' => $store,'shipping_address'=>  $address,'order' =>  $item ]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }


   public function RecentlyViewProducts(Request $request)
   {
       $rules = ['limit' => ''];
       $validateAttributes = parent::validateAttributes($request,'GET', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
           if(isset($input['limit'])):
            $limit = ($input['limit'])? $input['limit']:15;
           endif;
         
         
            $product = RecentProducts::where('user_id', Auth::id())
            ->with(['Product'])
            ->simplePaginate($limit);
           
        return parent::success("View products successfully", ['products' =>  $product]);
       }catch(\exception $ex){
        return parent::error($ex->getMessage());
       }
   }

   public function MostPopularsProducts(Request $request){
    $rules = ['limit' => ''];
    $validateAttributes = parent::validateAttributes($request,'GET',$rules, array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{

        $input = $request->all();
        if(isset($input['limit'])){
            $limit = ($input['limit'])? $input['limit']:15;
        }

            $most_popular = Product::
                    select('products.id','products.name','products.image as images','products.amount', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite, favourites.id as favourite_id'))
                    ->leftJoin('ratings', 'ratings.product_id', 'products.id')
                    ->leftJoin('favourites', 'favourites.product_id', 'products.id')
                    // ->where('favourites.by', Auth::id())
                    ->groupBy('products.id')
                    ->orderBy('AverageRating', 'desc')
                    ->simplePaginate($limit);   
        
        return parent::success("View Most popular Products successfully!",['products'=> $most_popular]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function ClientViewStore(Request $request)
   {
       $rules = ['store_id' => 'required|exists:stores,id','product_id'=> 'required|exists:products,id'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
            $input = $request->all();
            $store = Store::where('id', $input['store_id'])->first();
            $products = Product::select('id','image','name','amount')
                                ->where('user_id',$store->user_id)
                                ->where('store_id',$store->id)
                                ->get();

            foreach($products as $key => $product):
                $products[$key]['rating'] = number_format($product->Rating()->avg('rating'),1);
                $products[$key]['RatingCount'] = $product->Rating()->count('product_id');
            endforeach;
           
            $Product_ratings = Rating::where('product_id', $input['product_id'])->with(['User'])->get();
            $Averagerating = Rating::where('product_id', $input['product_id'])->with(['User'])->avg('rating',1);
            $ratingCount = Rating::where('product_id', $input['product_id'])->with(['User'])->count();
        return parent::success("View store details successfully!",['AverageRating'=> Number_format($Averagerating,1) ,'RatingCount'=> $ratingCount,'store' => $store,'products' => $products,'product_ratings' => $Product_ratings]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }

   }

































}
