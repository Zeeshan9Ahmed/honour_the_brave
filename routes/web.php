<?php

use App\Http\Controllers\Api\User\Profile\ProfileController;
use App\Http\Controllers\Business\ChatController;
use App\Http\Controllers\Business\DashboardController;
use App\Http\Controllers\Business\ProductController;
use App\Http\Controllers\Business\ReviewController;
use App\Http\Controllers\Business\SubscriptionController;
use App\Http\Controllers\Web\SignUpController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'business'], function () {

    Route::group(['middleware' => ['is_business_admin', 'prevent-back-history']], function () {
        Route::get('logout', [SignUpController::class, 'logout']);

        Route::get('/complete-profile', function () {
            $categories = Category::where('category_type', 'business')->get();

            return view('web.business.register.complete-profile', compact('categories'));
        })->name('business-profile-setup');

        Route::post('/update-profile', [SignUpController::class, 'completeProfile']);

        Route::group(['middleware' => ['is_business_profile_completed']], function () {
            Route::get('/dashboard', [DashboardController::class,'dashboard']);
            Route::view('/profile', 'web.business.profile.index');

            Route::post('update-password', [ProfileController::class, 'changePassword']);

            Route::get('products', [ProductController::class, 'index']);
            Route::get('product', [ProductController::class, 'getProduct']);
            Route::get('delete-product-image', [ProductController::class, 'deleteProductImage']);
            Route::get('category-products', [ProductController::class, 'categoryProducts']);
            Route::get('add-product', [ProductController::class, 'addProduct']);
            Route::post('save-product', [ProductController::class, 'saveProduct']);
            Route::post('edit-product', [ProductController::class, 'editProduct']);
            Route::get('delete-product', [ProductController::class, 'deleteProduct']);
            
            Route::get('chat', [ChatController::class, 'chatList']);
            Route::get('subscription', [SubscriptionController::class, 'index']);
            Route::get('reviews', [ReviewController::class, 'index']);

         });
     });

     Route::post('login', [SignUpController::class, 'login']);

     Route::view('/login', 'web.business.register.login')->name('business_login');

     Route::view('/sign-up', 'web.business.register.signup');

     Route::view('/forgot-password', 'web.business.register.forgot-password');
    Route::post('forgot-password', [SignUpController::class, 'forgotPassword']);

     Route::view('/otp', 'web.business.register.otp');

    Route::post('/resend-otp', [SignUpController::class, 'resendSignUpOtp']);

     Route::view('/change-password', 'web.business.register.reset-password');
    Route::post('change-password', [SignUpController::class, 'resetForgotPassword']);

     Route::post('/sign-up', [SignUpController::class, 'signUp']);
     Route::post('otp-verify', [SignUpController::class, 'otpVerify']);

});
