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
use App\Models\Category;
use App\Models\Manager;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\Return_;
use GrahamCampbell\ResultType\Success;

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
        $rules = ['banner'=>'required','image' => 'required','name'=>'required','location'=>'required','description'=>'required','store_images'=> 'required','manager_profile_picture' =>'required','manager_name'=>'required','manager_email'=>'required','manager_phonecode'=>'required','mamanger_mobile_no'=>'required'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),false);
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
            $model->save();
            
            if (isset($request->manager_profile_picture)):
                $input['profile_picture'] = parent::__uploadImage($request->file('manager_profile_picture'), public_path('vendor'), false);
            endif;

            $phonecode = str_replace('+','', $input['manager_phonecode']);
            $data =[
                'store_id' => $model->id,
                'name' => $input['manager_name'],
                'email' => $input['manager_email'],
                'phonecode' => '+'.$phonecode,
                'mobile_no' => $input['mamanger_mobile_no'],
                'profile_picture' => $input['profile_picture']
            ];
            Manager::create($data);
            return parent::success('Store added successfully!',[]);
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

}
