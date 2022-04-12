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
            $input['user_id'] = Auth::id();

            if (isset($request->image)):

                if($files = $request->file('image')):
                    foreach($files as $file):
                        
                       $images[] = parent::__uploadImage($file, public_path('products'), false);
                     
                    endforeach;
                endif;
    
                $input['image'] = implode(',', $images);

            endif;




            $product = Product::create($input);

            if($product):
             
                Stock::create([
                    'product_id' => $product->id,
                    'stock'      => $product->quantity,
                ]);

            endif;


            $user = User::where('id',Auth::id())->update(['status' => '6']);
            return parent::success("Product created successfully!",['product' => $product]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }



   public function ViewProduct(Request $request)
   {
       $rules = ['limit' => ''];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
            $limit = $input['limit'];
            $products = Product::select('id','name','image','amount','category_id','quantity')->where('user_id', Auth::id())->with(['Category'])->orderBy('id','DESC')->get(); 
            foreach($products as $key => $product):
                $products[$key]['rating']  = number_format($product->Rating()->avg('rating'),1);
                $products[$key]['comment'] = $product->Rating()->count('comment');
            endforeach;
         
          
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
    $rules = ['bank_ac_no' =>'required', 'routing_no' =>'required'];

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
    $rules = [];
    $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $discount = Discount::where('user_id', Auth::id())->where('status', '1')->with('Category')->get();
        return parent::success("View discount successfully!",['discount' => $discount]);
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














}
