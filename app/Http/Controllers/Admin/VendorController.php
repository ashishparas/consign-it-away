<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminStaff;
use App\Models\Contact;
use App\Models\Item;
use App\Models\Product;
use App\Models\Store;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{





    protected static function __uploadImage($image, $path = null, $thumbnail = false) {
   
        if ($path === null)
            $path = public_path('vendor');
        $digits = 3;
        $imageName = time() . rand(pow(10, $digits - 1), pow(10, $digits) - 1) . '.' . $image->getClientOriginalExtension();
        $image->move($path, $imageName);

        return $imageName;
    }






    public function index(){
        $vendors = User::select('id','name','fname','lname','email','profile_picture')->where('type','2')->get();
        $products = Product::select(DB::raw('DISTINCT user_id'),'id','store_id','image','name','quantity','price','created_at')->with('User')->get();
        // dd($products->toArray());  
        return view('admin.vendor-management.vendor-mgt',compact('vendors','products'));    
    }


    public function SubscriptionPlan(){
        $subscriptions = SubscriptionPlan::get();
        // dd($subscriptions->toArray());
        return view('admin.subscriptions.subscription-plans',compact('subscriptions'));
    }


    public function VendorProducts()
    {
        $products = Product::select('id','name','image','quantity','status','price')->get();
        // dd($products->toArray());
        return view('admin.vendor-management.vendor-products', compact('products'));
    }


    public function ViewProductDetailsById($id){
       
        $product = Product::where('id', $id)->with(['PorductRating','Store'])->first();
    //    dd($product->toArray());
        return view('admin.vendor-management.product-details-vendor', compact('product'));
    }


    public function ViewReports(){
        $contacts = Contact::orderBy('created_at','DESC')->get();
        // dd($contacts->toArray());
        return view('admin.report.report-management',compact('contacts'));
    }

    public function RunningOrders()
    {
        $items = Item::with('Product')
        ->whereIn('status',['1','2','3'])
                        ->take(10)
                        ->orderBy('created_at','DESC')
                        ->get();
                        // dd($items->toArray());
        return view('admin.order.running-orders',compact('items'));
    }

    public function VendorEditProfile($id){
        // dd($id);
        return view('admin/vendor-management.vendor-profile-edit');
    }


    public function StaffManagement(){
        $AdminStaffs = AdminStaff::orderBy('created_at','DESC')->get();
        return view('admin.staff.staff_mgt', compact('AdminStaffs'));
    }

    public function AddStaff(){
        
        return view('admin.staff.add_staff_mgt');
    }

    public function CreateStaff(Request $request){
        $input = $request->all();
       $request->validate([
           'name' =>'required',
           'email' => 'required',
           'mobile_no' =>'required',
           'role'   => 'required|in:1,2,3,4,5,6,7,8',
           'image' => ''
       ]);

       try{
       
        $input = $request->all();
        // dd($input);
        if (isset($request->image)):
          
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('/admin_staff'), $imageName);
            $input['image'] = $imageName;
        endif;

       
        $staff = AdminStaff::create($input);
        if($staff):
            return redirect()->route('staff-management');
        endif;

       }catch(\Exception $ex){
        dd($ex->getMessage());
       }

    }


    public function DeleteAdminStaff($id){
        $staff = AdminStaff::FindOrfail($id);
                $staff->delete();
        return redirect()->route('staff-management')->with('message', 'Staff Deleted Successfully!');
    }


    public function CreateProduct(User $User){
        $users = $User->select('id','name','fname','lname')->whereNotIn('id', [1])->orderBy('created_at','DESC')->with(['Store'])->get();
     
        return view('admin.product.product-create',compact('users'));
    }

























}
