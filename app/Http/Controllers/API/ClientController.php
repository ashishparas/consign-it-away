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
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\RecentProducts;
use GrahamCampbell\ResultType\Success;

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
            $addresses = Address::where('user_id', Auth::id())->get();
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
          
            $products = Product::
                    select('products.id','products.name','products.image','products.amount', DB::raw('AVG(ratings.rating) as AverageRating, COUNT(ratings.id) as TotalComments, (favourites.status) as favourite, favourites.id as favourite_id'))
                    ->leftJoin('ratings', 'ratings.product_id', 'products.id')
                    ->leftJoin('favourites', 'favourites.product_id', 'products.id')
                    // ->where('favourites.by', Auth::id())
                    ->groupBy('ratings.product_id')
                    ->orderBy('AverageRating', 'desc')
                    ->get();
            $category = Category::select('id','title','image')->get();


            $brands = Brand::whereIn('id',[9372,11739,41,9496,2494,14130,15097,13014,5808,6573])->get();
            
            
            $recentView = RecentProducts::select('products.id','products.name','products.image','products.amount','recent_products.id','recent_products.user_id','recent_products.product_id','favourites.id as favourite_id',DB::raw('(favourites.status) as favourite'))
            ->where('recent_products.user_id', Auth::id())
            ->leftJoin('favourites', 'favourites.product_id', 'recent_products.product_id')
            ->join('products', 'products.id', '=', 'recent_products.product_id')
       
            ->where('recent_products.user_id', Auth::id())
           
            ->get();
            $arr = array(
            array('name' => 'Category','type'=> 1,'items'=> $category),
            array('name' =>'Most Popular','type'=> 2,'items' =>$products),
            array('name' => 'Brands','type' => 3,'items' => $brands),
            array('name' => 'Recent Viewed','type' => 4, 'items' => $recentView)
        );
            return parent::success("Product view successfully",['home' => $arr]);
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
            $product['rating'] = number_format($product->Rating()->avg('rating'),1);
            $product['comment'] = $product->Rating()->select('id','product_id','from','rating','comment')->get();
            foreach($product['comment'] as $key => $commentUser):
               
                $product['comment'][$key]['user'] = User::where('id', $commentUser->from)->select('id', 'fname','lname','profile_picture')->first();
            endforeach;

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
    $rules=['product_id' => 'required|exists:products,id','quantity' =>'required'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $cart = Cart::create($input);
        return parent::success("Product add to cart successfully!");
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }

   public function AddQuantity(Request $request)
   {
    $rules=['cart_id' => 'required|exists:carts,id','quantity' =>'required'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        
        $cart = Cart::FindOrfail($input['cart_id']);
        $cart->quantity = $input['quantity'];
        $cart->save();
        $cart = Cart::where('id', $input['cart_id'])->where('user_id', Auth::id())->with('product')->first();
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
       
       
        return parent::success("Delete cart item successfully!");
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
           $cart = Cart::with('Product')->get();
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
        $rules = [];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $address = Address::select('id','fname','lname','email','phonecode','mobile_no','address')->where('user_id', Auth::id())->where('status','1')->first();
            $cart = Cart::where('user_id', Auth::id())->with('product')->get();
            
            return parent::success("View Cart successfully!",['address' => $address,'cart' => $cart]);
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
           
        endif;
       
            

       }catch(\Exception $ex){
           return parent::error($ex->getMessage());
       }
   }































}
