<?php

use App\Http\Controllers\Api\HomeController;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Faker\Generator as Faker;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// home api start here//
Route::prefix('/home')->group(function(){
    Route::get('/', [\App\Http\Controllers\Api\HomeController::class, 'index']);
    Route::get('/search', [\App\Http\Controllers\Api\HomeController::class, 'search']);
    Route::get('/detail', [\App\Http\Controllers\Api\HomeController::class, 'detail']);
});

// Home api ends here..
Route::prefix('/cart')->group(function(){
    Route::get('/', [\App\Http\Controllers\Api\HomeController::class, 'cart_index']);
    Route::post('/add-items-to-cart',[\App\Http\Controllers\Api\HomeController::class,'add_to_cart']);
});

// User Api start..
Route::prefix('/user')->group(function(){
    Route::post('/signup', [\App\Http\Controllers\Api\UserController::class, 'userSignUp']);
    Route::post('/sigin', [\App\Http\Controllers\Api\UserController::class, 'userSignIn']);
    Route::post('/check-user-email-username', [\App\Http\Controllers\Api\UserController::class, 'check_user_email_username']);
    Route::post('/forgot-password-sendmail', [\App\Http\Controllers\Api\UserController::class, 'forgot_password_sendmail']);
    Route::post('/forgot-password-verify-otp', [\App\Http\Controllers\Api\UserController::class, 'forgot_password_verify_otp']);
    Route::post('/forgot-password-reset', [\App\Http\Controllers\Api\UserController::class, 'forgot_password_reset']);
    Route::post('/update-profile', [\App\Http\Controllers\Api\UserController::class, 'update_profile']);
});
// User Api end..


// Checkout api start here..

Route::prefix('/checkout')->group(function(){
    Route::post('/promo', [\App\Http\Controllers\Api\CheckoutController::class, 'promo_code']);
    Route::post('/place-order', [\App\Http\Controllers\Api\CheckoutController::class, 'place_order']);
    Route::get('/payment-methods-shippings', [\App\Http\Controllers\Api\CheckoutController::class, 'payment_methods_shippings']);
});

//checkout api end here..

// Order api start here..
Route::prefix('/my-orders')->group(function(){
    Route::get('/', [\App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::get('/detail', [\App\Http\Controllers\Api\OrderController::class, 'details']);
    Route::get('/cancel', [\App\Http\Controllers\Api\OrderController::class, 'cancel']);
    Route::post('/return-order', [\App\Http\Controllers\Api\OrderController::class, 'return_order']);
    Route::get('/my-return-orders', [\App\Http\Controllers\Api\OrderController::class, 'my_return_orders']);
});
// order api end here..


//wishlist api start here..
Route::prefix('/wishlist')->group(function(){
    Route::get('/', [\App\Http\Controllers\Api\HomeController::class, 'wishlist']);
    Route::post('/add-to-wishlist', [\App\Http\Controllers\Api\HomeController::class, 'add_to_wishlist']);
    Route::post('/update-wishlist', [\App\Http\Controllers\Api\HomeController::class, 'update_wishlist']);

});
//wishlist api end here..

//pages api start here..
Route::prefix('/pages')->group(function(){
    Route::get('/about-us',function(Faker $faker){
        return $faker->realText($maxNbChars = 1200, $indexSize = 5);
    });

    Route::get('/privacy-policy',function(Faker $faker){
        return $faker->realText($maxNbChars = 1200, $indexSize = 5);
    });

    Route::get('/faq',function(Faker $faker){
        return $faker->realText($maxNbChars = 1200, $indexSize = 5);
    });

});
//pages api end here..

//Notification api start here..
Route::prefix('/notification')->group(function(){
    Route::get('/', [\App\Http\Controllers\Api\NotificationController::class, 'index']);
    Route::post('/save-user-token', [\App\Http\Controllers\Api\NotificationController::class, 'save_user_token']);
    Route::post('/delete-token', [\App\Http\Controllers\Api\NotificationController::class, 'delete_token']);
});
//Notification api end here..