<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helper;
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
//use Usps;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\Return_;
use App\Mail\EmailVerificationMail;
use App\Models\Address;
use App\Models\Brand;
use App\Models\cancellation;
use App\Models\Card;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Discount;
use App\Models\Favourite;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\RecentProducts;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\UserChat;
use App\Models\Variant;
use App\Models\VariantItems;
use Attribute;
use GrahamCampbell\ResultType\Success;
use Illuminate\Cache\RateLimiting\Limit;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;
use Symfony\Contracts\Service\Attribute\Required;

class ClientController extends ApiController
{
    public $successStatus = 200;
    private $LoginAttributes  = ['id','fname','lname','email','phonecode','mobile_no','profile_picture','marital_status','type','status','is_switch','vendor_status','token','created_at','updated_at'];


    public function ClientViewProfile(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            array_push($this->LoginAttributes,'apple_id','google_id','amazon_id','facebook_id');
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
    //    dd(Auth::id());
        $rules = [];
        $validateAttributes=parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{
        //   DB::enableQueryLog();
            $products = Product::
                    select('products.id','products.name','products.image as images','products.discount', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite, favourites.id as favourite_id, products.price as amount'))
                    ->leftJoin('ratings', 'ratings.product_id', 'products.id')
                    ->leftJoin('favourites', 'favourites.product_id', 'products.id')
                    ->where('products.status', '1')
                    ->with(['discount'])
                    ->groupBy('products.id')
                    ->orderBy('AverageRating', 'desc')

                    // ->take(5)
                    ->get();
                    // dd(DB::getQueryLog($products));
            $category = Category::select('id','title','image')->get();


            $brands = Brand::whereIn('id',[9372,11739,41,9496,2494,162])->get();
         
            DB::enableQueryLog();
            $recentView = RecentProducts::select(DB::raw('products.id as id, recent_products.id as recent_id '),'products.name','products.image','recent_products.user_id','recent_products.product_id','products.discount',DB::raw("CONVERT(favourites.id, CHAR) as FavouriteId, products.price as amount"),DB::raw('(favourites.status) as favourite'))
            
            ->leftJoin('favourites', 'favourites.product_id', 'recent_products.product_id')
            ->join('products', 'products.id', '=', 'recent_products.product_id')
            ->where('recent_products.user_id', Auth::id())
            ->where('favourites.by', Auth::id())
            ->groupBy('products.id')
            // ->take(5)
            ->get();
           // dd(DB::getQueryLog($recentView));
            foreach($recentView as $key => $value):
                $images = explode(",", $value->image);
                $recentView[$key]['images'] = $images;
                $recentView[$key]['discount'] = Discount::select('id','percentage','description')->where('id',$value->discount)->first();
                $recentView[$key]['base_url'] = asset('/products');
            endforeach;

            $discount = Discount::orderBy('id','DESC')->take(5)->get();



            $arr = array(
            array('name' => 'Category','type'=> 1,'items'=> $category),
            array('name' =>'Most Popular','type'=> 2,'items' =>$products),
            array('name' => 'Brands','type' => 3,'items' => $brands),
            array('name' => 'Recent Viewed','type' => 4, 'items' => $recentView),
           
        );
        $cart = Cart::where('user_id', Auth::id())->count(); 
            return parent::success("Product view successfully",['home' => $arr,'cart_count' => $cart,'discount' => $discount]);
        }catch(\exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function ProductById(Request $request){

        $rules = ['product_id'=> 'required|exists:products,id'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{

            $input = $request->all();
            $product = Product::where('id',$input['product_id'])->with(['Offer','Discount','Stock'])->first();
          
            $product['rating'] = number_format($product->Rating()->avg('rating'),1);
            $product['RatingCount'] = $product->Rating()->count('product_id');
            $product['comment'] = $product->Rating()->select('id','product_id','from','upload','rating','comment','created_at')
            ->get();
            $product['product_specifications'] = Product::select('weight','brand','color','quantity')->where('id', $request->product_id)->first()->makeHidden(['soldBy','CartStatus','base_url','FavouriteId','favourite']);

            $variants = Variant:: where('product_id', $input['product_id'])->take(1)->orderBy('created_at','DESC')->get();
             
            if( $variants):
                
                endif;
                        foreach($variants as $key => $variant){
                            $option_id = explode(",",$variant['option_id']);
                            // dd($attr_id);
                            
             $variants[$key]['variants'] = \App\Models\Attribute::select('attributes.id','attributes.name', DB::raw('attribute_options.id AS option_id, attribute_options.name AS option_name'))
                            ->join("attribute_options","attributes.id","attribute_options.attr_id")
                            ->whereIn('attribute_options.id', $option_id)
                            ->get();
            
                        }        

                $Attrvariants = App\Models\Attribute::select('id','product_id','name')
                                            ->where('product_id', $input['product_id'])
                                            ->with(['Option'])
                                            ->get();
                                  //dd($Attrvariants);   
            // end code
            $product['SelectedVariant'] = $variants;
            $product['product_variants'] = $Attrvariants;
            foreach($product['comment'] as $key => $commentUser):
               
            $product['comment'][$key]['user'] = User::where('id', $commentUser->from)->select('id', 'fname','lname','profile_picture')->first();
            endforeach; 
            $product['soldByOtherSellers'] = Product::select('id','store_id','user_id','image',DB::raw('price as amount'))
                                            ->where('name','LIKE','%'.$product->name.'%')
                                            ->whereNotIn('id',[$product->id])
                                            ->orderBy('created_at','DESC')
                                            ->with('User')
                                            ->get()->makeHidden(['soldBy']);

            $OtherProducts = Product::select('products.id','products.user_id','products.name','products.image',DB::raw('FORMAT(AVG(ratings.rating),1) as AverageRating, COUNT(product_id) as TotalRating, products.price as amount'))
                    ->leftJoin('ratings','ratings.product_id','products.id')
                    ->where('products.user_id', $product->user_id)
                    ->groupBy('products.id')
                    ->get()->makeHidden(['soldBy','CartStatus']);

            $product['otherProducts'] = $OtherProducts;
            $product['SimilarProducts'] = Product::select('products.id','products.user_id','products.name','products.image',DB::raw('FORMAT(AVG(ratings.rating),1) as AverageRating, COUNT(product_id) as TotalRating, products.price as amount'))
            ->leftJoin('ratings','ratings.product_id','products.id')
            ->where('products.name','LIKE', '%'.$product->name.'%')
            ->groupBy('products.id')
            ->get()->makeHidden(['soldBy','CartStatus']);
            RecentProducts::updateOrCreate(['user_id'=> Auth::id(),'product_id' => $request->product_id],[
                'user_id' => Auth::id(),
                'product' => $request->product_id,
                'updated_at' => Carbon::now()
            ]);

            

            return parent::success("Product view successfully!",['product' => $product->jsonserialize()]);
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
            $message = '';
            if($request->status === '1'):
                $message = 'Product favourite successfully!';
                elseif($request->status === '2'):
                    $message = 'Product Unfavourite successfully!';
            endif;
            return parent::success($message, ['favourite' => $favourite]);
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
            ->simplePaginate($limit);   
            // ->get();
            // dd($favourites->toArray());
            foreach($favourites as $key => $favourite):
                if($favourite->product){
                    $rating = Rating::where('product_id', $favourite->product->id)->avg('rating');
                    $comment = Rating::where('product_id', $favourite->product->id)->count('comment');
                    $favourites[$key]['product']['rating'] = number_format($rating,1);
                    $favourites[$key]['product']['comment'] = $comment;
                }
                
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
       $rules = ['card_no' => 'required', 'card_holder_name' => 'required','expiry_date'=>'required','status' => 'required|in:1,2','token'=> ''];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);

       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input =  $request->all();
           $explode = explode("/", $input['expiry_date']);
           $input['expiry_month'] = $explode[0];
           $input['expiry_year'] = $explode[1];
           $input['user_id'] =  Auth::id();
           if($input['status'] === '1'):
            Card::where('user_id', Auth::id())->update(['status' => '2']);
           endif;

           $card = Card::create($input);
         
        $NewCard = Card::where('id',$card->id)->first();
        $NewCard['expiry_date'] = $NewCard['expiry_month'].'/'.$NewCard['expiry_year'];
        return parent::success("Card Added successfully",['card' => $NewCard]);
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
    $rules = ['search' => '','limit'=>'','page'=>''];
    $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $seacrh = $input['search'];
        $limit = (isset($request->limit))?$request->limit:15;
        if(isset($seacrh)):
            $product = Product::where('name','LIKE', '%'.$seacrh.'%')->with(['Discount'])->paginate($limit);
        else:
            $product = Product::with(['Discount'])->paginate($limit);
        endif;
        
        return parent::success("View search result successfully!",['result' => $product]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }

   public function AddToCart(Request $request)
   {
    $rules=['product_id' => 'required|exists:products,id','quantity' =>'required','vendor_id' => 'required|exists:users,id','variant_id' =>''];
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
           ->with('Product','CustomerVariant')
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

            $carts = Cart::select('id','user_id','product_id','vendor_id','variant_id')
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
            $Address = true;//Helper::VerifyAddress($request->address_id);
           
            if($Address):

                $stripe =  \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET'));
            
                    // Token is created using Stripe Checkout or Elements!
                    // Get the payment token ID submitted by the form:
                $token = $input['stripeToken'];
                // $charge = \Stripe\Charge::create([
                // 'amount' => ($input['total_amount'] * 100),
                // 'currency' => 'usd',
                // 'description' => 'Charge customer to place order',
                // 'source' => $token,
                // ]);
                $input['charge_id'] = md5(rand(11111,99999)); //$charge['id'];
                $input['user_id'] = Auth::id();

                $order = Order::create($input);
                if(!empty($order)):
                
                
                    $items = Cart::where('user_id', Auth::id())->with(['Product'])->get();
                   $test = [];
                
                    foreach($items as $item){
                        $product = Product::where('id', $item->product_id)->first();
                
                        $item =  Item::create([
                                'user_id' => Auth::id(),
                                'order_id' => $order->id,
                                'product_id' => $product->id,
                                'variant_id' => ($item->variant_id)?$item->variant_id:null,
                                'offer_id'   => ($item->product->offer)?$item->product->offer->id:null,
                                'address_id' => $input['address_id'],
                                'vendor_id' => $item->vendor_id,
                                'price' => $product->price,
                                'quantity' => $item->quantity
                        ]);
               
                        $trans = Transaction::create([
                            'user_id' => Auth::id(),
                            'card_id' => $request->card_id,
                            'order_id' =>  $item->id,
                            'transaction_id' => $order->charge_id,
                            'vendor_id'  => $item->vendor_id,
                            'product_id'  => $product->id,
                            'price' => $order->total_amount,
                            'order_date' => date('Y-m-d')
                        ]);
     
                        if($item){
                            $store = Store::where('id',$product->store_id)->first();
                        
                            $tracking_id = "46768273648723648234762";//Helper::UPSP($item, $product->id ,$input['address_id'], $item->vendor_id,  $store->id);
     
                            if($tracking_id):
                                $updatetrackingId = Item::FindOrfail($item->id);
                                                    $updatetrackingId->fill(['tracking_id'=> $tracking_id]);
                                                    $updatetrackingId->save();
                            endif;
                            $StoreName = (!$store)?'No-name':$store->name;
                            $body = '#00'.$item->id.' has been ordered from '.$StoreName;
                       
                            $notification = array('title' =>'product Order' , 'body' => $body, 'sound' => 'default', 'badge' => '1');
                        
                            $arrayToSend = array(
                                'to' => $item['vendor_id'],
                                'title' =>'product Order',
                                'body' => $body,
                                'payload' => array('order_id'=>$item->id,'image'=>$product->image[0],'base_url'=> asset('/products'),'notification'=>$notification,'data'=>$notification),'priority'=>'high'
                                );
                              
                          
                            parent::pushNotifications($arrayToSend, Auth::id(), $item['vendor_id']);
                      
                             //    below client notification
                            parent::pushNotifications($arrayToSend, $item->vendor_id, Auth::id());
                        
                        }
                        
            
                    }
         
                   // Cart::where('user_id', Auth::id())->delete();
                    return parent::success("Your order Placed successfully!");
                endif;   
            else:
                return parent::error("Selected address is invalid");
            endif;
           
        }catch(\Exception $ex){
           return parent::error($ex->getMessage());
        }
    }


   public function ViewOrder(Request $request)
   {
       $rules = ['type' => 'required|in:1,2,3,4','search'=>'', 'sort'=>''];
      
       $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
       if($validateAttributes):
        return $validateAttributes;
       endif;

       try{
            $input  = $request->all();
            if($request->type === '1'){
                $items = Item::where('user_id',Auth::id())->where('status','1')->with(['Product'])->orderBy('created_at','DESC')->get();
            }else if($request->type === '2'){
                $items = Item::where('user_id',Auth::id())->where('status','2')->with(['Product'])->orderBy('created_at','DESC')->get();
            }else if($request->type === '3'){
                $items = Item::where('user_id',Auth::id())->where('status','3')->with(['Product'])->orderBy('created_at','DESC')->get();
            }elseif($request->type === '4'){
                
            
                $items = Item::select('items.*','products.name')->where('items.user_id',Auth::id())
                            ->Join('products','products.id','items.product_id');
                if(isset($request->search)){
                    $items = $items->where('products.name','LIKE', '%'.$request->search.'%');        
                }
                $items = $items->with(['Product'])->orderBy('items.created_at','DESC');
            if(isset($request->sort)){
                    
                    
                if($request->sort == 1){
                    $items = $items->whereDate('items.created_at','>=', Carbon::today()->subDays(7) );            
                }elseif($request->sort == 2){
                    $items = $items->whereDate('items.created_at','>=', Carbon::today()->subDays(30) );  
                }elseif($request->sort == 3){
                    $items = $items->whereDate('items.created_at','>=', Carbon::today()->subDays(182) );
                }elseif($request->sort == 4){
                    $items = $items->whereYear('items.created_at', Carbon::today()->subDays(365) );  
                }
                    
            }
                    $items = $items->get();
        }
            return parent::success("View Orders successfully!",['orders' => $items]);
       }catch(\Exception $ex){
           return parent::error($ex->getMessage());
       }
   }


   public function ViewVendorOrder(Request $request)
   {
       $rules = ['type' => 'required|in:1,2,3,4','search' => ''];
       $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
       if($validateAttributes):
        return $validateAttributes;
       endif;

       try{
            $input  = $request->all();
            if($request->type === '1'){
                $items = Item::where('vendor_id',Auth::id())->where('status','1')->with(['Product'])->orderBy('created_at','DESC')->get();
            }else if($request->type === '2'){
                $items = Item::where('vendor_id',Auth::id())->where('status','2')->with(['Product'])->orderBy('created_at','DESC')->get();
            }else if($request->type === '3'){
                $items = Item::where('vendor_id',Auth::id())->where('status','3')->with(['Product'])->orderBy('created_at','DESC')->get();
            }else if($request->type === '4'){
                $items = Item::select('items.*','products.name')->where('vendor_id',Auth::id())
                            ->Join('products','products.id','items.product_id');
                if(isset($request->search)){
                    $items = $items->where('products.name','LIKE', '%'.$request->search.'%');        
                }
                $items = $items->with(['Product'])->orderBy('items.created_at','DESC')->get();
            }

           
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
      // dd(Auth::id());
       $rules = ['order_id' => 'required|exists:items,id','type'=>'','notification_id'=>''];
       $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
        $item = Item::where('user_id',Auth::id())
                ->where('id', $input['order_id'])
                ->with(['Product','MyRating','Offer'])
                ->first();
                if($item){
                    $tracking_id = Helper::trackCourier($item->tracking_id);
                if($tracking_id):
                    $item['tracking_status'] =   $tracking_id;  
                else:
                    $item['tracking_status'] = ['error' => "tracking status of tracking id not available yet"];
                endif;

                $address = Address::where('id', $item->address_id)
                ->where('user_id', Auth::id())
                ->first();

                $store = Store::select('id','store_image','name','description')
                ->where('id', $item->product->store_id)
                ->first();
        
                if(isset($request->type) && isset($request->notification_id)){
                    if($request->type === '1'):
                        Notification::where('id', $request->notification_id)->update(['is_read' => '1']);
                    endif;
                }
                 $item['CardDetails'] = Order::select('id','card_id')
                 ->where('id',$item->order_id)->with(['Card'])->first();
                 $item['coupon'] = '0';
                return parent::success("View order details successfully",['store' => $store,'shipping_address'=>  $address,'order' =>  $item ]);

                }else{
                  return parent::error("Invalid product item id");
                }
 
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
         
         
            $product = RecentProducts::orderBy('created_at', 'DESC')
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
                    select('products.id','products.user_id','products.name','products.image as images','products.is_variant', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite, favourites.id as favourite_id, products.price as amount'))
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
            $about = User::select('id','name','fname','lname','profile_picture')->where('id',$store->user_id)->first();
            $viewProductDetails = Product::select('id','name','image','price')
            ->where('id', $request->product_id)
            ->with(['PorductRating'])
            ->first();

            $products = Product::select('id','image','name','amount')
                                ->where('user_id',$store->user_id)
                                ->where('store_id',$store->id)
                                ->get();

            foreach($products as $key => $product):
                $products[$key]['rating'] = number_format($product->Rating()->avg('rating'),1);
                $products[$key]['RatingCount'] = $product->Rating()->count('product_id');

                $products[$key]['AverageRating'] = number_format($product->Rating()->avg('rating'),1);
                $products[$key]['TotalComments'] = $product->Rating()->count('product_id');
            endforeach;
           
            $Product_ratings = Rating::where('product_id', $input['product_id'])->with(['User'])->get();
            $Averagerating = Rating::where('product_id', $input['product_id'])->with(['User'])->avg('rating',1);
            $ratingCount = Rating::where('product_id', $input['product_id'])->with(['User'])->count();
        return parent::success("View store details successfully!",['AverageRating'=> Number_format($Averagerating,1) ,'RatingCount'=> $ratingCount,'store' => $store,'product_details' =>  $viewProductDetails,'products' => $products,'product_ratings' => $Product_ratings,'about' => $about]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }

   }

  
   public function SearchVariants(Request $request)
   {
    $rules = ['variant' => 'required','product_id' => 'required|exists:products,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $message = '';
        $combinations = json_decode($request->variant, true);
    //   dd($combinations['attr_id']);
        $arr = [];
        // foreach($variants as $variant){
        //     $combination = Variant::where('product_id', $variant['product_id'])
        //             ->where('attr_id', $variant['attr_id'])
        //             ->where('option_id', $variant['option_id'])
        //             ->where('variant_item_id', $variant['variant_id'])
        //             ->first();
            //    dd($combination);
            // if(is_null($combination) === true){
               
            //     return parent::error("This variant not available");
            // }else{
            //     array_push($arr, $combination->variant_item_id);
            // }
        // }
        // dd($arr);
       // $variantItem = VariantItems::whereIn('id', $arr)->first()->toArray();
            $variants = Variant:: where('product_id', $input['product_id'])
            ->where('attr_id', $combinations['attr_id'])
            ->where('option_id', $combinations['option_id'])
            ->first();
 
            $attr_id = explode(",",$combinations['attr_id']);
            $option_id = explode(",",$combinations['option_id']);
            if($variants):
                $variants['attributes'] = \App\Models\Attribute::select('attributes.id','attributes.name', DB::raw('attribute_options.id AS option_id, attribute_options.name AS option_name'))
                ->join("attribute_options","attributes.id","attribute_options.attr_id")
                ->whereIn('attribute_options.attr_id', $attr_id)
                ->whereIn('attribute_options.id', $option_id)
                ->get();
                $message = "view variant successfully!";
            else:
                $message="Variant not found!";
            endif;
        $product = Product::select('id','name',DB::raw('price as amount'))->where('id', $request->product_id)->first()->makeHidden(['base_url','favourite','FavouriteId','CartStatus','soldBy']);
            

            return parent::success($message,['product' =>$product,'variants' =>  $variants]);
        
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }


   public function CreateOffer(Request $request)
   {
       $rules = ['product_id' => 'required|exists:products,id','vendor_id'=>'required|exists:users,id','name'=>'required','email'=>'required','phonecode' =>'required','mobile_no'=>'required','quantity'=>'required','offer_price'=>'required','comment' =>'', 'variant_id'=>''];
       $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input =  $request->all();
           $phonecode = str_replace('+','',$input['phonecode']);
           $input['phonecode'] = '+'.$phonecode;
         
           $input['user_id'] = Auth::id();
           $offer = Offer::create($input);
           $offer['product_id'] = intval($offer['product_id']);
           $offer['vendor_id'] = intval($offer['vendor_id']);
           $offer['vendor'] = User::select('id','name','fname','lname','profile_picture')->where('id',$offer['vendor_id'])->first();
            return parent::success("Offer sent successfully!",['offer' =>  $offer]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }

   public function UspsVerifyAddress(Request $request)
   {
        $rules = [];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            

            return parent::success("view address successfully!");

        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }



   public function UspsFindAddressByZip(Request $request)
   {
        $rules = ['zipcode' =>'required'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $input_xml = <<<EOXML
            <ZipCodeLookupRequest USERID="778CONSI5321">
                <Address ID="0">
                    <Address1></Address1>
                    <Address2>6406 Ivy Lane</Address2>
                    <City>Greenbelt</City>
                    <State>MD</State>
                </Address>
            </ZipCodeLookupRequest>
            EOXML;
            
            $fields = array('API' => 'ZipCodeLookup','XML' => $input_xml);
            
            $url = 'http://production.shippingapis.com/ShippingAPITest.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
            
            // Convert the XML result into array
            $array_data = json_decode(json_encode(simplexml_load_string($data)), true);

            return parent::success("view address successfully!", $array_data);

        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }

   public function UspsTrackCourier(Request $request)
   {
        $rules = ['track_id' =>'required'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $input_xml = <<<EOXML
                    <TrackRequest USERID="641IHERB6005">
                        <TrackID ID="$request->track_id"></TrackID>
                    </TrackRequest>
            EOXML;
            
            $fields = array('API' => 'TrackV2','XML' => $input_xml);
            
            $url = 'https://stg-secure.shippingapis.com/ShippingAPI.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
           
            // Convert the XML result into array
            $array_data = json_decode(json_encode(simplexml_load_string($data)), true);
            $arr = [];
            $newString="";
            dd($array_data);
            foreach($array_data['TrackInfo']['TrackDetail'] as $key => $track):
        
        $extract_date_pattern = "/(January|February|March|April|May|June|July|Augest|September|October|November|December)\s\d{2},\s{1}\d{4}/";
            $string_to_match = $track;
                if ( preg_match_all($extract_date_pattern, $string_to_match, $matches) ) {
                    
                $newdate =  date('m/d/Y',strtotime($matches[0][0]));
                $newString = str_replace($matches[0][0],  $newdate,  $string_to_match);
                //   echo $newString."<br>"; 
                $string_to_match = $newString;
                }
                $arr[] = explode(",", $string_to_match);

              
           
            endforeach;
           
            // dd($arr);
          
            return parent::success("view address successfully!", $arr);

        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }





   public function UspsFindRate(Request $request)
   {
        $rules = ['original_zip'=>'required','destination_zip'=>'required','pounds'=>'required','ounces'=>'required','width'=>'required','height'=>'required','length'=>'required'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $input_xml = <<<EOXML
                <RateV4Request USERID="778CONSI5321">
                <Revision>2</Revision>
                <Package ID="1">
                <Service>PRIORITY</Service>
                <ZipOrigination>$request->original_zip</ZipOrigination>
                <ZipDestination>$request->destination_zip</ZipDestination>
                <Pounds>$request->pounds</Pounds>
                <Ounces>$request->ounces</Ounces>
                <Container></Container>
                <Width>$request->width</Width>
                <Length>$request->length</Length>
                <Height>$request->height</Height>
                <Girth></Girth>
                <Machinable>TRUE</Machinable>
                </Package>
                </RateV4Request>
            EOXML;
            
            $fields = array('API' => 'RateV4','XML' => $input_xml);
            
            $url = 'http://production.shippingapis.com/ShippingAPITest.dll?' . http_build_query($fields);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
            $data = curl_exec($ch);
            curl_close($ch);
            
            // Convert the XML result into array
            $array_data = json_decode(json_encode(simplexml_load_string($data)), true);

            return parent::success("view address successfully!", $array_data);

        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function ProductFilter(Request $request)
   {
   
     $rules = ['limit' =>'','page'=>'','price' =>'','brand'=>'', 'color'=>'','mile_radius' =>'','material_type'=>'','search'=>'','type'=>'required|in:1,2,3,4,5','subcategory_id'=>'','price_filter' =>''];
     $validateAttributes = parent::validateAttributes($request,'GET',$rules, array_keys($rules),false);
     if($validateAttributes):
        return $validateAttributes;
     endif;
     try{
        $input = $request->all();
        $limit = (isset($input['limit']))? $input['limit']:15;
        $page  = (isset($input['page']))? $input['page']:0;
        $offset = $limit*$page; 
        $products = [];
        // Recent View products
        if($request->type === '2'){
            $product = new Product();
         
        $RecentlyViewProduct = RecentProducts::select('products.id','products.subcategory_id','recent_products.product_id','products.user_id','products.brand','products.store_id','products.name','products.image as images','products.price', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite, favourites.id as FavouriteId'))
            ->Join('products', 'recent_products.product_id', 'products.id')
            ->leftJoin('ratings', 'ratings.product_id', 'products.id')
            ->leftJoin('favourites', 'favourites.product_id', 'products.id');

            if(isset($request->price)){
                $price = array_map('intval', explode(",", $input['price']));
                $RecentlyViewProduct = $RecentlyViewProduct->whereBetween('price', $price);
            }
            if(isset($request->color)){
                $RecentlyViewProduct= $RecentlyViewProduct->where('color', $request->color);
            }
            if(isset($request->brand)){
                $RecentlyViewProduct = $RecentlyViewProduct->where('brand', $request->brand);
            }
            if(isset($request->search)){
                // dd($request->search);
                $RecentlyViewProduct = $RecentlyViewProduct->where('name','LIKE', '%'.$request->search.'%');
            }
            if(isset($request->price_filter) && $request->price_filter == '1'){
                // dd($request->search);
                $RecentlyViewProduct = $RecentlyViewProduct->orderBy('ratings.rating', 'DESC');
            }
            if(isset($request->price_filter) && $request->price_filter == '2'){
                // dd($request->search);
                $RecentlyViewProduct = $RecentlyViewProduct->orderBy('products.price', 'ASC');
            }
            if(isset($request->price_filter) && $request->price_filter == '3'){
                // dd($request->search);
                $RecentlyViewProduct = $RecentlyViewProduct->orderBy('products.price', 'DESC');
            }
            
            

            $RecentlyViewProduct = $RecentlyViewProduct->groupBy('products.id')->paginate($limit);

            foreach($RecentlyViewProduct as $key => $recent){
                // dd($recent->toArray());
                $RecentlyViewProduct[$key]['images'] = explode(',', $recent->images);
                $RecentlyViewProduct[$key]['soldBy'] =  Store::select('id','banner','name')->where('id', $recent->store_id)->first();
                $RecentlyViewProduct[$key]['base_url'] = asset('products');
            }
            // dd($RecentlyViewProduct->toArray());
            
            $products = $RecentlyViewProduct;


        }else if($request->type === '1'){
     
            $mostPopular = new Product();
       
            $mostPopular = $mostPopular
            ->select('products.id','products.subcategory_id','products.user_id','products.brand','products.store_id','products.name','products.image as images','products.price', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite'))
                    ->leftJoin('ratings', 'ratings.product_id', 'products.id')
                    ->leftJoin('favourites', 'favourites.product_id', 'products.id');
         
                if(isset($request->search)){
                    $mostPopular = $mostPopular->where('products.name', 'LIKE', '%'.$request->search.'%');
                }
                    if(isset($request->price)){
                        $price = array_map('intval', explode(",", $input['price']));
                        $mostPopular = $mostPopular->whereBetween('price', $price);
                    }
                    if(isset($request->color)){
                        $mostPopular = $mostPopular->where('color', $request->color);
                    }

                    if(isset($request->brand)){
                        $mostPopular = $mostPopular->where('brand', $request->brand);
                    }
                    
                    if(isset($request->price_filter) && $request->price_filter == '1'){
                        // dd($request->search);
                        $mostPopular = $mostPopular->orderBy('ratings.rating', 'DESC');
                    }
                    if(isset($request->price_filter) && $request->price_filter == '2'){
                        // dd($request->search);
                        $mostPopular = $mostPopular->orderBy('products.price', 'ASC');
                    }
                    if(isset($request->price_filter) && $request->price_filter == '3'){
                        // dd($request->search);
                        $mostPopular = $mostPopular->orderBy('products.price', 'DESC');
                    }

                    // ->where('favourites.by', Auth::id())
                    $mostPopular = $mostPopular->groupBy('products.id')
                                            ->orderBy('AverageRating', 'desc')
                                            ->paginate($limit);
                                           
                     
                    $products = $mostPopular;
                 

        }else if($request->type === '3'){
            $newProducts = new Product();
            $newProducts = $newProducts->select('id','subcategory_id','user_id','store_id','name','image','price','brand');
            
            if(isset($request->search)){
                $newProducts = $newProducts->where('name', 'LIKE', '%'.$request->search.'%');
            }

            if(isset($request->price)){
                $price = array_map('intval', explode(",", $input['price']));
                $newProducts = $newProducts->whereBetween('price', $price);
            }
            if(isset($request->color)){
                $newProducts = $newProducts->where('color', $request->color);
            }

            if(isset($request->brand)){
                $newProducts = $newProducts->where('brand', $request->brand);
            }

            if(isset($request->price_filter) && $request->price_filter == '1'){
                // dd($request->search);
                $newProducts = $newProducts->orderBy('ratings.rating', 'DESC');
            }
            if(isset($request->price_filter) && $request->price_filter == '2'){
                // dd($request->search);
                $newProducts = $newProducts->orderBy('products.price', 'ASC');
            }
            if(isset($request->price_filter) && $request->price_filter == '3'){
                // dd($request->search);
                $newProducts = $newProducts->orderBy('products.price', 'DESC');
            }


            $newProducts = $newProducts->orderBy('created_at','DESC')->paginate($limit);
            $products = $newProducts;
        }else if($request->type === '4'){
         
            $brand = new Product();
                DB::enableQueryLog();
            $brand = $brand->select('products.id','products.subcategory_id','products.user_id','products.brand','products.store_id','products.name','products.image as images','products.price', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite, favourites.id as favourite_id'))
                    ->leftJoin('ratings', 'ratings.product_id', 'products.id')
                    ->leftJoin('favourites', 'favourites.product_id', 'products.id');

                    if(isset($request->search)){
                        $brand = $brand->where('products.brand', 'LIKE', '%'.$request->search.'%');
                    }
                    if(isset($request->price)){
                        $price = array_map('intval', explode(",", $input['price']));
                        $brand = $brand->whereBetween('price', $price);
                    }
                    if(isset($request->color)){
                        $brand = $brand->where('color', $request->color);
                    }

                    if(isset($request->brand)){
                        $brand = $brand->where('brand', $request->brand);
                    }
                    
                    if(isset($request->price_filter) && $request->price_filter == '1'){
                        // dd($request->search);
                        $brand = $brand->orderBy('ratings.rating', 'DESC');
                    }
                    if(isset($request->price_filter) && $request->price_filter == '2'){
                        // dd($request->search);
                        $brand = $brand->orderBy('products.price', 'ASC');
                    }
                    if(isset($request->price_filter) && $request->price_filter == '3'){
                        // dd($request->search);
                        $brand = $brand->orderBy('products.price', 'DESC');
                    }

                    // ->where('favourites.by', Auth::id())
                    $brand= $brand->groupBy('products.id')
                                            ->orderBy('AverageRating', 'desc')
                                            ->paginate($limit);
                                            // dd(DB::getQueryLog($brand));
                    $products = $brand;

        }else if($request->type === '5'){
         
            $sub_category = new Product();
             
                $sub_category = $sub_category->select('products.id','products.subcategory_id','products.user_id','products.brand','products.store_id','products.name','products.image as images','products.price', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite, favourites.id as favourite_id'))
                    ->leftJoin('ratings', 'ratings.product_id', 'products.id')
                    ->leftJoin('favourites', 'favourites.product_id', 'products.id');

                    if(isset($request->subcategory_id)){
                        $sub_category = $sub_category->where('products.subcategory_id',$request->subcategory_id);
                    }
                    if(isset($request->price)){
                        $price = array_map('intval', explode(",", $input['price']));
                        $sub_category = $sub_category->whereBetween('price', $price);
                    }
                    if(isset($request->color)){
                        $sub_category = $sub_category->where('color', $request->color);
                    }

                    if(isset($request->brand)){
                        $sub_category = $sub_category->where('brand', $request->brand);
                    }


                    if(isset($request->price_filter) && $request->price_filter == '1'){
                        // dd($request->search);
                        $sub_category = $sub_category->orderBy('ratings.rating', 'DESC');
                    }
                    if(isset($request->price_filter) && $request->price_filter == '2'){
                        // dd($request->search);
                        $sub_category = $sub_category->orderBy('products.price', 'ASC');
                    }
                    if(isset($request->price_filter) && $request->price_filter == '3'){
                        // dd($request->search);
                        $sub_category = $sub_category->orderBy('products.price', 'DESC');
                    }

                    
                    // ->where('favourites.by', Auth::id())
                    $sub_category= $sub_category->groupBy('products.id')
                                            ->orderBy('AverageRating', 'desc')
                                            ->paginate($limit);
                                            // dd(DB::getQueryLog($brand));
                    $products = $sub_category;

        }
     
        return  response()->json([
                    'status' => true,
                    'code' => 200,
                    'message'=> 'filter product view successfully!', 
                    'products' => $products
            ]);
        // parent::success("filter product view successfully!", $products);
     }catch(\Exception $ex){
        return parent::error($ex->getMessage());
     }
   }


   public function getOfferDetailBy(Request $request)
   {
       $rules = ['offer_id' => 'required|exists:offers,id'];
       $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
           $offer = Offer::where('id',$request->offer_id)->with(['Product'])->first();
           return parent::success("View offer details successfully!", $offer);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }

   public function UserChat(Request $request){
    
    $rules = ['reciever_id' => 'required','page'=>'','limit'=>''];

    $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
        endif;
    try{
        // Dev:Ashish Mehra
        $input = $request->all();
        $limit = 15;
        $page = 0;
        if(isset($request->limit)){
            $limit = ($request->limit)? $request->limit:15;
        }
        if(isset($request->page)){
            $page=($request->page)? $request->page:0;
        }
        $offset = $page*$limit;
    
        $reciever_id = $input['reciever_id'];
        $user_id = Auth::id();
        if(!empty($user_id) && $reciever_id!=''){
        
    //   mycode
    // $sql = "SELECT DISTINCT sender.fname as senderName ,sender.id as sender_id, sender.profile_picture as sender_profile_picture,receiver.fname as receiverName, receiver.id as receiver_id, receiver.profile_picture as receiver_profile_picture,msg.message,msg.created_on,msg.status as readStatus,msg.MessageType,IF((select COUNT(*) from chat_deleteTB where deleteByuserID='".$user_id."' AND ChatParticipantID='".$reciever_id."'>0),1,0) as chatDelRow FROM user_chat msg INNER JOIN users sender ON msg.source_user_id = sender.id
    // INNER JOIN users receiver ON msg.target_user_id = receiver.id WHERE ((msg.source_user_id='".$user_id."' AND msg.target_user_id='".$reciever_id."') OR 
    // (msg.source_user_id='".$reciever_id."' AND msg.target_user_id='".$user_id."')) HAVING IF(chatDelRow=1,(msg.created_on>(select deletedDate from chat_deleteTB where deleteByuserID='".$user_id."' AND ChatParticipantID='".$reciever_id."')),'1999-01-01 05:06:23') ORDER BY msg.created_on ASC LIMIT $limit OFFSET $offset";
    
    // mycodeEnds
            // DB::enableQuerylog();

            $RecentChat = UserChat::from( 'user_chat as msg' )
            ->select(DB::raw('DISTINCT msg.id, sender.fname as senderName, sender.id as sender_id, sender.profile_picture as sender_profile_picture,receiver.fname as receiverName,receiver.id as receiver_id,receiver.profile_picture as receiver_profile_picture,msg.message,msg.created_on,msg.status as readStatus,msg.MessageType',DB::raw('IF((select COUNT(*) from chat_deleteTB where deleteByuserID=2 AND ChatParticipantID=3>0),1,0) as chatDelRow')))
            ->join('users as sender', 'msg.source_user_id' ,'=' ,'sender.id')
            ->join('users as receiver', 'msg.target_user_id', '=', 'receiver.id')
            ->where('msg.source_user_id',Auth::id())
            ->where('msg.target_user_id', $request->reciever_id)
            ->orWhere('msg.source_user_id',$request->reciever_id)
            ->where('msg.target_user_id', Auth::id())
            ->orderBy('msg.created_on','DESC')
            ->offset($offset)
            ->take($limit)
            ->get();

           // $RecentChat = DB::select($sql);
            
            // dd(DB::getQueryLog($RecentChat));
            // $checkBlock = DB::select("SELECT * FROM `block_users` WHERE ((block_id='".$user_id."' AND block_by_id='".$reciever_id."') OR (block_id='".$reciever_id."' AND block_by_id='".$user_id."')) AND status='2'");
           
            // if($checkBlock)
            // {
            //     $blockStatus=1;
            //     $block_by_id=$checkBlock['block_by_id'];
            // }
            // else
            // {
            //     $blockStatus=0; 
            //     $block_by_id=0;
            // }
        
            if(!empty($RecentChat)) {
             

            $offer = Offer::where('isCheckout','0')
                    ->where('vendor_id',$request->reciever_id)
                    ->where('user_id',Auth::id())
                    ->orWhere('vendor_id', Auth::id())
                    ->where('user_id',$request->reciever_id)
                    ->with(['Variants','Product'])
                    ->OrderBy('created_at','DESC')
                    ->first();

            // dd(DB::getQueryLog($offer));
     return $response=array("status"=>true,"code"=>200,"message"=>"View Messages successfully!","offer" => $offer,"data" =>$RecentChat,"blockStatus" => 0,"BlockByID" =>0);  

            // return parent::success(['message' => 'View Messages successfully!','data' => $RecentChat,"blockStatus" => $blockStatus,"BlockByID" =>$block_by_id]);
            }else {
                return $response=array("status"=>true,'data'=> [], "message"=>"Data not found");  
                
            }
        }else{
            $response=array("status"=>false,"message"=>"empty token"); 
            // return parent::error('empty Token');
        }
       
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function CancelOrder(Request $request){
    $rules = ['reason'=>'required','image[]'=>'','product_id'=>'required|exists:products,id','item_id'=>'required|exists:items,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        // dd($request->all());
        if (isset($request->image)):
            if($files = $request->file('image')):
                foreach($files as $file):
                    
                   $images[] = parent::__uploadImage($file, public_path('cancel'), false);
                 
                endforeach;
            endif;

            $input['image'] = implode(',', $images);

        endif;
        $input['user_id'] = Auth::id();
        $cancel = cancellation::create($input); 
     
        if($cancel){
            $item = new Item();
            $item = $item->FindOrfail($cancel->item_id);
                    $item->fill(['status'=> '4']);
                    $item->save();
            
            //$item = Item::where('id', (int)$cancel->item_id)->update(['status' => '4']);
         
        }
        return parent::success("Your cancellation process being initiated",$item);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function DeleteAddress(Request $request)
{
    $rules = ['address_id' => 'required|exists:addresses,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();

        $address = Address::FindOrfail($request->address_id);
        $address->delete();
        return parent::success("Address deleted successfully!");
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


public function ReturnLabel(Request $request)
{
    $rules = [];
    $validateAttributes=parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $returnCourier = Helper::ReturnRequest();
        return parent::success("Return request in proccess successfully!");
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


















   














































}
