<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Store;
use \App\Models\Role;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
// use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App;
use App\Models\AttributeOption;
use App\Models\Bank;
use App\Models\Brand;
use App\Models\Card;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Discount;
use App\Models\Manager;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Subcategory;
use App\Models\Subscription;
use App\Models\Variant;
use App\Models\VariantItems;
use Attribute;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\Return_;
use GrahamCampbell\ResultType\Success;
use Symfony\Component\Console\Input\Input;

use function PHPUnit\Framework\returnSelf;

class VendorController extends ApiController
{
    
    public $successStatus = 200;
    private $LoginAttributes  = ['id','fname','lname','email','phonecode','mobile_no','profile_picture','marital_status','type','status','token','created_at','updated_at'];

    public function CreateProfile(Request $request){
        $rules = ['profile_picture' => 'required','fname'=>'required','lname'=>'required','phonecode'=>'required','mobile_no' => 'required','fax' =>'required', 'paypal_id' =>'required','bank_ac_no' => 'required','routing_no' => 'required','street_address' => 'required', 'city' =>'required','country' =>'required','state' =>'required','zipcode'=> 'required'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
         try{

            $input = $request->all();
            // dd($input);
        if (isset($request->profile_picture)):
           $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('vendor'), false);
       endif;
            $phonecode =  str_replace('+','', $input['phonecode']);
            $input['phonecode'] = '+'.$phonecode;
            
            $fullname = $input['fname'].' '.$input['lname'];
            $input['name'] = $fullname;
            $input['status'] = '2';
            // dd($input);
            $model = new User();
            $user = $model->FindOrfail(Auth::id());
            // dd($user);
            $user->fill($input);
            $user->save();
            $user = $model->select($this->LoginAttributes)->where('id', Auth::id())->first();
            return parent::success('Profile created successfully!',['user' =>  $user]);
         }catch(\Exception $ex){
            return parent::error($ex->getMessage());
         }
    }


    public function EditVendorProfile(Request $request){
        $rules = ['profile_picture' => '','fname'=>'required','lname'=>'required','phonecode'=>'required','mobile_no' => 'required','fax' =>'required', 'paypal_id' =>'required','bank_ac_no' => 'required','routing_no' => 'required','street_address' => 'required', 'city' =>'required','country' =>'required','state' =>'required','zipcode'=> 'required'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
         try{

            $input = $request->all();
         
        if (isset($request->profile_picture) && $request->profile_picture !== '' ):
           $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('vendor'), false);
       endif;
            $phonecode =  str_replace('+','', $input['phonecode']);
            $input['phonecode'] = '+'.$phonecode;            
            $fullname = $input['fname'].' '.$input['lname'];
            $input['name'] = $fullname;
        
            $model = new User();
            $user = $model->FindOrfail(Auth::id());
            $user->fill($input);
            $user->save();
            $user = $model->select('id','fname','lname','profile_picture','phonecode','mobile_no','fax','paypal_id','bank_ac_no','routing_no','street_address','city','state','country','zipcode')->where('id', Auth::id())->first();
            return parent::success('Profile edited successfully!',['user' =>  $user]);
         }catch(\Exception $ex){
            return parent::error($ex->getMessage());
         }
    }



