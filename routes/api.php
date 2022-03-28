<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\VendorController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,"Register"])->middleware('registerUser');
Route::post('login',[AuthController::class, "Login"]);
Route::post('social/login',[AuthController::class, "SocialLogin"]);
Route::post('forget/password',[AuthController::class, "ResetPassword"]);




Route::group(['middleware' =>['auth:api']], function(){
    
});


Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('logout',[AuthController::class, "Logout"]);
    Route::post('otp/verification',[AuthController::class,"VerifyOTP"]);
    Route::post('create/profile',[VendorController::class, "CreateProfile"]);
    Route::post('edit/vendor/profile',[VendorController::class, "EditVendorProfile"]);
    Route::post('add/store',[VendorController::class,"AddStore"]);
    Route::post('edit/store',[VendorController::class,"EditStore"]);
    Route::post('create/product',[VendorController::class, "Product"]);
    Route::post('get/categories',[VendorController::class, "getCategories"]);
    Route::post('resend/otp',[AuthController::class, "resendOTP"]); 
    Route::post('resend/email/otp',[AuthController::class, "ResendEmailOTP"]);
    Route::post('client/view/profile',[ClientController::class, "ClientViewProfile"]);
    Route::post('client/edit/profile',[ClientController::class, "UpdateClientProfile"]);
    Route::post('change/password',[AuthController::class, "changePassword"]);
    Route::post('view/store',[VendorController::class, "ViewStore"]);
    Route::post('add/bank',[VendorController::class, "AddBank"]);
    Route::post('create/address',[ClientController::class, "Address"]);  
    Route::post('edit/address',[ClientController::class, "EditAddress"]);
    Route::post('view/addresses',[ClientController::class, "ViewAddress"]);
    Route::post('contact',[ClientController::class,'Contact']);
    Route::post('home',[ClientController::class,"Home"]);
    Route::post('rating',[ClientController::class, "Rating"]);
    Route::post('favourite',[ClientController::class,"Favourite"]);
    Route::post('product/by/id',[ClientController::class,"ProductById"]);
    Route::post('favourite/list',[ClientController::class,"FavouriteList"]);
    Route::post('delete/favourite',[ClientController::class,"DeleteFavourite"]);
    Route::post('add/staff',[VendorController::class, "Staff"]);
    Route::post('view/staff',[VendorController::class, "ViewStaff"]);
    Route::post('delete/staff',[VendorController::class,"DeleteStaff"]);
    Route::post('edit/staff',[VendorController::class, "EditStaff"]);
    Route::post('view/product',[VendorController::class, "ViewProduct"]);
    Route::post('delete/product',[VendorController::class, "DeleteProduct"]);
    Route::post('add/discount',[VendorController::class, "Discount"]);
    Route::post('update/discount',[VendorController::class, "UpdateDiscount"]);
    Route::post('expired/discount',[VendorController::class, "ExpiredDiscount"]);
    Route::post('add/card',[ClientController::class,"Card"]);
    Route::post('edit/card',[ClientController::class,"EditCard"]);
    Route::post('delete/card',[ClientController::class, "DeleteCard"]);
    Route::post('view/card',[ClientController::class, "ViewCard"]);
    Route::post('proceed',[VendorController::class, "Proceed"]);
    Route::post('vendor/view/profile',[VendorController::class, "ViewProfile"]);
    Route::post('subscription',[VendorController::class, "Subscriptions"]);
    Route::post('subscription/by/id',[VendorController::class, "SubscriptionPlanById"]);
    
});


