<?php

use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Staff\StaffManagementController;
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


 
// Route::get('dashboard', function(){
//     dd('out-side');
// })->name('dashboard')->middleware('staff');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
       // Route::get('/post', [AdminController::class, "index"]); 
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            Route::get('/order-management',[AdminController::class, "orderManagement"]);
            Route::get('shipping-order-details/{id}',[AdminController::class, "ShippingOrderDetails"]);
            Route::get('/vendor-management',[VendorController::class,"index"])->name('vendor-management');
            Route::get('subscription-plan',[VendorController::class,"SubscriptionPlan"])->name('subscription-plan');
            Route::get('vendor-products',[VendorController::class, "VendorProducts"])->name('vendor.product.list');
            Route::get('product/detail/vendor/{id}',[VendorController::class,"ViewProductDetailsById"]);
            Route::get('report-management',[VendorController::class, "ViewReports"]);
            Route::get('running-orders',[VendorController::class, "RunningOrders"]);
            Route::get('running-order-details/{id}',[VendorController::class,"RunningOrderDetails"]);
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
            Route::get('edit/product/{id}', [VendorController::class, "editProduct"]);
            Route::post('update/product/{id}', [VendorController::class, "updateProduct"]);
            Route::post("store/product",[VendorController::class, "StoreProduct"]);
            Route::post('view/store/by/id',[VendorController::class, "ViewStoreById"]);
            Route::post('view/subcategories/by/id',[VendorController::class,"ViewSubCategory"]);
            Route::get('view/transactions', [VendorController::class, "ViewTransaction"])->name('transactions');
            Route::get('category-management',[VendorController::class,"CategoryManagement"])->name('category-management');
            Route::get('add-category',[VendorController::class, "AddCategory"]);
            Route::post('create-category', [VendorController::class, "CreateCategory"]);
            Route::get('delete/category/{id}',[VendorController::class, "DeleteCategory"]);
            Route::get('add-subcategory/{id}',[VendorController::class, "AddSubCategory"]);
            Route::post('create-subcategory', [VendorController::class, "CreateSubCategory"]);
            Route::get('subcategory/list',[VendorController::class,"SubCategoryManagement"])->name('subcategory-management');
            Route::get('delete/subcategory/{id}',[VendorController::class, "DeleteSubCategory"]); 
            Route::get('edit-category/{id}',[VendorController::class,"EditCategory"]);
            Route::post('update-category',[VendorController::class,"UpdateCategory"]);
            Route::get('edit-subcategory/{id}',[VendorController::class,"EditSubCategory"]);
            Route::post('update-subcategory',[VendorController::class,"UpdateSubCategory"]);
            Route::get('transaction-detail/{id}',[VendorController::class,"ViewTransactionDetailsById"]);
            Route::get('transaction-invoice/{id}',[VendorController::class,"ViewTransactionInvoice"]);
            Route::post('withdraw-accept', [VendorController::class, "withdrawAccept"]);
            Route::post('withdraw-reject', [VendorController::class, "withdrawReject"]);
            Route::post('create-vendor', [VendorController::class, "CreateVendor"]);
            Route::get('add-vendor', [VendorController::class, "AddVendor"]);
            Route::get('edit-vendor-details/{id}',[VendorController::class, "EditVendorDetails"]);
            Route::post('edit-vendor-details/{id}',[VendorController::class, "UpdateVendorDetails"])->name('update-details');
            Route::get('add-store/{id}', [VendorController::class, "AddStore"])->name('add-store');
            Route::post('create-store', [VendorController::class, "CreateStore"]);
            Route::get('add-manager/{id}', [VendorController::class, "AddManager"])->name('add-manager');
            Route::post('create-manager', [VendorController::class, "CreateManager"]);
            Route::get('invoice-pdf/{id}', [VendorController::class, 'generateInvoicePDF']);
            Route::get('invoice-email/{id}', [VendorController::class, 'emailInvoice']);
            Route::get('report-detail/{id}',[VendorController::class, "ViewReportsDetail"]);
            Route::get('add-plans',[VendorController::class, "AddPlans"]);
            Route::post('create-plans', [VendorController::class, "CreatePlans"]);
            Route::get('delete/plans/{id}',[VendorController::class, "DeletePlans"]);
            Route::get('edit-plans/{id}',[VendorController::class,"EditPlans"]);
            Route::post('update-plans',[VendorController::class,"UpdatePlans"]);
            Route::get('view/banner', [VendorController::class, "bannerList"])->name('banner-list');
            Route::get('create/banner',[VendorController::class, "createBanner"]);
            Route::post('store/banner',[VendorController::class, "storeBanner"]);
            Route::get('update/banner/{id}',[VendorController::class, "updateBanner"]);
            Route::post('edit/banner/{id}',[VendorController::class, "editBanner"]);
            Route::get('/delete/banner/{id}', [VendorController::class, "deleteBanner"]);
            Route::get('return',[VendorController::class,"ReturnRefund"]);
            Route::post('vendor/vendor-account', [VendorController::class, "AcceptVendorStatus"]);
            Route::post('product/status', [VendorController::class, "ProductStatus"]);
            
 });




// staff middlewares

 Route::group(['namespace' => 'Staff', 'prefix' =>'staff', 'middleware' => 'staff'], function(){

    Route::get('dashboard', [StaffManagementController::class, "Dashboard"])->name('dashboard');
});
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 