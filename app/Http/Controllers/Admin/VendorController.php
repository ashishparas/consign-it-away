<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminStaff;
use App\Models\AttributeOption;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Contact;
use App\Models\Discount;
use App\Models\Item;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Subcategory;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\Transaction;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;
use App\Helper\Helper;
use App\Models\Banner;

class VendorController extends Controller
{





    protected static function __uploadImage($image, $path = null, $thumbnail = false)
    {

        if ($path === null)
            $path = public_path('vendor');
        $digits = 3;
        $imageName = time() . rand(pow(10, $digits - 1), pow(10, $digits) - 1) . '.' . $image->getClientOriginalExtension();
        $image->move($path, $imageName);

        return $imageName;
    }






    public function index()
    {
        $vendors = User::select('id', 'name', 'fname', 'lname', 'email', 'profile_picture','phonecode','mobile_no')->where('type', '2')->get();
        $products = Product::select(DB::raw('DISTINCT user_id'), 'id', 'store_id', 'image', 'name', 'quantity', 'price', 'created_at')->with('User')->get();
      
        return view('admin.vendor-management.vendor-mgt', compact('vendors', 'products'));
    }


    public function SubscriptionPlan()
    {
        $subscriptions = SubscriptionPlan::get();
        // dd($subscriptions->toArray());
        return view('admin.subscriptions.subscription-plans', compact('subscriptions'));
    }


    public function VendorProducts()
    {
        $products = Product::select('id', 'name', 'image', 'quantity', 'status', 'price')
                                ->orderBy('created_at','DESC')
                                ->get();
        // dd($products->toArray());
        return view('admin.vendor-management.vendor-products', compact('products'));
    }


    public function ViewProductDetailsById($id)
    {

        $product = Product::where('id', $id)->with(['PorductRating', 'Store'])->first();
        //    dd($product->toArray());
        return view('admin.vendor-management.product-details-vendor', compact('product'));
    }


