<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AccessControlMiddleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/PrivacyPolicy', function () {
    return view('privacy_policy');
});

Route::get('terms_and_conditions', function(){
    return view('terms_and_conditions');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
       // Route::get('/post', [AdminController::class, "index"]); 
   Route::get('/order-management',[AdminController::class, "orderManagement"]);
   Route::get('shipping-order-details/{id}',[AdminController::class, "ShippingOrderDetails"]);
   Route::get('vendor-management',[VendorController::class,"index"]);
   Route::get('subscription-plan',[VendorController::class,"SubscriptionPlan"]);
 });
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 