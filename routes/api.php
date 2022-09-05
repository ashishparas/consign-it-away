<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\VendorController;
use Facade\FlareClient\Http\Client;
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
Route::post('csv',[VendorController::class, "CSV"]);
Route::post('reset/password',[VendorController::class,"ResetUserPassword"]);
Route::post('usps/address/verify',[ClientController::class, "UspsVerifyAddress"]);
Route::post('find/address/by/zip',[ClientController::class, "UspsFindAddressByZip"]); 
Route::post('track/courier',[ClientController::class, "UspsTrackCourier"]);  
Route::post('find/rate',[ClientController::class, "UspsFindRate"]); 
Route::post('subcategories',[VendorController::class, "SubCategories"]);
Route::post('colours',[VendorController::class, "Colours"]);

// Route::group(['middleware' =>['auth:api']], function(){
    
// });

Route::post('get/categories',[VendorController::class, "getCategories"]);
Route::post("brands",[VendorController::class,"Brands"]);
Route::get('invite/friend',[AuthController::class,"InviteFriend"]);
Route::get('share/product/{id}',[AuthController::class, "ShareProduct"]);
Route::get('most/popular/products',[ClientController::class, "MostPopularsProducts"]);

Route::post('search', [ClientController::class, "Search"]);


$middleware = ['api'];
if (\Request::header('Authorization'))

    $middleware = array_merge(['auth:sanctum']);
    Route::group(['middleware' => $middleware], function () {

    Route::post('home', [ClientController::class, "Home"]);
    Route::post('product/by/id',[ClientController::class,"ProductById"]);
    Route::get("product/filter",[ClientController::class,"ProductFilter"]);
    Route::get('recently/view/products',[ClientController::class, "RecentlyViewProducts"]);
    Route::post('client/view/store/by/id',[ClientController::class, "ClientViewStore"]);
    Route::post('banner/list',[VendorController::class, "Banner"]);
    Route::post('get/vistors',[VendorController::class, "TrackUsers"]);
});