    public function ViewProfile(Request $request)
    {
        $rules =[];
        $validateAttributes= parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $profile = User::select('id','fname','lname','profile_picture','phonecode','mobile_no','fax','paypal_id','bank_ac_no','routing_no','street_address','city','state','country','zipcode')->where('id', Auth::id())->first();
            return parent::success("View profile successfully!",['profile' => $profile]);
        }catch(\exception $ex){
            return parent::error($ex->getMessage());
        }
    }




    public function AddStore(Request $request){
        $rules = ['banner'=>'required','image' => 'required','name'=>'required','location'=>'required','description'=>'required','store_images'=> 'required'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{

            $input = $request->all();
        
            if (isset($request->banner)):
                $input['banner'] = parent::__uploadImage($request->file('banner'), public_path('vendor'), false);
            endif;

            if (isset($request->image)):
                $input['store_image'] = parent::__uploadImage($request->file('image'), public_path('vendor'), false);
            endif;

            if($files = $request->file('store_images')):
                foreach($files as $file):
                    
                   $images[] = parent::__uploadImage($file, public_path('vendor'), false);
                 
                endforeach;
            endif;

            $input['photos'] = implode(',', $images);
            $model = new Store();
            $input['user_id'] = Auth::id();
            $model = $model->fill($input);
            $store = $model->save();
            User::FindOrfail(Auth::id())->update(['status' => '3']);
            return parent::success("Store added successfully!",['store' => $model]);
            // return parent::success('Store added successfully!',[]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }



    public function EditStore(Request $request){
        $rules = ['store_id'=> 'required|exists:stores,id','banner'=>'','image' => '','name'=>'required','location'=>'required','description'=>'required'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
        
        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{

            $input = $request->all();
        
            if (isset($request->banner)):
                $input['banner'] = parent::__uploadImage($request->file('banner'), public_path('vendor'), false);
            endif;

            if (isset($request->image)):
                $input['store_image'] = parent::__uploadImage($request->file('image'), public_path('vendor'), false);
            endif;

            // if($files = $request->file('store_images')):
            //     foreach($files as $file):
                    
            //        $images[] = parent::__uploadImage($file, public_path('vendor'), false);
                 
            //     endforeach;
            // endif;

            // $input['photos'] = implode(',', $images);

            

            $model = new Store();
            $model = $model->find($input['store_id']);
            $input['user_id'] = Auth::id();
            $model = $model->fill($input);
            $store = $model->save();
            User::FindOrfail(Auth::id())->update(['status' => '3']);
            return parent::success("Store edited successfully!",['store' => $model]);
            // return parent::success('Store added successfully!',[]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function Staff(Request $request){
        $rules = ['store_id' => 'required|exists:stores,id','profile_picture' => '','name'=>'required','email'=>'required','phonecode' =>'required', 'mobile_no' => 'required','status' =>'required|in:1,2'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();

            if (isset($request->profile_picture)):
                $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('vendor'), false);
            endif;
            $input['user_id']= Auth::id();
            $staff = Manager::create($input);
            User::FindOrfail(Auth::id())->update(['status' => '4']);
            $user = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            
            return parent::success("Staff added successfully!",['staff' => $staff,'user' =>$user]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function Proceed(Request $request)
    {
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $user = User::find(Auth::id());
            $status = ['status' => '5'];
            $user->fill($status);
            $user->save();
            return parent::success("Add staff proceed successfully!",['user' => $user]);
        }catch(\Exception $ex){
                return parent::error($ex->getMessage());
        }
    }

    public function ViewStaff(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $manager = Manager::select('id','profile_picture','name','email','phonecode','mobile_no','status')->where('user_id', Auth::id())->get();
            return parent::success("View staff successfully!",['manager' => $manager]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }

    }


    public function DeleteStaff(Request $request){
        $rules = ['staff_id' =>'required|exists:managers,id'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            Manager::find($input['staff_id'])->delete();
            return parent::SuccessMessage("staff Delete successfully!");
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function EditStaff(Request $request){
        $rules = ['staff_id' => 'required|exists:managers,id','profile_picture' => '','name'=>'required','email'=>'required','phonecode' =>'required', 'mobile_no' => 'required','status'=>'required|in:1,2'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();

            if (isset($request->profile_picture)):
                $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('vendor'), false);
            endif;
            
            $staff = Manager::FindOrfail($input['staff_id']);
            $staff->fill($input);
            $staff->save();
            return parent::success("Staff edited successfully!",['staff' => $staff]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }



   public function Product(Request $request){
        
        try{
            $input = $request->all();
            $input['is_variant'] = $request->type;
           
            $input['user_id'] = Auth::id();

            if (isset($request->image)):

                if($files = $request->file('image')):
                    foreach($files as $file):
                        
                       $images[] = parent::__uploadImage($file, public_path('products'), false);
                     
                    endforeach;
                endif;
    
                $input['image'] = implode(',', $images);

            endif;


            $create = Product::create($input);
            $product = Product::where('id', $create->id)->first();


            if($product):

            //  adding quantity to stock Dev:Ashish Mehra
                Stock::create([
                    'product_id' => $product->id,
                    'stock'      => $product->quantity,
                ]);
            // Adding Attributes
        if($product->variants){
            $arribute_json = json_decode($product->variants, true);

            $atrributes = array_keys($arribute_json);
                 
            for($i=0; $i < count($atrributes); $i++){
                 $saveAttr = \App\Models\Attribute::create([
                     'name' => $atrributes[$i],
                     'product_id' => $product->id
                 ]);
                 if($saveAttr){
                     $options = $arribute_json[$saveAttr->name];
                   
                     for($j=0; $j<count($options); $j++){
                         AttributeOption::updateOrCreate([
                             'name'=> $options[$j],
                             'attr_id' => $saveAttr->id
                         ]);
                     } 
                 }
                 
                 
               
 
            } // end for loop
        }
           

           $product['product_variants'] = \App\Models\Attribute::where('product_id', $product->id)->with(['Option'])->get();
        //    $arr = [];
        //    $push = array();
        //    foreach($vars as $var){
        //         $Option = AttributeOption::where('attr_id', $var->id)->get();
        //         array_push($push, $Option );
        //    }
        //   $product['product_variants'] =    array('variants'=> $vars,'options' => $push);
            endif;

            $user = User::where('id',Auth::id())->update(['status' => '6']);
            return parent::success("Product created successfully!",['product' => $product]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function AddVariant(Request $request){
    $rules = ['product_id' => 'required|exists:products,id','varients' =>'required','quantity'=>'required','price' =>'required'];
    $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        // dd($input);
        $variant = VariantItems::create([
            'product_id' => $input['product_id'],
            'quantity' => $input['quantity'],
            'price' => $input['price']
        ]);
        if($variant):

            $varient_items = json_decode($input['varients'],true);
           
           
            foreach($varient_items as $varient_item):
                $varient_item['variant_item_id'] = $variant->id;
                Variant::create($varient_item);
            endforeach;
            
        endif;
            $variants = VariantItems::
                        where('variant_items.product_id', $input['product_id'])
                        ->with(['variants'])
                        ->get();
        return parent::success("Variants added successfully!",['varients' => $variants]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }


   public function ViewProduct(Request $request)
   {
       $rules = ['limit' => '','search'=>'','category_id' =>'', 'stock_status' => ''];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{

           $input = $request->all();
           $search = $input['search'];
           $category_id = (int)$input['category_id'];
           $stock_status = $input['stock_status'];
           if(isset($input['limit'])):
            $limit = $input['limit'];
        endif;
            if(isset($request->search) || isset($request->category_id) || isset($request->stock_status)){
          
                // DB::enableQueryLog();
                $products = Product::select('products.id','products.name','products.image','products.amount','products.category_id','products.quantity', DB::raw('FORMAT(AVG(ratings.rating),1) as AverageRating, COUNT(ratings.id) as TotalComments'),'stocks.stock',DB::raw('(CASE
                WHEN stocks.stock > 0 THEN "available"
                WHEN stocks.stock = 0 THEN "not_available"
                ELSE "not_available"
               END ) as stock_status'))
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->leftJoin('stocks','stocks.product_id','products.id')
                        ->where('products.user_id', Auth::id())
                        ->where('products.name','LIKE','%'.$request->search.'%')
                        ->Where('products.category_id','LIKE','%'.$category_id.'%')
                        ->having('stock_status','LIKE','%'.$stock_status.'%')
                        ->with(['Category','Stock'])
                        ->groupBy('products.id')
                        ->orderBy('AverageRating','DESC')
                        ->get();
                        // dd(DB::getQueryLog($products));

            }else{
                    // DB::enableQueryLog();
                $products = Product::select('products.id','products.name','products.image','products.amount','products.category_id','products.quantity', DB::raw('FORMAT(AVG(ratings.rating),1) as AverageRating, COUNT(ratings.id) as TotalComments'),'stocks.stock',DB::raw('(CASE
                WHEN stocks.stock > 0 THEN "available"
                WHEN stocks.stock = 0 THEN "not_available"
                ELSE "not_available"
               END ) as stock_status'))
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->leftJoin('stocks','stocks.product_id','products.id')
                        ->where('products.user_id', Auth::id())
                        ->with(['Category'])
                        ->groupBy('products.id')
                        ->orderBy('AverageRating','DESC')
                        ->get();

            }

            //  dd(DB::getQueryLog($products));

            // foreach($products as $key => $product):
            //     $products[$key]['rating']  = number_format($product->Rating()->avg('rating'),1);
            //     $products[$key]['comment'] = $product->Rating()->count('comment');
            // endforeach;
         
        return parent::success("View all products successfully!", ['products' => $products]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }



   public function DeleteProduct(Request $request)
   {
       $rules = ['product_id' => 'required|exists:products,id'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input =$request->all();
           $product = Product::find($input['product_id']);
           $product->delete();
        return parent::success("Product deleted successfully!",[]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }




   public function getCategories(Request $request){
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    try{
        $category = Category::get();
        return parent::success("Category view successfully",['category' => $category]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }

   }

   public function ViewStore(Request $request){
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $store = Store::where('user_id',Auth::id())->get();
        return parent::success("View all stores successfully", ['stores' => $store ]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }

   public function AddBank(Request $request){
    $rules = ['name' => 'required','bank_ac_no' =>'required', 'routing_no' =>'required'];

    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);

    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{

        $input = $request->all();
        $input['user_id'] = Auth::id();
        $bank = Bank::create($input);

        return parent::success("Bank added successfully!",['bank' => $bank]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }

   }

   public function SetPrimaryPayment(Request $request)
   {
       $rules = ['bank_id' => ''];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
           $user = User::FindOrfail(Auth::id());
            if($input['type'] === '1'){
                
                $user->fill(['paypal_id_status' => '1']);
                $user->save();
                Bank::where('user_id', Auth::id())->update(['status' => '2']);
                $message = "payal Id";
            }else if($input['type'] === '2'){
                
                Bank::where('user_id', Auth::id())->update(['status' => '2']);

                Bank::where('user_id', Auth::id())->where('id', $input['bank_id'])->update(['status' => '1']);
                $user->fill(['paypal_id_status' => '2']);
                $user->save();
                $message = "Bank account";
            }
            return parent::success("$message is set  to default");
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }


   public function editBankDetails(Request $request){
    $rules = ['bank_ac_no' =>'required','name' => 'required', 'routing_no' =>'required','bank_id'=>'required|exists:banks,id'];

    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);

    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{

        $input = $request->all();
       
        $bank = Bank::FindOrfail($request->bank_id);
        $bank->fill($input);
        $bank->save();

        return parent::success("Bank added successfully!",['bank' => $bank]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }

   }

   public function Discount(Request $request)
   {
       $rules = ['banner'=>'required','category_id'=>'required|exists:categories,id','percentage'=>'required','description'=>'required','start_date'=>'required', 'valid_till' =>'required'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
        if (isset($request->banner)):
           $input['banner'] = parent::__uploadImage($request->file('banner'), public_path('discount'), false);
       endif;
       $input['status'] = '1';
       $input['user_id'] = Auth::id();
       $start_date = date('Y-m-d H:i:s a', strtotime($request->start_date));
       $valid_till = date('Y-m-d H:i:s a', strtotime($request->valid_till));
       $input['start_date'] = $start_date;
       $input['valid_till'] = $valid_till;  
       $discount = Discount::create($input);
        return parent::success("Discount added successfully!",['discount' => $discount]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }

   public function UpdateDiscount(Request $request)
   {
       $rules = ['discount_id'=> 'required|exists:discounts,id','banner'=>'','category_id'=>'required|exists:categories,id','percentage'=>'required','description'=>'required','start_date'=>'required', 'valid_till' =>'required'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
        if (isset($request->banner)):
           $input['banner'] = parent::__uploadImage($request->file('banner'), public_path('discount'), false);
       endif;
       
       $discount = Discount::find($input['discount_id']);
       $input['status'] = '1';
       $input['user_id'] = Auth::id();
       $start_date = date('Y-m-d H:i:s a', strtotime($request->start_date));
       $valid_till = date('Y-m-d H:i:s a', strtotime($request->valid_till));
       $discount->fill($input);
       $discount->save();
        return parent::success("Discount updated successfully!",['discount' => $discount]);
       }catch(\Exception $ex){ 
        return parent::error($ex->getMessage());
       }
   }


   public function ExpiredDiscount(Request $request)
   {
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $discount = Discount::where('user_id', Auth::id())->where('status', '2')->get();
            return parent::success("View expired discount successfully!",['discount' => $discount]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function ViewDiscount(Request $request)
   {
    //    dd(Auth::id());
    $rules = ['status' => 'required|in:1,2'];
    $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
    
        $input = $request->all();
        $disc = [];
        $discounts = Discount::where('user_id', Auth::id())->with('Category')->get();
        if($input['status'] == '1'){
           
        foreach($discounts as $discount):

        $date1 = Carbon::createFromFormat('Y-m-d H:i a', $discount['valid_till']); 
        $date2 = Carbon::now();  
       
        $result = $date1->gt($date2);
     
        if($result):
            array_push($disc,$discount);
        endif;
     endforeach;
        }else if($input['status'] == '2'){

            foreach($discounts as $discount):

                $date1 = Carbon::createFromFormat('Y-m-d H:i a', $discount['valid_till']); 
                $date2 = Carbon::now();  
               
                $result = $date1->lt($date2);
             
                if($result):
                    array_push($disc,$discount);
                endif;
             endforeach;

        }
     
        return parent::success("View discount successfully!",['discount' => $disc]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }

   public function Subscriptions(Request $request)
   {
       $rules = [];
       $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $subscription = Subscription::get();
            return parent::success("Subscription plans view successfully!",['subscription' => $subscription]);
       }catch(\Exception $ex){
           return parent::error($ex->getMessage());
       }
   }


   public function SubscriptionPlanById(Request $request)
   {
        $rules = ['subscription_id' =>'required|exists:subscriptions,id'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
    
            $subscription = Subscription::find($request->subscription_id);
            return parent::success("Subscription plan View successfully!",['subscription' => $subscription]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function SubCategories(Request $request)
   {
       
        $rules = ['category_id' => 'required|exists:categories,id'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $input = $request->all();
            $subcategories = Subcategory::where('category_id', $input['category_id'])->with('Category')->get();
            return parent::success("Sub-Categories view successfully!",['subcategories' => $subcategories]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }



   public function Colours(Request $request)
   {
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $Colour = Colour::all();
            return parent::success("View colours successfully!",['colours' => $Colour]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }

   public function CSV(Request $request){

        $rules = ['uploads' => ''];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $filename = $_FILES['uploads']['tmp_name'];
            // dd($filename);
            $open = fopen($filename, "r");
            $data = fgetcsv($open, 1000, ",");
            $brands = [];
            $sql = '';
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
                {
                   
                   $sql .= "('".addslashes($data[0])."'),";
                }
                $sql = rtrim($sql,',');
                // dd('insert into brands (name) values '.$sql);
                // DB::enableQueryLog();
                $query  = DB::insert('insert into brands (name) values '.$sql);
               return parent::success("Brands added successfully!");
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function Brands(Request $request){
      
       $rules = ['search' =>''];
       $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
        $brands = [];
        $input = $request->all();
        if(isset($request->search)):
        $brands = Brand::where('name','LIKE', "%".$input['search']."%")->take(2000)->get();
        else:
            $brands = Brand::inRandomOrder()->take(2000)->get();
        
        endif;
        
        return parent::success("View brands successfully!",['brands' => $brands]);

       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }

   }
   
   public function VendorProductFilter(Request $request)
   {
    // dd($request->all());
        $rules = ['category_id' => 'required|exists:categories,id', 'quantity' => ''];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            // DB::enableQueryLog();
            $product =  Product::select(['id','category_id','name','amount','image','quantity'])
                        ->where('user_id' , Auth::id())
                        ->where('category_id', $input['category_id'])
                        ->where('quantity','>=', (int)$input['quantity'])
                        ->with(['Category','Rating'])   
                        ->orderBy('id','DESC')
                        ->get();
                        // dd(DB::getQueryLog($product));
            return parent::success("View filter successfully!",['product' => $product]);    
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }

   }

   public function ViewBankDetails(Request $request)
   {
       $rules = [];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $bank = Bank::where('user_id',Auth::id())->get();
           $paypal = User::select('id','paypal_id','paypal_id_status')->where('id',Auth::id())->first();
        return parent::success("View bank details successfully!",['paypal_id' => $paypal ,'bank' => $bank]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }

   public function getBankDetailsById(Request $request){
    $rules = ['bank_id' => 'required|exists:banks,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $bank = Bank::where('user_id', Auth::id())->where('id', $request->bank_id)->first();
        return parent::success("View bank details successfully!",['bank' => $bank]);
    }catch(\exception $ex){
        return parent::error($ex->getMessage());
    }
   }
   public function deleteBankDetails(Request $request){
    $rules = ['bank_id' => 'required|exists:banks,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $bank = Bank::where('user_id', Auth::id())->where('id', $request->bank_id)->delete();
        return parent::success("Delete bank details successfully!");
    }catch(\exception $ex){
        return parent::error($ex->getMessage());
    }
   }



   public function EditPaypalId(Request $request)
   {
       $rules = ['paypal' => 'required'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
            $input = $request->all();
            $user = User::FindOrfail(Auth::id());
            $user->paypal_id = $input['paypal'];
            $user->save();
            return parent::success("Paypal Id updated successfully!");
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }


   public function DeleteDiscount(Request $request)
   {
       $rules = ['discount_id' => 'required|exists:discounts,id'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            Discount::where('id', $request->discount_id)->where('user_id', Auth::id())->delete();
            return parent::success("Discount deleted successfully!");
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function ViewStaffById(Request $request)
   {
        $rules = ['store_id' => 'required|exists:managers,store_id'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $staff = Manager::where('store_id', $request->store_id)->get();
            return parent::success("View staff details successfully!",['staff' => $staff]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function StoreById(Request $request)
   {
       $rules = ['store_id' => 'required|exists:stores,id'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
            $input = $request->all();
            $store = Store::where('id', $input['store_id'])->with(['staff'])->first();
        return parent::success("View store details successfully!",['store' => $store]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }

   }











}
