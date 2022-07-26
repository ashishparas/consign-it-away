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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $vendors = User::select('id', 'name', 'fname', 'lname', 'email', 'profile_picture')->where('type', '2')->get();
        $products = Product::select(DB::raw('DISTINCT user_id'), 'id', 'store_id', 'image', 'name', 'quantity', 'price', 'created_at')->with('User')->get();
        // dd($products->toArray());  
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
            ->take(10)
            ->orderBy('created_at', 'DESC')
            ->get();
        // dd($items->toArray());
        return view('admin.order.running-orders', compact('items'));
    }

    public function VendorEditProfile($id)
    {
        // dd($id);
        return view('admin/vendor-management.vendor-profile-edit');
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
        $withdraws = Withdraw::get();
        dd($withdraws->toArray());
        return view('admin.transaction.view-transaction', compact('withdraws'));
    }





































}
