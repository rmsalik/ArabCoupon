<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    LoginController,
    UsersController,
    CategoryController,
    ItemController,
    DestinationController,
    BrandController,
    BookingController,
    PDFController,
    AirportController,
    OfficeController,
    CouponController,
    TopCouponController,
    NotificationController,
    BlogController
};
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('home');
// });

/***
 * ADMIN
 */
Route::post('/reset-password', [App\Http\Controllers\UserController::class, 'resetPassword'])->name('reset-password');
Route::prefix('admin')->group(function () {
    Route::middleware([\App\Http\Middleware\AdminSessionExists::class])->group(function () {
        Route::match(['get', 'post'], 'login', [LoginController::class, 'index']);
    });
    Route::match(['get'], 'logout', [LoginController::class,'logout']);
    Route::middleware([\App\Http\Middleware\AdminLoginVerification::class])->group(function () {
        
        Route::resource('users-crud', UsersController::class);
        Route::match(['get', 'post'], 'users-action/{action}/{id}', [UsersController::class, 'actions'])->name('users-action');
        
        Route::match(['get', 'post'], 'change-password', [LoginController::class, 'password']);
        
        Route::resource('category-crud', CategoryController::class);
        Route::match(['get', 'post'], 'category-action/{id}', [CategoryController::class, 'actions'])->name('category-action');
        
        Route::resource('notification-crud', NotificationController::class);
        Route::match(['get', 'post'], 'notification-action/{id}', [NotificationController::class, 'actions'])->name('notification-action');
        
        Route::resource('brand-crud', BrandController::class);
        Route::match(['get', 'post'], 'brand-action/{id}', [BrandController::class, 'actions'])->name('brand-action');
        
        Route::resource('blog-crud', BlogController::class);
        Route::match(['get', 'post'], 'blog-action/{id}', [BlogController::class, 'actions'])->name('blog-action');
        
        Route::resource('coupon-crud', CouponController::class);
        
        Route::get('coupon-crud/{id}/copy', [CouponController::class, 'copyCoupon'])->name('coupon-crud.copy');
        
        Route::get('coupons-crud/coupon/api', [CouponController::class, 'indexApi'])->name('coupon-crud.api');
        
        Route::post('coupon-crud/delete-copy', [CouponController::class, 'copyDeleteCoupon'])->name('coupon-crud.deleteCopy');
        
        
        Route::match(['get', 'post'], 'coupon-action/{id}', [CouponController::class, 'actions'])->name('coupon-action');
        
        Route::resource('top-coupon-crud', TopCouponController::class);
        Route::match(['get', 'post'], 'top-coupon-action/{id}', [TopCouponController::class, 'actions'])->name('top-coupon-action');
        
        
        Route::resource('destination-crud', DestinationController::class);
        Route::match(['get', 'post'], 'destination-action/{id}', [DestinationController::class, 'actions'])->name('destination-action');
        
        Route::resource('item-crud', ItemController::class);
        Route::match(['get', 'post'], 'item-action/{id}', [ItemController::class, 'actions'])->name('item-action');

        Route::resource('booking-crud', BookingController::class);
        Route::match(['get', 'post'], 'booking-action/{id}', [BookingController::class, 'actions'])->name('booking-action');
        
        Route::resource('office-crud', OfficeController::class);
        Route::match(['get', 'post'], 'office-action/{id}', [OfficeController::class, 'actions'])->name('office-action');
        Route::resource('airport-crud', AirportController::class);
        Route::match(['get', 'post'], 'airport-action/{id}', [AirportController::class, 'actions'])->name('airport-action');
        
        
        Route::get('about-us', [UsersController::class, 'aboutUsDescription'])->name('about-us');
        Route::get('about-us/edit', [UsersController::class, 'aboutUsEdit'])->name('about-us-edit');
        Route::post('about-us/update', [UsersController::class, 'aboutUsUpdate'])->name('about-us-update');
        
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/generate-pdf/{id}', [PDFController::class, 'generatePDF']);

Route::get('/', [App\Http\Controllers\MainPageController::class, 'index']);
Route::get('/getBrandsByCountry', [App\Http\Controllers\MainPageController::class, 'getBrandsByCountry']);
Route::get('/offers/{id}/{country_id}', [App\Http\Controllers\MainPageController::class, 'brand_offers'])->name('brand.offers');
Route::get('getBrandsBySearch', [App\Http\Controllers\MainPageController::class, 'search'])->name('brand.search');
Route::get('top-brand-stores', [App\Http\Controllers\MainPageController::class, 'top_brands_stores']);
// all brands 
Route::get('allcoupons', [App\Http\Controllers\MainPageController::class, 'getAllCoupons']);
//terms and conditions
Route::get('terms-condition',[App\Http\Controllers\MainPageController::class, 'terms_condition']);
//frquently asked
Route::get('faq',[App\Http\Controllers\MainPageController::class, 'faq']);
//privacy policy
Route::get('privacy-policy',[App\Http\Controllers\MainPageController::class, 'privacy_policy']);
Route::get('brands/{category_id}/{country_id}',[App\Http\Controllers\MainPageController::class, 'getBrandsByCategoryID']);
Route::get('coupon_like_dislike',[App\Http\Controllers\MainPageController::class, 'coupon_like_dislike']);

//submit coupon
Route::post('add-coupon',[App\Http\Controllers\MainPageController::class, 'add_coupon'])->name('add-coupon');
Route::get('/get-brands', [App\Http\Controllers\MainPageController::class, 'get_brands_byCountry']);