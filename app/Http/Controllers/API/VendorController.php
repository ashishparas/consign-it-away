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
use App\Models\Card;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Manager;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\Return_;
use GrahamCampbell\ResultType\Success;
use Symfony\Component\Console\Input\Input;

class VendorController extends ApiController
{
    
    public $successStatus = 200;
    private $LoginAttributes  = ['id','fname','lname','email','phonecode','mobile_no','profile_picture','marital_status','type','status','token','created_at','updated_at'];

    public function CreateProfile(Request $request){
        $rules = ['profile_picture' => 'required','fname'=>'required','lname'=>'required','phonecode'=>'required','mobile_no' => 'required','fax' =>'required', 'paypal_id' =>'required','bank_ac_no' => 'required','routing_no' => 'required','street_address' => 'required', 'city' =>'required','country' =>'required','state' =>'required','zip_code'=> 'required'];
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
            $user = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            User::FindOrfail(Auth::id())->update(['status' => '4']);
            return parent::success("Staff added successfully!",['staff' => $staff,'user' =>$user]);
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
            $manager = Manager::select('id','profile_picture','name','email','status')->where('user_id', Auth::id())->get();
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
            return parent::success("Staff added successfully!",['staff' => $staff]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }



   public function Product(Request $request){
        $rules = ['name'=> 'required','image'=>'required','category_id' =>'required',
                'description' => 'required', 'price' => 'required', 'discount' => '',
                'brand' => 'required', 'color' =>'required', 'quantity' => 'required',
                'weight' =>'required', 'condition'=>'required', 'dimensions' =>'required',
                'available_for_sale' => 'required|in:1,2','constomer_contact'=> 'required|in:1,2',
                'inventory_track' => 'required|in:1,2','product_offer' => '','ships_from'=>'required', 'shipping_type' => 'required', 'meta_description' => '',
                'meta_tags' => '', 'meta_keywords' => '', 'title' => 'required', 'variants' => '',
                'state'=> '','tags' =>'','advertisement' =>'', 'selling_fee' =>'required', 
                'amount' => 'required'
    ];
  
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;

        try{
            $input = $request->all();
            $input['user_id'] = Auth::id();

            if (isset($request->image)):
                $input['image'] = parent::__uploadImage($request->file('image'), public_path('products'), false);
            endif;

            $product = Product::create($input);
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
            $products = Product::select('id','image','amount','category_id')->with(['Category'])->Paginate($limit);
            foreach($products as $key => $product):
                $products[$key]['rating'] = number_format($product->Rating()->avg('rating'),1);
                $products[$key]['comment'] = $product->Rating()->count('comment');
            endforeach;
            // $collection = $products->getCollection();
          
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
       $input['status'] = '2';
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




   














}