    public function ViewReports()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->get();
        // dd($contacts->toArray());
        return view('admin.report.report-management', compact('contacts'));
    }

    public function RunningOrders()
    {
        $items = Item::with('Product')
            ->whereIn('status', ['1', '2', '3'])
            // ->take(10)
            ->orderBy('created_at', 'DESC')
            ->get();
        // dd($items->toArray());
        return view('admin.order.running-orders', compact('items'));
    }

    public function VendorEditProfile($id)
    {
        //DB::enableQueryLog();
        $vendors = Store::where('user_id', $id)
                ->with(['Manager','Product','PorductRating','Vendor','Subscription'])
                ->first();
                //   dd(DB::getQueryLog($vendors));
        return view('admin/vendor-management.vendor-profile-edit', compact('vendors'));
    }


    public function StaffManagement()
    {
        $AdminStaffs = AdminStaff::orderBy('created_at', 'DESC')->get();
        return view('admin.staff.staff_mgt', compact('AdminStaffs'));
    }

    public function AddStaff()
    {

        return view('admin.staff.add_staff_mgt');
    }

    public function CreateStaff(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile_no' => 'required',
            'role'   => 'required|in:1,2,3,4,5,6,7,8',
            'image' => ''
        ]);

        try {

            $input = $request->all();
            // dd($input);
            if (isset($request->image)) :

                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('/admin_staff'), $imageName);
                $input['image'] = $imageName;
            endif;


            $staff = AdminStaff::create($input);
            if ($staff) :
                return redirect()->route('staff-management');
            endif;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }


    public function DeleteAdminStaff($id)
    {
        $staff = AdminStaff::FindOrfail($id);
        $staff->delete();
        return redirect()->route('staff-management')->with('message', 'Staff Deleted Successfully!');
    }


    public function CreateProduct(User $User)
    {

        $users = $User->select('id', 'name', 'fname', 'lname')->whereNotIn('id', [1])->orderBy('created_at', 'DESC')->with(['Store'])->get();
        $categories = Category::get();
        $brands = Brand::take(1000)->get();
        $colors = Colour::get();
        // $discount = Discount::where()->get()

        return view('admin.products.product-create', compact('users', 'categories', 'brands', 'colors'));
    }



    public function StoreProduct(Request $request)
    {
        $input = $request->all();
  
        $rules =[];
        
        if ($request->is_variant === '1') {
            //dd("is not variant product");
            $rules = [
                'name' => 'required', 'image' => 'required', 'category_id' => 'required',
                'subcategory_id' => 'required|exists:subcategories,id',
                'description' => 'required', 'price' => 'required', 'discount' => '',
                'brand' => 'required', 'color' => 'required', 'quantity' => 'required',
                'weight' => 'required', 'condition' => 'required', 'dimensions' => '',
                'available_for_sale' => 'required|in:1,2', 'constomer_contact' => 'required|in:1,2',
                'inventory_track' => 'required|in:1,2', 'product_offer' => '', 'ships_from' => 'required', 'shipping_type' => 'required', 'free_shipping' => 'required|in:1,2', 'meta_description' => '',
                'meta_tags' => '', 'meta_keywords' => '', 'title' => '', 'variants' => '',
                'state' => '', 'tags' => '', 'advertisement' => '', 'selling_fee' => '',
                'amount' => '', 'is_variant' => 'required|in:1,2', 'store_id' => 'required|exists:stores,id'
            ];
        }elseif($request->is_variant === '2'){
           // dd("is  variant product");
            $rules = [
                'name'=> 'required',
                'image'=>'required',
                'category_id' =>'required',
                'subcategory_id' => 'required|exists:subcategories,id',
                'description' => 'required',
                'price' => 'required',
                'discount' => '',
                'brand' => 'required',
                'color' =>'required', 
                'quantity' => 'required',
                'weight' =>'required', 
                'condition'=>'required', 
                'dimensions' =>'',
                'available_for_sale' => 'required|in:1,2',
                'constomer_contact'=> 'required|in:1,2',
                'inventory_track' => 'required|in:1,2',
                'product_offer' => '',
                'ships_from'=>'required', 
                'shipping_type' => 'required', 
                'meta_description' => '',
                'meta_tags' => '', 
                'meta_keywords' => '', 
                'title' => '', 
                'variants' => 'required',
                'state'=> '',
                'tags' =>'',
                'advertisement' =>'', 
                'selling_fee' =>'', 
                'amount' => '',
                'is_variant'=>'required|in:1,2',
                'store_id' =>'required|exists:stores,id'];
        }
        $validate = $request->validate($rules);
       

        

        if (isset($request->image)) :

            if ($files = $request->file('image')) :
                foreach ($files as $file) :

                    $images[] = parent::__uploadImage($file, public_path('products'), false);

                endforeach;
            endif;

            $input['image'] = implode(',', $images);

        endif;
       
        if(isset($request->Length) && isset($request->Breadth) && isset($request->Height)){
            $dimension =     array('Length'=> $request->Length,'Breadth'=>$request->Breadth,'Height'=>$request->Height);
           
        }  
        $input['user_id'] = $request->vendor_name;
        $input['dimensions'] = $dimension? json_encode($dimension):null;
        $input['product_offer'] = $request->product_offer?$request->product_offer:2;
    
        $create = Product::create($input);
       
        $product = Product::where('id', $create->id)->first();
        if ($product) {
            
            Stock::create([
                'product_id' => $product->id,
                'stock'      => $product->quantity,
            ]);


            if ($product->variants) {
                $arribute_json = json_decode($product->variants, true);

                $atrributes = array_keys($arribute_json);

                for ($i = 0; $i < count($atrributes); $i++) {
                    $saveAttr = \App\Models\Attribute::create([
                        'name' => $atrributes[$i],
                        'product_id' => $product->id
                    ]);
                    if ($saveAttr) {
                        $options = $arribute_json[$saveAttr->name];

                        for ($j = 0; $j < count($options); $j++) {
                            AttributeOption::create([
                                'name' => $options[$j],
                                'attr_id' => $saveAttr->id
                            ]);
                        }
                    }
                } // end for loop
            }
            return redirect()->route('vendor.product.list')->with('success','Product listed successfully!');
        }
    }







    public function ViewStoreById(Request $request)
    {
        if ($request->ajax()) {
            $store = Store::where('user_id', $request->id)->get();
            return response()->json($store);
        }
    }

    public function ViewSubCategory(Request $request)
    {
        if ($request->ajax()) {
            $subCategories = Subcategory::where('category_id', $request->id)->get();
            return response()->json($subCategories);
        }
    }

    public function ViewTransaction()
    {
        $withdraws = Withdraw::with(['User'])->get();
        $transactions = Transaction::with(['Vendor'])->with(['OrderDetails'])->get();
        //dd($transactions->toArray());
        return view('admin.transaction.view-transaction', compact('withdraws', 'transactions'));
    }
    
    public function CategoryManagement()
    {
        $Categories = Category::orderBy('created_at', 'DESC')->get();
        return view('admin.category.category_mgt', compact('Categories'));
    }
    
    public function AddCategory()
    {
        return view('admin.category.category-create');
    }
    
    public function CreateCategory(Request $request)
    {
        $input = $request->all();
        
        $request->validate([
            'title' => 'required',
            'image' => ''
        ]);

        try {

            $input = $request->all();
            
            $type = str_replace(' ', '_', $request->title);
            $input['type'] = $type;
            // dd($input);
            if (isset($request->image)):
                $input['image'] = parent::__uploadImage($request->file('image'), public_path('/category'), false);
            endif;

            $Category = Category::create($input);
            if ($Category) :
                return redirect()->route('category-management');
            endif;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }
    
    public function DeleteCategory($id)
    {
        $staff = Category::FindOrfail($id);
        $staff->delete();
        return redirect()->route('category-management')->with('message', 'Category Deleted Successfully!');
    }
    
    public function AddSubCategory($id)
    {
        return view('admin.category.subcategory-create', compact('id'));
    }
    
    public function CreateSubCategory(Request $request)
    {
        $input = $request->all();
        
        $request->validate([
            'title' => 'required',
            'image' => ''
        ]);

        try {

            $input = $request->all();
            // dd($input);
            if (isset($request->image)):
                $input['image'] = parent::__uploadImage($request->file('image'), public_path('/category'), false);
            endif;

            $subCategory = Subcategory::create($input);
            if ($subCategory) :
                return redirect()->route('category-management')->with('success', 'Sub-category Added successfully!');
            endif;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }
    
    public function SubCategoryManagement()
    {
        $subcategories = Subcategory::with('Category')->get();
       // echo "<pre>"; print_r($subcategories); die;
        return view('admin.subcategory.subcategory_mgt', compact('subcategories'));
    }
    
    public function DeleteSubCategory($id)
    {
        $staff = Subcategory::FindOrfail($id);
        $staff->delete();
        return redirect()->route('subcategory-management')->with('message', 'Sub Category Deleted Successfully!');
    }

    public function EditCategory($id){
        $category = Category::FindOrfail($id);
        return view('admin/category/edit-category',compact('category'));
    }
    
    public function UpdateCategory(Request $request){
        $input = $request->all();
 
            
        $category = Category::FindOrfail($request->id);
        if (isset($request->image)):
            $input['image'] = parent::__uploadImage($request->file('image'), public_path('/category'), false);
        endif;

                $category->fill($input);
                $category->save();
        return redirect()->route('category-management');
            
    }
    
    public function EditSubCategory($id){
        $subcategory = Subcategory::FindOrfail($id);
        return view('admin/subcategory/edit-subcategory',compact('subcategory'));
    }
    
    public function UpdateSubCategory(Request $request){
        $input = $request->all();
 
            
        $category = Subcategory::FindOrfail($request->id);
        if (isset($request->image)):
            $input['image'] = parent::__uploadImage($request->file('image'), public_path('/category'), false);
        endif;

                $category->fill($input);
                $category->save();
        return redirect()->route('subcategory-management');
            
    }
    
    public function ViewTransactionDetailsById($id)
    {
        $transaction = Transaction::where('id', $id)->with(['Vendor','Product','OrderDetails'])->first();
          // dd($transaction->toArray());
        return view('admin/transaction/transaction-detail', compact('transaction'));
    }
    
    public function ViewTransactionInvoice($id)
    {
        $transaction = Transaction::where('id', $id)->with(['Vendor','Product','Item'])->first();
           //dd($transaction->toArray());
        return view('admin/transaction/transaction-invoice', compact('transaction'));
    }
    
    public function withdrawAccept(Request $request){
        $input = $request->all();
   
        $Withdraw = Withdraw::FindOrfail($request->id);
        $input['status'] = '1';
       
        $Withdraw->fill($input);
        $Withdraw->save();
        return redirect()->back()->with(['success' => 'Withdraw Accepted']);
            
    }
    
    public function withdrawReject(Request $request){
        $input = $request->all();
   
        $Withdraw = Withdraw::FindOrfail($request->id);
        $input['status'] = '2';
       
        $Withdraw->fill($input);
        $Withdraw->save();
        return redirect()->back()->with(['error' => 'Withdraw Rejected']);
            
    }
    
    public function CreateVendor(Request $request)
    {
        
       $input = $request->all();
       $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phonecode' => 'required',
            'mobile_no' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zipcode'=> 'required',
            'paypal_id' =>'required',
            'bank_ac_no' => 'required',
            'routing_no' => 'required'
            
        ]);

        try {

            $input = $request->all();
            $phonecode =  str_replace('+','', $input['phonecode']);
            $input['phonecode'] = '+'.$phonecode;
            
            $fullname = $input['fname'].' '.$input['lname'];
            $input['name'] = $fullname;
            $input['vendor_status'] = '2';
            $input['type'] = '2';
            $input['status'] = '2';


            $User = User::create($input);
            
            $lastInsertID = $User->id;
         
            if ($User) :
                return redirect()->route('add-store', ['id' => $lastInsertID]);
            endif;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }
    
    public function AddVendor(Request $request)
    {
        
        return view('admin.vendor-management.create-vendor');
    }
    
    public function AddStore(Request $request,$id)
    {
        $user_id = $id;
       
        return view('admin.store.create-store', compact('user_id'));
    }
    
    public function CreateStore(Request $request)
    {
      
        $input = $request->all();
        $request->validate([
            'name' => 'required',
            'location' => 'required'
            
        ]);

        try {
            $input = $request->all();
            
           
            if (isset($request->banner)):
                $input['banner'] = parent::__uploadImage($request->file('banner'), public_path('/vendor'), false);
            endif;

            if (isset($request->store_image)):
                $input['store_image'] = parent::__uploadImage($request->file('store_image'), public_path('/vendor'), false);
            endif;

           
            $Store = Store::create($input);
            
            $lastInsertID = $Store->id;
         
            if ($Store) :
                return redirect()->route('add-manager', ['id' => $lastInsertID]);
            endif;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
       
    }
    
    public function AddManager(Request $request,$id)
    {
        $user_id = $id;
        return view('admin.manager.create-manager', compact('user_id'));
    }
    
    public function CreateManager(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phonecode' => 'required',
            'mobile_no' => 'required'
            
        ]);

        try {

            $input = $request->all();
            if (isset($request->profile_picture)):
                $input['profile_picture'] = parent::__uploadImage($request->file('profile_picture'), public_path('/vendor'), false);
            endif;
            
            $input['status'] = '2';
            $Manager = Manager::create($input);
         
            if ($Manager) :
                return redirect()->route('vendor-management');
            endif;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }
    
    public function generateInvoicePDF($id)
    {
        $transaction = Transaction::where('id', $id)->with(['Vendor','Product','Item'])->first();
        $data = [
            'transaction' => $transaction
            
        ];
           
        $pdf = PDF::loadView('admin/transaction/invoicePDF', $data);
    
        return $pdf->download('consign.pdf');
    }
    
    public function emailInvoice($id)
    {
        $transaction = Transaction::where('id', $id)->with(['Vendor','Product','Item'])->first();
       // dd($transaction->toArray());
        $email = $transaction->vendor->email;
        $name = $transaction->vendor->name;
        $header = "Invoice";
        
       
        $html = view('admin/transaction/invoicePDF',compact('transaction'));
        $val = "$html"; 
       
        
        Helper::SendVarificationEmail($email, $name, $val, $header);
        
        return redirect()->route('transactions');
        
    }
    
    public function ViewReportsDetail($id)
    {
         $contact = Contact::where('id', $id)->first();
     
        return view('admin.report.report-detail', compact('contact'));
    }
    
    public function AddPlans()
    {
        return view('admin.subscriptions.create-plans');
    }
    
    public function CreatePlans(Request $request)
    {
        $input = $request->all();
        $features = implode(',', $request->features);
        $features_arr = array(array("name"=>$features));
        
        $request->validate([
            'name' => 'required',
            'monthly_price' => 'required',
            'yearly_price' => 'required',
            'content' => 'required',
            'features' => 'required'
        ]);

        try {

            $input = $request->all();
            $input['features'] = json_encode($features_arr);

            $SubscriptionPlan = SubscriptionPlan::create($input);
         
            if ($SubscriptionPlan) :
                return redirect()->route('subscription-plan');
            endif;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
        }
    }
    
    public function DeletePlans($id)
    {
        $SubscriptionPlan = SubscriptionPlan::FindOrfail($id);
        $SubscriptionPlan->delete();
        return redirect()->route('subscription-plan')->with('message', 'Plan Deleted Successfully!');
    }
    
    public function EditPlans($id){
        $subscriptionPlan = SubscriptionPlan::FindOrfail($id);
        return view('admin/subscriptions/edit-plans',compact('subscriptionPlan'));
    }
    
    public function UpdatePlans(Request $request){
        $input = $request->all();
 
            
        $subscriptionPlan = SubscriptionPlan::FindOrfail($request->id);
     
                $subscriptionPlan->fill($input);
                $subscriptionPlan->save();
        return redirect()->route('subscription-plan');
            
    }

    public function bannerList(){
        $banners = Banner::orderBy('created_at','DESC')->get();
        return view('admin.banner.banner-list', compact('banners'));
    }

    public function createBanner(){
        return view('admin.banner.banner-create');
    }

    public function storeBanner(Request $request){
        $validate = $request->validate([
            'photo' =>'required'
        ]);
        
        $input = $request->all();
       
        if (isset($request->photo)):
            $input['photo'] = parent::__uploadImage($request->file('photo'), public_path('/banner'), false);
        endif;
        $input['baseurl'] = asset('public/banner');
        Banner::create($input);
        return redirect()->route('banner-list')->with('success','App Banner added successfully');
    }

    public function deleteBanner($id)
    {
        $banner = Banner::FindOrfail($id);
        $banner->delete();
        return redirect()->route('banner-list')->with('error','banner deleted successfully!');
    }

}
