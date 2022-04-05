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
use App\Models\Card;
use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Contact;
use App\Models\Favourite;

use App\Models\Product;
use App\Models\Rating;
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
        $rules = [];
        $validateAttributes=parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{
            $products = Product::select('id','name','image','amount')->get();

            foreach($products as $key => $product):
                $products[$key]['rating']  = number_format($product->Rating()->avg('rating'),1);
                $products[$key]['comment'] = $product->Rating()->count('comment');
            endforeach;
            
            return parent::success("Product view successfully",['products' => $products]);
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
            $favourite = Favourite::create($input);
            return parent::success("Product favourite successfully!",['favourite' => $favourite]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }

    }


    public function FavouriteList(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $favourites = Favourite::where('by', Auth::id())->where('status','1')->with('Product')->get();
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
            $input = $request->all();
            Favourite::find($input['favourite_id'])->delete();
            return parent::success("Favourite delete successfully!",[]);
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

































}
