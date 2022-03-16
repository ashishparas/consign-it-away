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
    Route::post('add/store',[VendorController::class,"AddStore"]);
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
    
});


