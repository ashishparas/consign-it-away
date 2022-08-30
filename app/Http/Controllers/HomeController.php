<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\TrackUser;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $UserCount  = User::where('id','!=',1)->count();
       
        $OrderCount = Order::count();
      
        $transaction = Transaction::sum('price');
        $trackUser = TrackUser::count();
       
        $transactions = Transaction::with(['Vendor'])->with(['OrderDetails'])->orderBy('id','DESC')->limit(5)->get();
        $mostPopulars = Item::select('product_id','vendor_id', DB::raw('COUNT(product_id) as count'))
                        ->with(['Product','SoldBy'])
                        ->groupBy('product_id')
                        ->orderBy('count','DESC')
                        ->take('10')
                        ->get();
        // dd($mostPopulars->toArray());
        
        return view('home',compact('UserCount','OrderCount','transaction','transactions','trackUser','mostPopulars'));
    
    }



}
