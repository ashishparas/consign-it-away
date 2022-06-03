<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
       
        return view('admin.dashboard');
    }

    public function OrderManagement(){
        $items = Item::with('Product')
        ->whereIn('status',['1','2','3'])
                        ->take(10)
                        ->orderBy('created_at','DESC')
                        ->get();
        $PastOrders = Item::with('Product')
                            ->whereIn('status',['3','4'])
                            ->take(10)
                            ->get();
        // dd($items->toArray());
        return view('order-management.order-mgt', compact('items','PastOrders'));
    }


    public function ShippingOrderDetails($id){
      $items = Item::where('id', $id)->with(['Product','Rating','Customer','Address'])->first();

    //   dd($items->toArray());
        return view('order-management.shipping-orders-details', compact('items'));
    }
}
