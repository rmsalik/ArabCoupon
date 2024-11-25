<?php

use App\Http\Controllers\{UserController,CreditCardController, ChatController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Route};

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

// Non Autentic User Error
Route::get('/non-authentic', function(){
    return response()->json(['error' => true, 'message' => 'auth_token_not_correct'], 200);
})->name('nonAuthentic');
// Using auth route for forget password process
Auth::routes();

Route::post('signup', [UserController::class, 'signup']);
Route::post('log-in', [UserController::class, 'login']);
Route::post('social-login', [UserController::class, 'socialLogin']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('update-user', [UserController::class, 'updateProfile']);
    Route::post('delete-user', [UserController::class, 'deleteProfile']);
    Route::get('user', [UserController::class, 'getUser']);
    Route::post('reset-password', [UserController::class, 'resetPassword']);
    Route::post('log-out', [UserController::class, 'logout']);
    
    
    Route::get('categories', [UserController::class, 'getCategory']);
    
    Route::get('destinations', [UserController::class, 'getDestination']);
    
    
    
    
    Route::get('get-my-chats', [ChatController::class, 'getMyChats'])->name('get-my-chats');
    Route::get('get-chat-list', [ChatController::class, 'getListChats'])->name('get-chat-list');
    Route::post('chat', [ChatController::class, 'chat'])->name('chat');
    Route::post('initiate-chat', [ChatController::class, 'initiateChat'])->name('initiate-chat');
    Route::get('get-chat-detail', [ChatController::class, 'chatDetail'])->name('get-chat-detail');
    Route::get('get-invites-list', [ChatController::class, 'getInvitesList'])->name('get-invites-list');
    

    
    //------------Credit Card Routes------------//
    Route::get('credit-card', [CreditCardController::class, 'index']);
    Route::get('credit-card/{id}', [CreditCardController::class, 'show']);
    Route::post('credit-card', [CreditCardController::class, 'create']);
    Route::delete('credit-card/{id}', [CreditCardController::class, 'destroy']);
    Route::get('credit-card/{id}/set-default', [CreditCardController::class, 'setDefaultCard']);
    
    Route::post('create-star', [UserController::class, 'createStar']);
    
    Route::get('dashboard', [UserController::class, 'dashboard']);
});

Route::get('brands', [UserController::class, 'getBrand']);
Route::get('top-brand-stores', [UserController::class, 'getTopDashboard']);
Route::get('dashboard', [UserController::class, 'getDashboard']);
Route::get('dashboard-search', [UserController::class, 'getDashboardSearch']);
Route::get('coupon-search', [UserController::class, 'getCouponSearch']);
Route::get('categories', [UserController::class, 'getCategories']);
Route::get('coupons', [UserController::class, 'getCoupons']);
Route::get('brand', [UserController::class, 'getBrandByID']);
Route::get('brand-by-category', [UserController::class, 'getBrandByCategoryID']);
Route::get('brand-by-category-detail', [UserController::class, 'getBrandByCategoryIDDetail']);
Route::get('category', [UserController::class, 'getCategoriesByID']);
Route::get('coupon', [UserController::class, 'getCouponsByID']);
Route::get('related-coupon', [UserController::class, 'getRelatedCouponsByID']);
Route::get('country-coupon', [UserController::class, 'getCouponsByCountry']);
Route::get('category-coupon', [UserController::class, 'getCouponsByCategory']);
Route::get('brand-coupon', [UserController::class, 'getCouponsByBrand']);

Route::get('countries', [UserController::class, 'getCountries']);


Route::post('add-coupon', [UserController::class, 'addCoupon']);
Route::post('coupon-work', [UserController::class, 'workCoupon']);
Route::post('coupon-not-work', [UserController::class, 'notworkCoupon']);

Route::post('sendNotification', [UserController::class, 'sendNotification'])->name('sendNotification');
Route::post('guest-user-login', [UserController::class, 'guestLogin'])->name('guest-login');
Route::post('test-user-login', [UserController::class, 'testLogin'])->name('test-login');



