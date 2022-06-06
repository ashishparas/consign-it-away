<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index(){
        $vendors = User::select('id','name','fname','lname','email','profile_picture')->where('type','2')->get();
        $products = Product::select(DB::raw('DISTINCT user_id'),'id','store_id','image','name','quantity','price','created_at')->with('User')->get();
        // dd($products->toArray(   ));  
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
       
        $product = Product::where('id', $id)->with(['PorductRating'])->first();
       // dd($product->toArray());
        return view('admin.vendor-management.product-details-vendor', compact('product'));
    }

}
