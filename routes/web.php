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
    return redirect('/login');
});

Route::get('/PrivacyPolicy', function () {
    return view('privacy_policy');
});

Route::get('terms_and_conditions', function(){
    return view('terms_and_conditions');
});

Route::get('return_and_refund', function(){
    return view('return_and_refund');
});
Route::get('license', function(){
    return view('license');
});


Auth::routes();




Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
       // Route::get('/post', [AdminController::class, "index"]); 
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            Route::get('/order-management',[AdminController::class, "orderManagement"]);
            Route::get('shipping-order-details/{id}',[AdminController::class, "ShippingOrderDetails"]);
            Route::get('vendor-management',[VendorController::class,"index"]);
            Route::get('subscription-plan',[VendorController::class,"SubscriptionPlan"]);
            Route::get('vendor-products',[VendorController::class, "VendorProducts"]);
            Route::get('product/detail/vendor/{id}',[VendorController::class,"ViewProductDetailsById"]);
            Route::get('report-management',[VendorController::class, "ViewReports"]);
            Route::get('running-orders',[VendorController::class, "RunningOrders"]);
            Route::get('vendor-edit-profile/{id}',[VendorController::class, "VendorEditProfile"]);
            Route::get('staff-management',[VendorController::class,"StaffManagement"])->name('staff-management');
            Route::get('add-staff',[VendorController::class, "AddStaff"]);
            Route::post('create-staff', [VendorController::class, "CreateStaff"]);
            Route::get('delete/staff/{id}',[VendorController::class, "DeleteAdminStaff"]);
            Route::get('brand-list',[AdminController::class,"Brand"])->name('brand.list');
            Route::get('brand/list/data',[AdminController::class,"BrandList"])->name('brand-list-data');
            Route::get('edit-brand/{id}',[AdminController::class,"EditBrand"]);
            Route::post('update-brand',[AdminController::class,"UpdateBrand"]);
            Route::get('create/product',[VendorController::class, "CreateProduct"]);
 });
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 