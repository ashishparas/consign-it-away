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
use Stripe;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App;
use App\Helper\Helper;
use App\Models\Address;
use App\Models\Attribute as ModelsAttribute;
use App\Models\AttributeOption;
use App\Models\Bank;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\cancellation;
use App\Models\Card;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Discount;
use App\Models\Item;
use App\Models\Manager;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\PromoProduct;
use App\Models\Refund;
use App\Models\Stock;
use App\Models\Subcategory;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\TrackUser;
use App\Models\Transaction;
use App\Models\Variant;
use App\Models\VariantItems;
use App\Models\Withdraw;
use Attribute;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\Return_;
use GrahamCampbell\ResultType\Success;
use Symfony\Component\Console\Input\Input;
use Symfony\Contracts\Service\Attribute\Required;

use function PHPUnit\Framework\returnSelf;

class VendorController extends ApiController
{
    
    public $successStatus = 200;
    private $LoginAttributes  = ['id','fname','lname','email','phonecode','mobile_no','profile_picture','marital_status','type','status','is_switch','vendor_status','token','created_at','updated_at'];

    public function CreateProfile(Request $request){

        $rules = ['profile_picture' => 'required','fname'=>'required','lname'=>'required','phonecode'=>'required','mobile_no' => 'required','fax' =>'', 'paypal_id' =>'','bank_ac_no' => '','routing_no' => '','street_address' => 'required', 'city' =>'required','country' =>'required','state' =>'required','zipcode'=> 'required'];
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
            $input['vendor_status'] = '2';
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

        $rules = ['banner'=>'required','image' => 'required','name'=>'required','location'=>'required','address' => 'required', 'city'=> 'required', 'state' =>'required', 'country' =>'required',
        'zipcode' => 'required', 'description'=>'required','store_images'=> 'required',];
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
            $store = $model->save();
            if(Auth::user()->type === '2'){
                User::where('id',Auth::id())->update(['vendor_status' => '3']);
            }
            
            return parent::success("Store added successfully!",['store' => $model]);
         
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }



    public function EditStore(Request $request){
        $rules = ['store_id'=> 'required|exists:stores,id','banner'=>'','image' => '','name'=>'required','location'=>'required','description'=>'required','address'=>'','city'=>'','state'=>'','country'=>'','zipcode'=>''];
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
            // User::FindOrfail(Auth::id())->update(['status' => '3']);
            return parent::success("Store edited successfully!",['store' => $model]);
            // return parent::success('Store added successfully!',[]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
    }