Route::middleware(['auth:sanctum'])->group(function(){
    
    Route::post('logout',[AuthController::class, "Logout"]);
    Route::post('otp/verification',[AuthController::class,"VerifyOTP"]);
    Route::post('create/profile',[VendorController::class, "CreateProfile"]);
    Route::post('edit/vendor/profile',[VendorController::class, "EditVendorProfile"]);
    Route::post('add/store',[VendorController::class,"AddStore"]);
    Route::post('edit/store',[VendorController::class,"EditStore"]);
    Route::post('create/product',[VendorController::class, "Product"])->middleware('advancedProduct');
    
    Route::post('submit/product',[VendorController::class, "SubmitProduct"]);
    Route::post('resend/otp',[AuthController::class, "resendOTP"]); 
    Route::post('resend/email/otp',[AuthController::class, "ResendEmailOTP"]);
    Route::post('client/view/profile',[ClientController::class, "ClientViewProfile"]);
    Route::post('client/edit/profile',[ClientController::class, "UpdateClientProfile"]);
    Route::post('change/password',[AuthController::class, "changePassword"]);
    Route::post('view/store',[VendorController::class, "ViewStore"]);
    Route::post('add/bank',[VendorController::class, "AddBank"]);
    Route::post('set/payment',[VendorController::class, "SetPrimaryPayment"]);
    Route::post('create/address',[ClientController::class, "Address"]);  
    Route::post('edit/address',[ClientController::class, "EditAddress"]);
    Route::post('view/addresses',[ClientController::class, "ViewAddress"]);
    Route::post('contact',[ClientController::class,'Contact']);
    
    Route::post('rating',[ClientController::class, "Rating"]);
    Route::post('favourite',[ClientController::class,"Favourite"]);
    Route::get('favourite/list',[ClientController::class,"FavouriteList"]);
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
    Route::post('view/discount',[VendorController::class, "ViewDiscount"]);
    Route::post('add/card',[ClientController::class,"Card"]);
    Route::post('edit/card',[ClientController::class,"EditCard"]);
    Route::post('delete/card',[ClientController::class, "DeleteCard"]);
    Route::post('view/card',[ClientController::class, "ViewCard"]);
    Route::post('proceed',[VendorController::class, "Proceed"]);
    Route::post('vendor/view/profile',[VendorController::class, "ViewProfile"]);
    Route::post('subscription/plan',[VendorController::class, "SubscriptionsPlan"]);
    Route::post('subscription/by/id',[VendorController::class, "SubscriptionPlanById"]);
    Route::post('personal',[ClientController::class, "Personal"]);
    Route::post('edit/personal',[ClientController::class, "EditPersonal"]);
    
    Route::post('change/profile/picture',[AuthController::class, "ChangeProfilePicture"]);
    
    Route::post('open/cart',[ClientController::class, "OpenCart"]);
    Route::post('add/to/cart',[ClientController::class, "AddToCart"]);
    Route::post('cart/count',[ClientController::class, "TotalCartItems"]);
    Route::post('add/quantity',[ClientController::class, "AddQuantity"]);
    Route::post('delete/cart/item', [ClientController::class, "DeleteCartItems"]);
    Route::post('checkout',[ClientController::class, "Checkout"]);
    Route::post('order',[ClientController::class, "Order"]);
    Route::post('vendor/product/filter',[VendorController::class, "VendorProductFilter"]);
    Route::post('view/bank/details',[VendorController::class, "ViewBankDetails"]);
    Route::post('get/bank/details/by/id', [VendorController::class, "getBankDetailsById"]); 
    Route::post('delete/bank/details', [VendorController::class, "deleteBankDetails"]); 
    Route::post('edit/bank/details', [VendorController::class, "editBankDetails"]);
    Route::post('edit/paypal/id',[VendorController::class, "EditPaypalId"]);
    Route::post('delete/discount',[VendorController::class, "DeleteDiscount"]);
    Route::post('view/orders', [ClientController::class, "ViewOrder"]);
    Route::post('view/vendor/orders', [ClientController::class, "ViewVendorOrder"]);
    Route::post('set/default/address',[ClientController::class, "SetDefaultAddress"]);
    Route::post('view/order/by/id', [ClientController::class,"ViewOrderById"]);
    Route::post('vendor/order/list/by/id',[VendorController::class,"ViewOrderByVendor"]); 
    Route::post('add/variant',[VendorController::class, "AddVariant"]); 
    Route::post('delete/variants',[VendorController::class, "DeleteAttributes"]);
    Route::post('view/product/variants',[VendorController::class, "ViewProductvariants"]); 
    Route::post('view/staff/by/id',[VendorController::class, "ViewStaffById"]);
    Route::post('view/store/by/id',[VendorController::class, "StoreById"]);
    Route::post('search/variant',[ClientController::class, "SearchVariants"]);
    Route::post('buy/subscription',[VendorController::class, "VendorBuySubscription"]);
    Route::post('change/subscription/plan',[VendorController::class, "ChangeSubscriptionPlan"]);
    Route::post('create/offer',[ClientController::class, "CreateOffer"]);  
    Route::post('offer/by/id',[ClientController::class, "getOfferDetailBy"]);
    Route::post('user/chat',[ClientController::class, "UserChat"]);
    Route::post('chat/image/url',[AuthController::class, "ChatImageUrl"]);
    Route::post('offer/status/by/id',[VendorController::class, "OfferStatusById"]);
    Route::post('cancel/order',[ClientController::class, "CancelOrder"]);
    Route::post('notification',[AuthController::class,'Notification']);
    Route::post('view/discount/by/id',[VendorController::class, "ViewDiscountById"]);
    Route::post('change/staff/status',[VendorController::class, "ChangeStaffStatus"]);
    Route::post('read/notification',[AuthController::class, "ReadNotification"]);
    Route::post('switch/user',[AuthController::class, "SwitchUser"]);
    Route::post('delete/address',[ClientController::class, "DeleteAddress"]);
    Route::post('view/subcategories',[AuthController::class, "ViewSubCategories"]);
    Route::post('edit/store/manager/details', [VendorController::class,"EditStoreManagerDetails"]);
    Route::post('filter/product/by/store',[VendorController::class, "FilterProductByStore"]);
    Route::post('change/profile/picture',[VendorController::class, "ChangeProfilePicture"]);
    Route::post('view/staff/detail/by/id',[VendorController::class,"ViewStaffDetailsById"]);
    Route::post('delete/store',[VendorController::class,"DeleteStore"]);
    Route::post('change/store/status',[VendorController::class, "ChangeStoreStatus"]);
    Route::post('update/product',[VendorController::class, "UpdateProduct"])->middleware('UpdateProduct');
    Route::post('dashboard',[VendorController::class, "Dashboard"]);
    Route::post('view/transactions',[VendorController::class,"ViewTransactions"]);
    Route::post('return',[VendorController::class, "Return"]);
    Route::post('refund/request/list',[VendorController::class, "RefundRequests"]);
    Route::post('withdraw/request',[VendorController::class,"Withdraw"]);
    Route::post('create/promocode',[VendorController::class, "CreatePromoCode"]);
    Route::post('update/promocode',[VendorController::class, "UpdatePromoCode"]);
    Route::post('view/promocode', [VendorController::class, "ViewPromocode"]);
    Route::post('view/transaction/by/id',[VendorController::class, "TransactionById"]);
    Route::post('filter/transactions',[VendorController::class, "FilterTransaction"]);
    Route::post('delete/promocode',[VendorController::class, "DeletePromocode"]);
    Route::post('initiate/refund',[VendorController::class, "Refund"]);
    Route::post('delete/product/image',[VendorController::class, "DeleteProductImage"]);
    Route::post('revenue',[VendorController::class, "Revenue"]);
    Route::post('courier/return',[ClientController::class,"ReturnLabel"]);
    Route::post('schedule/pickup',[VendorController::class, "SchedulePickup"]);
    Route::post('store/rating',[ClientController::class,"StoreRating"]);
    Route::post('product/csv',[VendorController::class,"productCSV"]);
    Route::post('refund/request',[ClientController::class, "ReturnRequest"]);
    Route::post('create/shipping/label', [VendorController::class, "eVS"]);
    Route::post('barcode/lookup', [VendorController::class, "BarcodeLookup"]);
    
});


