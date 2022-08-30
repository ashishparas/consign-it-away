<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TrackUser;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
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
        
        // dd($transactions);
        return view('home',compact('UserCount','OrderCount','transaction','transactions','trackUser'));
    
    }



}