    public function Staff(Request $request){
        $rules = ['store_id' => 'required|exists:stores,id','profile_picture' => '','name'=>'required','email'=>'required','phonecode' =>'required', 'mobile_no' => 'required','status' =>'required|in:1,2','type' => 'required|in:1,2'];
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
            if($request->type === '1'){
                if(Auth::user()->type === '2'):
                    User::FindOrfail(Auth::id())->update(['vendor_status' => '4']);
                endif;
                
            }
            $user = User::select($this->LoginAttributes)->where('id', Auth::id())->first();
            $user['store'] = Store::select('id')->where('id', $request->store_id)->first();
            
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
            if(Auth::user()->type === '2'):
                $status = ['vendor_status' => '5'];
                $user->fill($status);
                $user->save();
            endif;
            
            return parent::success("Add staff proceed successfully!",['user' => $user]);
        }catch(\Exception $ex){
                return parent::error($ex->getMessage());
        }
    }

    public function ViewStaff(Request $request){
      
        $rules = ['search' => ''];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $manager = Manager::select('id','profile_picture','name','email','phonecode','mobile_no','status','active_status',DB::raw('CONVERT(store_id, CHAR) as store_id'));
            if(isset($request->search)){
                $manager= $manager->where('name','LIKE', '%'.$request->search.'%');
            }
          
            $manager = $manager->where('user_id', Auth::id())->with(['Store'])->get();
         
            return parent::success("View staff successfully!",['staff' => $manager]);
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

            if($input['is_variant'] === '1'):
                $input['status'] = '1';
            endif;
           
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
                         AttributeOption::create([
                             'name'=> $options[$j],
                             'attr_id' => $saveAttr->id
                         ]);
                     } 
                 }
                 
                 
               
 
            } // end for loop
        }
           

           $product['product_variants'] = \App\Models\Attribute::where('product_id', $product->id)->with(['Option'])->get();
            endif;
            if(Auth::user()->type === '2'):
                $user = User::where('id',Auth::id())->update(['vendor_status' => '6']);
            endif;
            
            return parent::success("Product created successfully!",['product' => $product]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }



   public function UpdateProduct(Request $request){
     
    try{
        $input = $request->all();
        $input['is_variant'] = $request->type;
       
        $input['user_id'] = Auth::id();

        if($input['is_variant'] === '1'):
            $input['status'] = '1';
        endif;
        $images= [];
        if (isset($request->image)):

            if($files = $request->file('image')):
                foreach($files as $file):
                    
                   $images[] = parent::__uploadImage($file, public_path('products'), false);
                 
                endforeach;
            endif;
             
            $input['image'] = implode(',', $images);

        endif;


        $create = Product::FindOrfail($request->product_id);
       
        $old_images = $create->image;
       
        if(!empty($images)){
           
            foreach($images as $image):
                array_push( $old_images, $image);
            endforeach;
        }
        
        $input['image'] = implode(",", $old_images);
                    $create->fill($input);
                    $create->save();
                    
        $product = Product::where('id', $create->id)->first();


        if($product):

        //  adding quantity to stock Dev:Ashish Mehra
            Stock::updateOrCreate(['product_id' => $product->id],[
                'product_id' => $product->id,
                'stock'      => $product->quantity,
            ]);
        // Adding Attributes
    if($product->variants){
        $arribute_json = json_decode($product->variants, true);

        $atrributes = array_keys($arribute_json);
             
        for($i=0; $i < count($atrributes); $i++){
             $saveAttr = \App\Models\Attribute::updateOrCreate(['product_id' => $product->id, 'name' => $atrributes[$i]],[
                 'name' => $atrributes[$i],
                 'product_id' => $product->id
             ]);
             if($saveAttr){
                 $options = $arribute_json[$saveAttr->name];
               
                 for($j=0; $j<count($options); $j++){
                     AttributeOption::updateOrCreate(['attr_id' => $saveAttr->id,'name'=> $options[$j] ],[
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
        return parent::success("Product Updated  successfully!",['product' => $product]);
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
            $varient_items = json_decode($input['varients'],true);
           $attr_id = [];
           $option_id = [];
           for($i=0; $i<count($varient_items); $i++){
                    array_push($attr_id,$varient_items[$i]['attr_id']);
                    array_push($option_id,$varient_items[$i]['option_id']);
           }
         
                $varient_item['variant_item_id'] = '1';//$variant->id;
                  Variant::create([
                    'attr_id' => implode(",", $attr_id),
                    'option_id' =>  implode(",", $option_id),
                    'product_id'  => $input['product_id'],
                    'quantity' => $input['quantity'],
                    'price' => $input['price']
                ]);
          
            $variants = Variant:: where('product_id', $input['product_id'])->get();
            $variants =  Helper::ProductVariants($variants);
        return parent::success("Variants added successfully!",['varients' => $variants]);
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
           $search = $input['search'];
           $category_id = (int)$input['category_id'];
           $stock_status = $input['stock_status'];
        
            $limit = isset($input['limit'])? $input['limit']: 15;
      
            if(isset($request->search) || isset($request->category_id) || isset($request->stock_status)){
            
                // DB::enableQueryLog();
                $products = Product::select('products.id','products.name','products.description','products.discount','products.image',DB::raw('products.price as amount'),'products.category_id','products.quantity',DB::raw('FORMAT(AVG(ratings.rating),1) as AverageRating, COUNT(ratings.id) as TotalComments'),'stocks.stock',DB::raw('(CASE
                WHEN stocks.stock > 0 THEN "available"
                WHEN stocks.stock = 0 THEN "not_available"
                ELSE "not_available"
               END ) as stock_status, stocks.stock as manage_stock'))
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->leftJoin('stocks','stocks.product_id','products.id')
                       
                        ->where('products.user_id', Auth::id())
                        ->where('products.name','LIKE','%'.$request->search.'%')
                        ->orWhere('products.category_id','LIKE','%'.$category_id.'%')
                        ->having('stock_status','LIKE','%'.$stock_status.'%')
                        ->with(['Category','Stock','Discount'])
                        ->groupBy('products.id')
                        ->orderBy('AverageRating','DESC')
                        ->paginate($limit)->makeHidden(['CartStatus','soldBy']);
                       

            }else{
            
                    // DB::enableQueryLog();
                $products = Product::select('products.id','products.name','products.image',DB::raw('products.price as amount'),'products.discount','products.category_id','products.quantity', DB::raw('FORMAT(AVG(ratings.rating),1) as AverageRating, COUNT(ratings.id) as TotalComments'),'stocks.stock',DB::raw('(CASE
                WHEN stocks.stock > 0 THEN "available"
                WHEN stocks.stock = 0 THEN "not_available"
                ELSE "not_available"
               END ) as stock_status,stocks.stock as manage_stock'))
                        ->leftJoin('ratings','ratings.product_id','products.id')
                        ->leftJoin('stocks','stocks.product_id','products.id')
                        ->where('products.user_id', Auth::id())
                        ->with(['Category','Stock','Discount'])
                        ->groupBy('products.id')
                        ->orderBy('AverageRating','DESC')
                        ->paginate($limit)->makeHidden(['CartStatus','soldBy']);

            }
            $count =     Product::where('user_id', Auth::id())->whereMonth('created_at', date('m'))->count('id');
            $Productcount =     Product::where('user_id', Auth::id())->count('id');
           
            //  dd(DB::getQueryLog($products));

            // foreach($products as $key => $product):
            //     $products[$key]['rating']  = number_format($product->Rating()->avg('rating'),1);
            //     $products[$key]['comment'] = $product->Rating()->count('comment');
            // endforeach;
         
        return parent::success("View all products successfully!", ['product_count'=>$Productcount,'this_month_added' => $count,'products' => $products]);
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
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $category = Category::get();
        return parent::success("Category view successfully",['category' => $category]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }

   }

   public function ViewStore(Request $request){
    $rules = ['search' =>''];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
         $input = $request->all();


        $store = new Store();
        if($request->search){
            $store = $store->where('name','LIKE', '%'.$request->search.'%');
        }
        
        $store = $store->where('user_id',Auth::id())->get();
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
  
    $rules = ['status' => 'required'];
    $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
    
        $input = $request->all();
     
        $disc = [];
        $discounts = Discount::where('user_id', Auth::id())
        ->with(['Category'])
        ->orderBy('discounts.id','DESC')
        ->get();
        if($input['status'] == '1'){
         
        foreach($discounts as $discount):
        //dd($discount['valid_till']);
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

   public function SubscriptionsPlan(Request $request)
   {
   
       $rules = [];
       $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $subscriptions = SubscriptionPlan::get();
       
           foreach($subscriptions as $key => $subscription):
            $subscriptions[$key]['features'] = json_decode($subscription->features);
           endforeach;
           $active = Subscription::select('plan_id','type','body')->where('user_id', Auth::id())->orderBy('created_at','DESC')->first();
          
           if(isset($active->body)):
            $subscription = json_decode($active->body, true);
            $active['interval'] = $active->type;
            else:
                $active['interval']= '';
           endif;
         
            return parent::success("Subscription plans view successfully!",['active_plan'=> $active,'subscription' => $subscriptions]);
       }catch(\Exception $ex){
           return parent::error($ex->getMessage());
       }
   }


   public function SubscriptionPlanById(Request $request)
   {
        $rules = ['subscription_id' =>'required|exists:subscription_plans,id'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
    
            $subscription = SubscriptionPlan::find($request->subscription_id);
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
           
            $sql = '';
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
                {
                   
                   $sql .= "('".addslashes($data[0])."'),";
                }
                $sql = rtrim($sql,',');
                // dd('insert into brands (name) values '.$sql);0
                // DB::enableQueryLog();
                $query  = DB::insert('insert into brands (name) values '.$sql);
               return parent::success("Brands added successfully!");
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function productCSV(Request $request){

    $rules = ['uploads' => ''];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $filename = $_FILES['uploads']['tmp_name'];
       
        $open = fopen($filename, "r");
      
        $value = fgetcsv($open, 1000, ",");
     
        $sql = '';
        $i = 0;
        
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
            {
                $category_id = $value[0];
                $subcategory_id = $value[1];
                $store_id = $value[2];
                $name = $value[3];
                $image = $value[4];
                $description  = $value[5];
                $price = $value[6];
                $discount = $value[7];
                $brand = $value[8];
                $color = $value[9];
                $quantity  =$value[10];
                $weight = $value[11];
                $condition = $value[12];
                $dimensions = $value[13];
                $available_for_sale = $value[14];
                $customer_contact = $value[15];
                $inventory_track = $value[16];
                $product_offer = $value[17];
                $ships_from = $value[18];
                $shipping_type = $value[19];
                $is_variant = $value[20];
                $user_id = Auth::id();
             
    $query  = DB::insert("insert into products (`user_id`,$category_id, $subcategory_id, $store_id, $name, $image,$description, $price,  $discount,$brand, $color, $quantity, $weight, `$condition`, $dimensions,$available_for_sale, $customer_contact, $inventory_track, $product_offer,  $ships_from, $shipping_type,$is_variant) values('$user_id','$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]')");

            }

            // $sql = rtrim($sql,',');
          
            // dd('insert into brands (name) values '.$sql);0
            // DB::enableQueryLog();
          
           
           return parent::success("Product added successfully!");
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


   public function Brands(Request $request){
      
       $rules = ['search' =>'','limit'=>'','page' =>''];
       $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{

        $brands = [];
        $limit = (isset($request->limit))? $request->limit:15;
        
        $input = $request->all();
        if(isset($request->search)):
        $brands = Brand::where('name','LIKE', "%".$input['search']."%")->take(2000)->paginate($limit);
        else:
            $brands = Brand::inRandomOrder()->take(2000)->paginate($limit);
        
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
        $rules = ['store_id' => 'required|exists:stores,id'];
        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $staff = Manager::select('*',DB::raw('CONVERT(store_id, char) as store_id'))->where('store_id', $request->store_id)->with(['Store'])->get();
            return parent::success("View staff details successfully!",['staff' => $staff]);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function StoreById(Request $request)
   {
  
       $rules = ['store_id' => 'required|exists:stores,id','search'=>''];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),false);
       
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $products = [];
            $input = $request->all();
            $limit = 30;
            if(isset($request->limit)):
                $limit = ($request->limit)? $request->limit:30;
            endif;
            $store = Store::where('id', $input['store_id'])->with(['Manager'])->first();

            $about = User::select('id','name','fname','lname','profile_picture')
                            ->where('id',$store->user_id)
                            
                            ->first();
            $products = Product::select('id','image','name','amount','category_id');
            if(isset($request->search)){
                $products = $products->where("name","LIKE","%".$request->search."%");
            }
            $products = $products->where('user_id',$store->user_id)
            ->where('store_id',$store->id)
            ->with(['Category'])
            ->paginate($limit);

            $countProductbyMonth = Product::where('user_id', Auth::id())->whereRaw("MONTH(created_at) = date('M')")->count();
           
            foreach($products as $key => $product):
            $products[$key]['rating'] = number_format($product->Rating()->avg('rating'),1);
            $products[$key]['RatingCount'] = $product->Rating()->count('product_id');
            

            endforeach;
        return parent::success("View store details successfully!",['product_added_this_month'=> $countProductbyMonth,'store' => $store,'product'=> $products,'about'=> $about]);
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }

   }

   public function DeleteAttributes(Request $request)
   {
       $rules = ['variant_id' => 'required|exists:variants,id', 'product_id' => 'required|exists:products,id'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
           $variant = Variant::FindOrfail($input['variant_id']);
           $variant->delete();

           $variants = Variant:: where('product_id', $input['product_id'])->get();
           $variants =  Helper::ProductVariants($variants);
        return parent::success("Attribute deleted successfully!",['varients' => $variants]);
       }catch(\Exception $ex){
           return parent::error($ex->getMessage());
       }
   }


   public function ViewProductvariants(Request $request){
    $rules = ['product_id' => 'required|exists:products,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        
        $variants = Variant:: where('product_id', $input['product_id'])->get();
        $variants =  Helper::ProductVariants($variants);
        return parent::success("View all variants successfully!",['varients' => $variants]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }


   public function SubmitProduct(Request $request)
   {
       $rules = ['product_id' => 'required|exists:products,id'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
           $input = $request->all();
           Product::where('id', $input['product_id'])->where('is_variant','2')->update(['status' => '1']);
        return parent::success("Product submitted successfully!");
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }


   public function VendorBuySubscription(Request $request)
   {
       $rules = ['plan_id'=>'required','card_holder_name' => '','card_no' => '','expiry_date' =>'','cvv' =>'','subscription_price'=>'required','subscription_type'=>'required|in:month,year','PaymentToken'=>'','save_card' =>'required|in:1,2'];
       $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{
        
            $input = $request->all();
            
            if($input['save_card'] === '1'){
                $expiry_date = explode('/',$input['expiry_date']);
                $input['expiry_month'] = $expiry_date[0];
                $input['expiry_year'] = $expiry_date[1];
                $input['user_id'] =  Auth::id();
                $card = Card::create($input);
            }
        

            if($request->subscription_price > 0){
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // $cardTokenArray=\Stripe\Token::create([
        //     'card' => [
        //       'number' => $request['card_no'],
        //       'exp_month' => $expiry_date[0],
        //       'exp_year' => $expiry_date[1],
        //       'cvc' => '123',
        //     ],
        //   ]);
          $CardToken=$input['PaymentToken']; 
        //   $CardToken=$cardTokenArray['id']; 

       
        $customer = \Stripe\Customer::create ([
            'email' => Auth::user()->email, 
            'name' => Auth::user()->name,
            'address' => [
                'line1' => '510 Townsend St',
                'postal_code' => '98140',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
              ],
           'source'  => $CardToken          
          ]);
            //  $customer->id;

            $plan = \Stripe\Plan::create([
                "product" => [ 
                    "name" => "Bronze Subscription" 
                ], 
                "amount" => ($input['subscription_price']*100),
                "currency" => "USD",
                "interval" => $input['subscription_type'], 
                "interval_count" => 1 
            ]); 

            $subscription = \Stripe\Subscription::create([
                "customer" => $customer['id'], 
                "items" => array( 
                    array( 
                        "plan" => $plan['id'], 
                    ), 
                ),
                // "trial_end"=> strtotime(date('Y-m-d')),
                "metadata" => ["SellerID" => 'sel_'.md5(1111,9999)]
            ]);
         
            $data = [
                'plan_id' => $input['plan_id'],
                'user_id' => Auth::id(),
                'name'    => $subscription['object'],
                'type'    => $request->subscription_type,
                'stripe_status' => $subscription['status'],
                'stripe_price' => $subscription['items']['data'][0]['plan']['amount'],
                'subscription_id' => $subscription->id,
                'subscription_item_id' => $subscription['items']['data'][0]['id'],
                'quantity'     => '1',
                'stripe_id'    =>  $customer->id, //$subscription['items']['data'][0]['id'],
                'trial_ends_at' => $subscription['current_period_end'],
                'ends_at'   => $subscription['current_period_end'],
                'body'  => json_encode($subscription),
            ];

            

            }else{

                $data = [
                    'plan_id' => $input['plan_id'],
                    'user_id' => Auth::id(),
                    'name'    => 'Bronze',
                    'type'    => $request->subscription_type,
                    'stripe_status' => 'success',
                    'stripe_price' => 0,
                    'subscription_id' => 'free'.md5(rand(1111, 9999)),
                    'subscription_item_id' => 'free',
                    'quantity'     => '1',
                    'stripe_id'    =>  'free', //$subscription['items']['data'][0]['id'],
                    'trial_ends_at' => null,
                    'ends_at'   => null,
                    'body'  => null,
                ];

            }

            $subscription  = Subscription::create($data);
            $user = User::FindOrfail(Auth::id());
                    $user->fill(['vendor_status' => '6']);
                    $user->save();

        return parent::success("Subscription buy successfully",['subcription' => $subscription ]);
       }catch(\exception $ex){
           return parent::error($ex->getMessage());
       }
   }


   public function ChangeSubscriptionPlan(request $request){
    $rules = ['card_holder_name' => 'required','card_no' => 'required','expiry_date' =>'required','cvv' =>'required','subscription_price'=>'required','subscription_type'=>'required|in:month,year','PaymentToken'=>'required','save_card' =>'required|in:1,2','plan_id' => 'required'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), true);
    try{

        $input = $request->all();
        $subscription = Subscription::where('user_id',Auth::id())->first();
      
        if($request->subscription_price > 0){

        $body = json_decode($subscription->body,true);
            if($subscription->subscription_item_id !== "0"):
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $sub = Stripe\Subscription::retrieve($subscription->subscription_id);
                $sub->cancel();
            endif;
        

        // Mycode Dev:<Ashish Mehra/> (^-^)

        $expiry_date = explode('/',$input['expiry_date']);
        $input['expiry_month'] = $expiry_date[0];
        $input['expiry_year'] = $expiry_date[1];
        $input['user_id'] =  Auth::id();
     
        if($input['save_card'] === '1'){
         $card = Card::create($input);
        }

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // $cardTokenArray=\Stripe\Token::create([
        //     'card' => [
        //     'number' => $request['card_no'],
        //     'exp_month' => $input['expiry_month'],
        //     'exp_year' => $input['expiry_year'],
        //     'cvc' => '123',
        //     ],
        // ]);
      $CardToken=$input['PaymentToken']; 
        // $CardToken=$cardTokenArray['id']; 
       
    
            $customer = \Stripe\Customer::create ([
                'email' => Auth::user()->email, 
                'name' => Auth::user()->name,
                'address' => [
                    'line1' => '510 Townsend St',
                    'postal_code' => '98140',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'country' => 'US',
                  ],
               'source'  => $CardToken          
              ]);

    

        
      
        $plan = \Stripe\Plan::create([
            "product" => [ 
                "name" => "Bronze Subscription" 
            ], 
            "amount" => ($input['subscription_price']*100),
            "currency" => "USD",
            "interval" => $input['subscription_type'], 
            "interval_count" => 1 
        ]); 
    
        $subscription = \Stripe\Subscription::create([
            "customer" => $customer['id'], 
            "items" => array( 
                array( 
                    "plan" => $plan['id'], 
                ), 
            ),
            // "trial_end"=> strtotime(date('Y-m-d')),
            "metadata" => ["SellerID" => 'sel_'.md5(1111,9999)]
        ]);
     
        $data = [
            'plan_id' => $request->plan_id,
            'user_id' => Auth::id(),
            'name'    => $subscription['object'],
            'type'    => $request->subscription_type,
            'stripe_status' => $subscription['status'],
            'stripe_price' => $subscription['items']['data'][0]['plan']['amount'],
            'subscription_id' => $subscription->id,
            'subscription_item_id' => $subscription['items']['data'][0]['id'],
            'quantity'     => '1',
            'stripe_id'    =>  $customer->id, //$subscription['items']['data'][0]['id'],
            'trial_ends_at' => $subscription['current_period_end'],
            'ends_at'   => $subscription['current_period_end'],
            'body'  => json_encode($subscription),
        ];
      
        }else{
            $data = [
                'plan_id' => $request->plan_id,
                'user_id' => Auth::id(),
                'name'    => "Bronze",
                'type'    => $request->subscription_type,
                'stripe_status' => "success",
                'stripe_price' => 0,
                'subscription_id' => md5(rand(11111,99999)),
                'subscription_item_id' => '0',
                'quantity'     => '1',
                'stripe_id'    =>  'free', //$subscription['items']['data'][0]['id'],
                'trial_ends_at' => null,
                'ends_at'   => null,
                'body'  => null,
            ];
        }

        

        $subscription  = new Subscription();
        $subscription->where('user_id',Auth::id())->update($data);
        $subscription = $subscription->where('user_id', Auth::id())->first();                  
                        
        // End My code

        return parent::success("Your subscription has been updated successfully!",$subscription);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }




public function OfferStatusById(Request $request)
{
    $rules = ['offer_id'=>'required','offer_status'=>'required|in:1,2,3','offer_price'=>'','quantity'=>'','type'=>'required|in:vendor,client'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input =  $request->all();
     
        $model = new Offer();
        $model = $model->FindOrfail($request->offer_id);
        if(strtolower($input['type']) == 'client'){
            $input['client_status'] = $input['offer_status'];
        }else if(strtolower($input['type']) == 'vendor'){
            $input['status'] = $input['offer_status'];
        }
       
        $model->fill($input);
        $model->save();

        $model = $model->where('id', $input['offer_id'])->first();
        $message = ($model->status =='2')? 'Offer accepted successfully!':'Offer rejected successfully!';
        return parent::success($message, $model);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}
//
public function ViewDiscountById(Request $request){
    $rules = ['discount_id'=>'required|exists:discounts,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
            $input = $request->all();
            $discount = Discount::where('id', $request->discount_id)->first();
            return parent::success("View discount successfully!",$discount);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }

}


public function ChangeStaffStatus(Request $request){
    $rules = ['staff_id'=>'required|exists:managers,id','active_status'=>'required|in:1,2'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
            $input = $request->all();
            $manager = new Manager();
            $manager = $manager->FindOrfail($request->staff_id);
            $manager->fill($input);
            $manager->save();
            return parent::success("View discount successfully!",$manager);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }

}

public function EditStoreManagerDetails(Request $request){

    $rules = ['store_id'=> 'required|exists:stores,id','banner'=>'','image' => '','name'=>'required','location'=>'required','description'=>'required','manager_id' =>'Required|exists:managers,id',
'manager_name'=>'required','manager_email'=>'required','manager_mobile_no' =>'required','manager_status'=>'required|in:1,2','manager_image' =>''];
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
       
       

        
        
            Manager::where('store_id', $request->store_id)->update(['status' =>'1']);
            $manager = new Manager();
            $manager = $manager->FindOrfail($request->manager_id);
        $data = [
            'name' => $request->manager_name,
            'email' => $request->manager_email,
            'mobile_no' => $request->manager_mobile_no,
            'status' => $request->manager_status,
            
        ];

        if (isset($request->manager_image)):
            $data['image'] = parent::__uploadImage($request->file('manager_image'), public_path('vendor'), false);
        endif;

        $manager->fill($data);
        $manager->save();

        $mng = Manager::where('id',$input['manager_id'])->where('status','2')->first();

        return parent::success("Store edited successfully!",['store' => $model,'manager'=> $mng]);
       
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function ChangeProfilePicture(Request $request){
    $rules = ['profile_picture' => 'required'];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
     try{

        $input = $request->all();
       
    if (isset($request->profile_picture)):
       $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('vendor'), false);
   endif;
 
        $model = new User();
        $user = $model->FindOrfail(Auth::id());
        $user->fill($input);
        $user->save();
        $user = $model->select($this->LoginAttributes)->where('id', Auth::id())->first();
        return parent::success('Profile created successfully!',['user' =>  $user]);
     }catch(\Exception $ex){
        return parent::error($ex->getMessage());
     }
}


public function FilterProductByStore(request $request)
{
    $rules = ['category_id' =>'required|exists:categories,id','store_id'=>'required|exists:stores,id','stock'=>''];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input =$request->all();

        $products = Product::select('products.id','products.user_id','products.image','products.name','products.price','products.quantity','stocks.stock')
            ->leftJoin('stocks','products.id','stocks.product_id')
            ->where('products.user_id', Auth::id())
            ->where('products.store_id',$request->store_id)
            ->where('products.category_id', $request->category_id);
            if(isset($request->stock)){
                $products= $products->where('stocks.stock','LIKE','%'.$request->stock.'%');
            }
         
            $products = $products->get();

            foreach($products as $key => $product):
            $products[$key]['rating'] = number_format($product->Rating()->avg('rating'),1);
            $products[$key]['RatingCount'] = $product->Rating()->count('product_id');
            endforeach;
        return parent::success('View product successfully!',$products);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function ViewStaffDetailsById(Request $request){
    $rules = ['staff_id'=> 'required|exists:managers,id'];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $staff = Manager::where('id',$request->staff_id)->with(['Store'])->first();  
        return parent::success("View staff detsils successfully!", $staff);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function DeleteStore(Request $request){
    $rules = ['store_id' => 'required|exists:stores,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $store = Store::FindOrfail($request->store_id);
                    $store->delete();

        return parent::success("Store delete successfully!");
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function ChangeStoreStatus(Request $request)
{
    $rules = ['store_id'=>'required|exists:stores,id','status' =>'required|in:1,2'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $store = Store::FindOrfail($request->store_id);
                $store->fill($input);
                $store->save();
                if( $store->status ==='1'):
                    $message = "Store Activated successfully!";
                else:
                    $message = "Store Deactivated successfully!";
                endif;
        
        return parent::success($message,  $store);
    }catch(\Exception $ex){
        return parent::success($ex->getMessage());
    }
}


public function Dashboard(Request $request)
{
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $dashboard = User::select('users.id','users.name','users.fname','users.lname','users.email','users.profile_picture',DB::raw('SUM(transactions.price) as TotalRevenue'))
                    ->leftJoin('transactions','users.id','transactions.vendor_id')
                    ->where('users.id', Auth::id())
                    ->with(['Transaction'])
                    ->first();
        $withdraw = Withdraw::where('user_id', Auth::id())->sum('amount');
     
                    $dashboard['TotalRevenue'] = $dashboard['TotalRevenue']?(string)$dashboard['TotalRevenue']:"0";
                  
                    $dashboard['income'] = number_format($withdraw,1);
                      
                    $dashboard['balance'] = number_format(( (int)$dashboard->TotalRevenue - $withdraw ),1);
                   
                    $last_trans = Transaction::select('created_at')->where('vendor_id', Auth::id())->orderBy('created_at',"DESC")->first();
                    $Ldate =  ($last_trans)?  date('Y-M-d h:i a', strtotime($last_trans->created_at)): '';
                    $dashboard['last_transaction'] = $Ldate;
            
                    $this_mnth_tans = Transaction::where('vendor_id', Auth::id())->whereRaw('MONTH(order_date) = '.date('m'))->sum('price');
             
                    $dashboard['this_month_trans'] = number_format($this_mnth_tans,2);
                    $dashboard['current_month'] = date('F,Y');
                    $dashboard['income_ratio'] = "0.0";
                    $dashboard['monthly_ratio'] = "0.0";
        return parent::success("View dashboard successfully!",$dashboard);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


public function ViewTransactions(Request $request)
{
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $withdraw = Transaction::where('vendor_id', Auth::id())->orderBy('id','DESC')->get();
        $totalIncome = Transaction::where('vendor_id', Auth::id())->sum('price');
        $withdrawEarning = Withdraw::where('user_id', Auth::id())->sum('amount');
        $balance = $totalIncome - $withdrawEarning;
        return parent::success("View tansaction successfully!",['total_incomde' => number_format($balance,2),'withdraw'=> $withdraw, 'withdraw_earning' => number_format($balance,2)  ]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function Return(Request $request){
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;      
    try{

        $return = Item::whereIn('status', ['4','5'])
                ->where('vendor_id', Auth::id())
                ->with(['Product'])
                ->orderBy('id','DESC')
                ->get();
        $request = Item::where('status','4')
        ->where('vendor_id', Auth::id())
        ->with(['Customer'])
        ->orderBy('id','DESC')
        ->get();
        return parent::success("View returns successfully!",['returns' => $return,'request'=>$request]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
        
}


public function RefundRequests(Request $request)
{
    // dd(Auth::id());
$rules = [];
$validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),false);
if($validateAttributes):
    return $validateAttributes;
endif;
try{
    $refunds = cancellation::where('vendor_id', Auth::id())
                            ->where('type', '2')
                            ->orderBy('created_at', 'DESC')
                            ->get();
        

    return parent::success("View refund requests successfully!", $refunds);
}catch(\Exception $ex){
    return parent::error($ex->getMessage());
}
}


public function ReturnRequest(Request $request){
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;      
    try{

        $return = Item::whereIn('status', ['5'])
                ->where('vendor_id', Auth::id())
                ->with(['Product'])
                ->orderBy('id','DESC')
                ->get();
        $request = Item::where('status','4')
        ->where('vendor_id', Auth::id())
        ->with(['Customer'])
        ->orderBy('id','DESC')
        ->get();
        return parent::success("View returns successfully!",['returns' => $return,'request'=>$request]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
        
}



public function Withdraw(Request $request)
{
    $rules = ['amount' => 'required'];
    $validateAttributes=parent::validateAttributes($request,'POST',$rules,array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $trans = Transaction::where('vendor_id', Auth::id())->sum('price');
    
        $withdraw = Withdraw::where('user_id', Auth::id())->where('status','1')->sum('amount');
      
        $withdrawalAmount =  ($trans - $withdraw);
     
        if($request->amount > $withdrawalAmount):
            return parent::error("Your amount unprocessable amount");
        endif;

        $input['user_id'] =  Auth::id();
        $amt  = Withdraw::create($input);

        return parent::success("Withdraw request successfully send to Admin",$amt);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function CreatePromoCode(Request $request)
{
    $rules = ['name'=>'required','amount'=>'required','expiry' =>'required','product_id' =>'required'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $promocode = PromoCode::create($input);
        $products = explode(',', $promocode->product_id);
        foreach($products as $product):
            PromoProduct::create([
                'user_id' => Auth::id(),
                'code_id' => $promocode->id,
                'product_id' => $product,
                'expiry_date' => $promocode->expiry
            ]);
        endforeach;
        return parent::success("Promocode created successfully!", $promocode);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}
public function UpdatePromoCode(Request $request)
{
    $rules = ['promocode_id'=>'required|exists:promo_codes,id','name'=>'required','amount'=>'required','expiry' =>'required','product_id' =>'required'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $promocode = new PromoCode();
        $promocode = $promocode->FindOrfail($request->promocode_id);
                        $promocode->fill($input);
                        $promocode->save();
        
        return parent::success("Promocode created successfully!", $promocode);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


public function DeletePromocode(Request $request)
{
    $rules = ['promocode_id'=>'required|exists:promo_codes,id'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $promocode = PromoCode::FindOrfail($request->promocode_id);
                    $promocode->delete();
        return parent::success("Delete promocode successfully!");
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


public function ViewPromocode(Request $request)
{
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $promocode = PromoCode::where('user_id', Auth::id())->get();
        return parent::success("View products successfully!", $promocode);
    }catch(\Exception $ex){
        return parent::success($ex->getMessage());
    }
}


public function ViewOrderByVendor(Request $request)
   {
      // dd(Auth::id());
       $rules = ['order_id' => 'required|exists:items,id','type'=>'','notification_id'=>''];
       $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
       if($validateAttributes):
        return $validateAttributes;
       endif;
       try{

            $input = $request->all();
            $item = Item::where('vendor_id',Auth::id())
                ->where('id', $request->order_id)
                ->with(['Customer','cancelRequest','Product','Transaction','Rating','CustomerVariant','Offer'])
                ->first();
            
        if($item){
                
                    $tracking_id = Helper::trackCourier($item->tracking_id);
               
                    if($tracking_id['status'] === true):
                    
                        $item['tracking_status'] =   $tracking_id['data'];  
                    else:
                     
                        $item['tracking_status'] = [];
                    endif;
                  
                 
                  $specifications = Product::select('weight','brand','color','quantity')->where('id', $item->product_id)->first()
                    ->makeHidden('favourite','FavouriteId','CartStatus','soldBy');
                    $item['product']['product_specification'] = $specifications; 
                    $item['coupanAmt'] = '0';
               $attribite =  \App\Models\Attribute::where('product_id', $item->product_id)->get();

                $item['product']['product_varients'] =  $item->ProductVariants();
                 
                $address = Address::where('id', $item->address_id)->first();
                
                $store = Store::select('id','store_image','name','description','location','address','city','state','country','zipcode')
                                ->where('id', $item->product->store_id)
                                ->first();

            if(isset($request->type) && isset($request->notification_id)){
                if($request->type === '1'):
                    Notification::where('id', $request->notification_id)->update(['is_read' => '1']);
                endif;
            }
            if(isset($item->transaction)):
                $card = Card::where('id', $item->transaction->card_id)->select('id','card_holder_name','card_no','expiry_month','expiry_year')->first();
            if($card){
                $item['card_info'] = $card;
            }else{
                $item['card_info'] = null;
            }
            endif;

           $selectedvariants =  Helper::ProductvariantById($item->variant_id);
           $item['selected_variants'] = $selectedvariants;

            return parent::success("View order details successfully",['store' => $store,'shipping_address'=>  $address,'order' =>  $item ]);
                
        }else{
            return parent::error("Order not found related to this vendor");
        }
                

        
       }catch(\Exception $ex){
        return parent::error($ex->getMessage());
       }
   }


   
   function TransactionById(Request $request)
   {
        $rules = ['transaction_id' => 'required|exists:transactions,id'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            
            $transaction = Transaction::where('id',$request->transaction_id)
            // ->where('vendor_id', Auth::id())
            ->with(['Customer','Vendor'])
            ->first();
            return parent::success("View transaction successfully!",$transaction);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }

   public function FilterTransaction(Request $request){
    $rules = ['type'=>'required','month'=>'','date_from'=>'','date_to'=>'','processing_status'=>'required','payment_status'=>'required'];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $model = new Transaction();
        if($request->type === '1'):
            if(isset($request->date_from) && isset($request->date_to)):
                $model = $model->whereBetween('order_date', [$request->date_from, $request->date_to] );
            endif;
        endif;
        
        $model = $model->orderBy('created_at','DESC')
                        ->where('status',$request->processing_status)
                        ->where('payment_status', $request->payment_status)
                        ->get();
        return parent::success("Filter transaction successfully!",$model);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
   }



   public function Refund(Request $request)
   {
        $rules = ['order_id' => 'required','cus_id' =>'required','refund_preference'=>'required','reason'=>'','amount'=>'required','ship_from'=>'required','','shipping_type'=>'required'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $input['vendor_id'] = Auth::id();
            $refund = Refund::create($input);
            if($refund):
                // $item = Item::FindOrfail($refund->order_id);
                //     $item->fill(['status' => '5']);
                //     $item->save();

            endif;
          return  parent::success("Refund initiate successfully!",$refund);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function DeleteProductImage(Request $request)
   {
        $rules = ['product_id'=> 'required|exists:products,id','image'=>'required'];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules), true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            $input = $request->all();
            $product = product::select('id','image','name')->where('id', $request->product_id)->first();
            // dd($product->image);
          
            $arr = array_diff($product->image, array($request->image));
          $image  = implode(',', $arr);
          Product::where('id', $request->product_id)->update(['image' => $image]);
            return parent::success("product image removed successfully!");

        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }


   public function Revenue(Request $request){
    $rules = ['month'=>'', 'year'=>''];
    $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        
       
        $users = Transaction::select('id', 'order_date','price');
        if(isset($request->year)):
            $users = $users->whereYear('order_date', $request->year);
    endif;
        $users = $users->where('vendor_id',Auth::id())->get()->groupBy(function ($date) {
            return Carbon::parse($date->order_date)->format('m');
        });

        $usermcount = [];
        $userArr = [];
        $usermprice = [];
        $price = "0";
    foreach ($users as $key => $value) {
    //   dd($key);
        $usermcount[(int)$key] = count($value);
        foreach($value as $val){
            $price += $val->price;
        }
        $usermprice[(int)$key] = $price;
        $price= "0";
    }

    $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    for ($i = 1; $i <= 12; $i++) {
        if (!empty($usermcount[$i])) {
            $userArr[$i]['count'] = $usermcount[$i];
            $userArr[$i]['sum'] = number_format($usermprice[$i],2);
        } else {
            $userArr[$i]['count'] = 0;
            $userArr[$i]['sum'] = "0";
        }
        $userArr[$i]['month'] = $month[$i - 1];
    }
        // dd($userArr);
    // return response()->json(array_values($userArr));

       
        return parent::success("Filtered transactions successfully!", array_values($userArr));
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }

   }

   public function getShippingPrice(Request $request){
        $rules = [];
        $validateAttributes = parent::validateAttributes($request,'POST',$rules,array_keys($rules),true);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        try{
            // $ShippingRate = helper::getShippingPrice();
            
            // return parent::success("view shipping rate sucessfully!",$ShippingRate);
        }catch(\Exception $ex){
            return parent::error($ex->getMessage());
        }
   }

public function SchedulePickup(Request $request){
    $rules = ['store_id' => 'required|exists:stores,id','weight'=>'required','no_of_product'=>'required', 'package_location_desc'=>'','item_id' => 'required|exists:items,id'];
    $validateAttributes = parent::validateAttributes($request,"POST",$rules,array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $SchedulePickup = Helper::SchedulePickup($request->store_id, $request->weight, $request->no_of_product, $request->package_location_desc);
        // dd($SchedulePickup);
        if(!$SchedulePickup['status']):
            return parent::error($SchedulePickup['message']);
        endif;
        $item = Item::FindOrfail($request->item_id);
                $item->fill(['schedule_pickup' => '1']);
                $item->save();
            // dd($SchedulePickup);
        return parent::success($SchedulePickup['message'],['item' => $item ,'schedule' => $SchedulePickup['data']]);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function ResetUserPassword(Request $request)
{
    $rules = ['token' =>'required','password' =>'required'];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $email = base64_decode($request->token);
      
        $user = User::find($email);
        if($user === null):
            return parent::error("Invalid Token");
        endif;
        $password = hash::make($request->password);
        $user->fill(['password' => $password]);
        $user->save();
        return parent::success("Password changed successfully!");

    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


public function Banner(Request $request){
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules),true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $banner = Banner::orderBy('created_at','DESC')->get();
        return parent::success("Banner view successfully!", $banner);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}

public function eVS(Request $request)
{
   
    $rules = ['item_id' => 'required|exists:items,id', 'product_id'=> 'required|exists:products,id','store_id'=> 'required|exists:stores,id','width' =>'required','height'=>'required','length' =>'required','pound' =>'required'];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
       
            $input = $request->all();
            // dd($request->item_id);
            $item = Item::FindOrfail($request->item_id);
            // dd($item->toArray());
        $label = Helper::UPSP($item, $request->product_id, $item['address_id'], $item->vendor_id,  $request->store_id, $input);
      
        $item = Item::FindOrfail($request->item_id);
    
        $item->fill(['tracking_id' => $label['tracking_id'],'tracking_label' =>  $label['print_label']]);
        $item->save();
        return parent::success("Shipping Label generated successfully!",$label);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


public function TrackUsers(Request $request)
{
    $rules = [];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $ip = $request->ip();
        $ip = TrackUser::updateOrCreate(['ip' => $ip],[
            'ip' => $ip
        ]);
        return parent::success("Get User info successfully!",$ip);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}


public function BarcodeLookup(Request $request)
{
    $rules = ['barcode' => 'required','key' => 'required'];
    $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), true);
    if($validateAttributes):
        return $validateAttributes;
    endif;
    try{
        $input = $request->all();
        $barcodeLookup = Helper::BarcodeLookup($input);
        return parent::success("View Product Successfully",$barcodeLookup);
    }catch(\Exception $ex){
        return parent::error($ex->getMessage());
    }
}































}
