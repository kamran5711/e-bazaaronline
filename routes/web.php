<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ShopSaleController;
use App\Http\Controllers\SocialLinksController;
use App\Http\Controllers\Auth\SuperAdminLoginRegister;
use App\Http\Controllers\SuperAdmin\InvoiceController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
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
// main Admin route start

// Pages settings

Route::get('/get-states-by-country-id/{id}', [SuperAdminLoginRegister::class, 'get_states_by_country_id']);
Route::get('/get-cities-by-state-id/{id}', [SuperAdminLoginRegister::class, 'get_cities_by_state_id']);

Route::get('/about-us',[\App\Http\Controllers\PagesSettingsController::class,'about_us'])->name('admin.about_us');
Route::post('/about-us',[\App\Http\Controllers\PagesSettingsController::class,'save_about_us'])->name('admin.about_us');

Route::get('/terms',[\App\Http\Controllers\PagesSettingsController::class,'terms'])->name('admin.terms');
Route::post('/terms',[\App\Http\Controllers\PagesSettingsController::class,'save_terms'])->name('admin.terms');

Route::get('/privacy',[\App\Http\Controllers\PagesSettingsController::class,'privacy_policy'])->name('admin.privacy_policy');
Route::post('/privacy',[\App\Http\Controllers\PagesSettingsController::class,'save_privacy_policy'])->name('admin.save_privacy_policy');

Route::get('/track-orders','FrontendController@orderTrack');
Route::post('/track-orders-list','FrontendController@track_order_process');
Route::get('/order-details/{id}','FrontendController@order_details');


Route::get('/',[SuperAdminController::class,'index']);
Route::post('{slug}/product-searched/', [SuperAdminController::class, 'product_searched'])->name('product_searched');
Route::get('/superadmin',[SuperAdminController::class,'superadmin_dashboard'])->name('superadmin.dashboard');

Route::group(['prefix' => 'superadmin', 'middleware' =>['auth']], function(){
    // Color
    Route::resource('color', 'ColorController');

    Route::get('store-registration-email', [SuperAdminController::class, 'store_registration_email'])->name('store-registration-email');
    Route::get('store-varification-email', [SuperAdminController::class, 'store_varification_email'])->name('store-varification-email');
    Route::get('order-placement-email', [SuperAdminController::class, 'order_placement_email'])->name('order-placement-email');
    Route::get('order-status-change-email', [SuperAdminController::class, 'order_status_change_email'])->name('order-status-change-email');    
    Route::post('update-email-template', [SuperAdminController::class, 'update_email_template'])->name('update-email-template');   

    Route::get('pending-for-approval', [SuperAdminController::class, 'newBusiness'])->name('pending_for_approval');
    Route::get('users/{id}', [SuperAdminController::class, 'show_user'])->name('user.show');
    Route::get('/get-store-list',[SuperAdminController::class,'stores'])->name('get_store_list');
    Route::get('store/payments/{id}', [InvoiceController::class,'store_invoices'])->name('store-payments');
    Route::post('store/extend-membership',[InvoiceController::class,'store_extend_membership'])->name('store_extend_membership');
    // memberships 

    Route::get('memberships/expired/', [InvoiceController::class,'expired_memberships'])->name('expired-memberships');
    Route::get('memberships/list/', [InvoiceController::class,'membership_listing'])->name('all-memberships');
    Route::get('membership-edit/{id}', [InvoiceController::class, 'membership_edit'])->name('membership-edit');
    Route::patch('membership-update/{id}', [InvoiceController::class, 'membership_update'])->name('membership-update');

    Route::post('invoices/create',[InvoiceController::class,'invoice_create'])->name('invoice-create');
    Route::get('invoices/pending/', [InvoiceController::class,'pending_invoices'])->name('pending-invoices');
    // Route::get('invoices/paid/', [InvoiceController::class,'paid_invoices'])->name('paid-invoices');
    Route::get('invoices/list/', [InvoiceController::class,'invoicesList'])->name('all-invoices');
    Route::get('invoice-edit/{id}', [InvoiceController::class, 'edit'])->name('invoice-edit');
    Route::patch('invoice-update/{id}', [InvoiceController::class, 'update'])->name('invoice-update');
    Route::delete('invoice-destroy/{id}', [InvoiceController::class, 'destroy'])->name('invoice-destroy');

    Route::get('/enable-store/{id}', [SuperAdminController::class, 'enable_store'])->name('store-enable');
    Route::get('/disable-store/{id}', [SuperAdminController::class, 'disable_store'])->name('store-disable');
    Route::delete('delete-store/{id}', [SuperAdminController::class, 'delete_store'])->name('delete-store');
});

Route::get('/test',[SuperAdminLoginRegister::class,'test']);
Route::get('/register',[SuperAdminLoginRegister::class,'register_view'])->name('store.register');
Route::post('/store-register-proccess',[SuperAdminLoginRegister::class,'register'])->name('store.register_process');
Route::get('/register-success/{business}/{name}/{contact}',[SuperAdminLoginRegister::class,'register_success'])->name('register_success');
// Route::get('/superadmin-login',[SuperAdminLoginRegister::class,'login_view'])->name('superadmin.login');
Route::post('/superadmin-login',[SuperAdminLoginRegister::class,'login_process'])->name('superadmin.login');
Route::post('superadmin/edit/{id}', [SuperAdminController::class,'updateAdminUser'])->name('admin.edit'); 
Route::post('/superadmin/enable/{id}', [SuperAdminController::class,'enableUser'])->name('user.enable');
Route::get('/superadmin/disable/{id}', [SuperAdminController::class,'disableUser'])->name('user.disable');
Route::get('/superadmin/profile', [SuperAdminController::class,'profileAdmin']);
Route::post('/superadmin/profile', [SuperAdminController::class,'updateAdminProfile'])->name('admin.update');
Auth::routes(['register'=>false]);
Route::get('user/login','FrontendController@login')->name('login.form');
Route::get('{slug}/user/logincheckout','FrontendController@loginCheckout')->name('loginCheckout');
Route::post('user/login','FrontendController@loginSubmit')->name('login.submit');
Route::get('logout','FrontendController@logout')->name('logout');
Route::get('{slug}/user/register','FrontendController@register')->name('register.form');
Route::post('user/register','FrontendController@registerSubmit')->name('register.submit');
Route::get('user/registerCheckout','FrontendController@registerCheckout')->name('registerCheckout');
Route::post('user/registerCheckoutSubmit','FrontendController@registerCheckoutSubmit')->name('registerCheckout.submit');

Route::get('/sitemap', 'SiteMapController@index');

//***************** Reset password  *********************************************//
Route::get('password-reset', 'FrontendController@showResetForm')->name('password.reset');
// Socialite
Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');
Route::get('/store/{slug?}','FrontendController@home')->name('home');

//*********************** Frontend Routes  *****************************************//

Route::get('/{slug?}/faqs',[FrontendController::class,'faqs'])->name('faqs');
Route::get('/home', 'FrontendController@index');
Route::get('/{slug?}/about-us','FrontendController@aboutUs')->name('about-us');
Route::get('/{slug?}/terms-and-conditions','FrontendController@terms')->name('terms-and-conditions');
Route::get('/{slug?}/privacy-policy','FrontendController@privacy_policy')->name('privacy-policy');

Route::get('/{slug?}/payment-methods',[FrontendController::class,'payment_methods'])->name('payment_methods');
Route::get('/{slug?}/money-back','FrontendController@money_back')->name('money_back');
Route::get('/{slug?}/returns','FrontendController@returns')->name('returns');
Route::get('/{slug?}/shippings','FrontendController@shipping')->name('shipping');


Route::get('/faqs',[FrontendController::class,'faqs']);
Route::get('/home', 'FrontendController@index');
Route::get('/about-us','FrontendController@aboutUs');
Route::get('/terms-and-conditions','FrontendController@terms');
Route::get('/privacy-policy','FrontendController@privacy_policy');

Route::get('/{slug?}/contact-us','FrontendController@contact')->name('contact');
Route::post('/contact/message','MessageController@store')->name('contact.store');
Route::get('{slug}/product-detail/{sub_slug}','FrontendController@productDetail')->name('product-detail');
Route::post('{slug?}/search-products','FrontendController@search_products')->name('search.product');
Route::get('/product/search','FrontendController@productSearch')->name('product.search');
//Route::post('/product/search','FrontendController@productSearch')->name('product.search');
Route::get('{slug}/product-category/{id}','FrontendController@product_category')->name('product-cat');
Route::get('{slug}/product-sub-category/{id}','FrontendController@product_sub_category')->name('product-sub-category');
Route::get('{slug}/product-brand/{id}','FrontendController@product_brand')->name('product-brand');

//*************************** Cart section *************************************//
Route::post('/add-to-cart/{slug}','CartController@addToCart')->name('add-to-cart');
Route::post('/add-to-cart','CartController@singleAddToCart')->name('single-add-to-cart');
Route::get('{slug}/cart-delete/{id}','CartController@cartDelete')->name('cart-delete');
Route::post('cart-update','CartController@cartUpdate')->name('cart.update');

Route::post('/add-to-cart-ajax','CartController@add_to_cart_ajax')->name('add-to-cart-ajax');
Route::get('/load-cart-info-view','CartController@load_cart_info_view')->name('load-cart-info-view');
Route::get('/cart-delete-ajax/{id}','CartController@cart_delete_ajax')->name('cart-delete-ajax');


Route::get('/{slug}/cart', function(){
    // dd(session()->all());
    return view('frontend.pages.cart');
})->name('cart');
Route::get('{slug}/checkout','CartController@checkout')->name('checkout')->middleware('user');
Route::post('{slug}/get-delivery-charges','CartController@get_delivery_charges')->name('get_delivery_charges');

//************************* Wishlist  **************************//
Route::get('/wishlist',function(){
    return view('frontend.pages.wishlist');
})->name('wishlist');
Route::get('/wishlist/{slug}','WishlistController@wishlist')->name('add-to-wishlist');
Route::get('wishlist-delete/{id}','WishlistController@wishlistDelete')->name('wishlist-delete');
Route::post('cart/order','OrderController@store')->name('cart.order');
Route::get('order/pdf/{id}','OrderController@pdf')->name('order.pdf');
Route::get('/income','OrderController@incomeChart')->name('product.order.income');
// Route::get('/user/chart','AdminController@userPieChart')->name('user.piechart');
Route::get('/{slug}/product-grids','FrontendController@productGrids')->name('product-grids');
Route::get('/product-lists','FrontendController@productLists')->name('product-lists');
Route::match(['get','post'],'/filter','FrontendController@productFilter')->name('shop.filter');

//*******************************   Order Track  ***********************************//
Route::get('{slug}/track-orders','OrderController@orderTrack')->name('order.track');
Route::post('{slug}/track-orders-list','OrderController@track_order_process')->name('track.order.process');
Route::get('{slug}/order-details/{id}','OrderController@order_details')->name('order.details');

//*****************************   Blog  ****************************************//
Route::get('{slug}/blog','FrontendController@blog')->name('blog');
Route::get('{slug}/blog-detail/{post_slug?}','FrontendController@blogDetail')->name('blog.detail');
Route::post('{slug}/post-search','FrontendController@blog_search')->name('blog.search');
Route::get('{slug}/post-categorys/{category_slug}','FrontendController@blog_category')->name('blog.category');
Route::get('{slug}/post-tags/{tag_slug}','FrontendController@blog_tag')->name('blog.tag');

//****************************  NewsLetter  ***************************************//
Route::post('/subscribe','FrontendController@subscribe')->name('subscribe');

//************************  Product Review  ******************************************//
Route::resource('/review','ProductReviewController');
Route::post('product/{slug}/review','ProductReviewController@store')->name('review.store');

//***************************   Post Comment  ***************************************//
Route::post('post/{slug}/comment','PostCommentController@store')->name('post-comment.store');
Route::resource('/comment','PostCommentController');

// *******************  Coupon  *******************************************************//
Route::post('/coupon-store','CouponController@couponStore')->name('coupon-store');
// Payment
Route::get('payment', 'PayPalController@payment')->name('payment');
Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
Route::get('payment/success', 'PayPalController@success')->name('payment.success');



  //**************************** Admin Start  ****************************//

Route::group(['prefix'=>'/admin', 'middleware' =>['auth','admin']],function(){
    Route::get('/','AdminController@index')->name('admin');
    Route::get('/file-manager',function(){
        return view('backend.layouts.file-manager');
    })->name('file-manager');

    //***** Payment Method **********//
    Route::resource('payments','PaymentController');
    Route::delete('/payment/destroy/{id}','PaymentController@destroy')->name('payment.destroy');
    
    Route::get('pending-invoices/', [InvoiceController::class,'store_pending_invoices'])->name('store-pending-invoices');
    // Size
    Route::resource('size', 'SizeController');
    // user route
    Route::resource('users', 'UsersController');
    // Banner
    Route::resource('banner', 'BannerController');
    // Brand
    Route::resource('brand', 'BrandController');
    // Add Products Tax
    Route::resource('/taxs','TaxController');
    Route::delete('/tax/destroy/{id}','TaxController@destroy')->name('tax.destroy');
     // Add Products Discounts
     Route::resource('discounts','DiscountController');
     Route::delete('/discount/destroy/{id}','DiscountController@destroy')->name('discount.destroy');
     
    // Profile
    Route::get('/profile','AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}','AdminController@profileUpdate')->name('profile-update');
    // Category
    Route::resource('/category','CategoryController');

    Route::get('/category/sub-categories/{id}', 'SubCategoryController@index')->name('category.sub');
    Route::get('/sub-category-create/{id}', 'SubCategoryController@create')->name('subcategory.create');
    Route::post('/category/sub-categories', 'SubCategoryController@store')->name('sub.category.store');
    Route::get('/sub-category-edit/{id}', 'SubCategoryController@edit')->name('sub.category.edit');
    Route::patch('/sub-category-update/{id}', 'SubCategoryController@update')->name('sub.category.update');
    Route::delete('/sub-category-delete/{id}','SubCategoryController@destroy')->name('sub.category.destroy');
    // Ajax for sub category
    Route::post('get-sub-categories-by-category-id/{id}','SubCategoryController@get_categories_by_category_id')->name('get.sub.categories.by.category.id');

    // Product
    Route::resource('/product','ProductController');
    Route::post('remove_product_image','ProductController@remove_product_image')->name('remove_product_image');
    Route::post('update_order_status','OrderController@update_order_status')->name('update_order_status');
    Route::post('proceed-order-status', 'OrderController@proceed_order_status')->name('proceed_order_status');
    Route::post('proceed-to-cancel', 'OrderController@proceed_to_cancel')->name('proceed_to_cancel');

    

    // Route::get('/product-size/enable/{id}', 'ProductController@enable')->name('product.size.enable');
    // Route::get('/product-size/disable/{id}', 'ProductController@disable')->name('product.size.disable');

    // POST category
    Route::resource('/post-category','PostCategoryController');
    // Post tag
    Route::resource('/post-tag','PostTagController');
    // Post
    Route::resource('/post','PostController');
    // Message
    Route::resource('/message','MessageController');
    Route::get('/message/five','MessageController@messageFive')->name('messages.five');
    // Order
    Route::resource('/order','OrderController');
    Route::get('/return-orders','OrderController@return_orders')->name('order.return');
    Route::delete('/return-order-delete/{id}','OrderController@return_order_delete')->name('order.return_order_delete');
    Route::post('/return-order-update','OrderController@return_order_update')->name('order.return_order_update');

    // Shipping
    Route::resource('/shipping','ShippingController');
    // Coupon
    Route::resource('/coupon','CouponController');
    // Settings
    // Settings
    Route::get('ShopSetting','AdminController@ShopSetting')->name('ShopSetting');
    Route::get('/settings','AdminController@settings')->name('settings');
    Route::get('/setting/edit/{id}','AdminController@editSetting')->name('setting.edit');
    
    Route::post('setting/Store','AdminController@settingsStore')->name('settings.store');
    Route::post('setting/update/{id}','AdminController@settingsUpdate')->name('settings.update');
    Route::delete('setting/destory/{id}','AdminController@settingDelete')->name('setting.destroy');
    
    // Notification
    Route::get('/notification/{id}','NotificationController@show')->name('admin.notification');
    Route::get('/notifications','NotificationController@index')->name('all.notification');
    Route::delete('/notification/{id}','NotificationController@delete')->name('notification.delete');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
    // For sale
    Route::get('/shop/sales','OrderController@shopSale')->name('shop.sale');
    Route::get('/web/sales','OrderController@webSale')->name('web.sale');
    Route::get('/app/sales','OrderController@appSale')->name('app.sale');

     //************************** Shop Sale ***********************************//
    Route::get('/shop/sale',[ShopSaleController::class, 'sale'])->name('shopOrder');
    Route::post('/shop/search-product-ajax',[ShopSaleController::class, 'search_product_ajax'])->name('search_product_ajax');
    Route::post('/shop/add-to-cart-process',[ShopSaleController::class, 'add_to_cart_process'])->name('add_to_cart_process');
    Route::get('/shop/get-cart-items-view',[ShopSaleController::class, 'get_cart_items_view'])->name('get_cart_items_view');
    Route::post('remove-cart-item/', [ShopSaleController::class, 'remove_cart_item'])->name('remove_cart_item');
    Route::post('/update-items-in-cart', [ShopSaleController::class, 'update_items_in_cart'])->name('update.items.in.cart');
    Route::post('shop/place-order', [ShopSaleController::class, 'place_order_'])->name('shop.place.order');
    // Route::post('/shop/sale',[ShopSaleController::class, 'place_order'])->name('shopOrder');

    // Pages settings
    Route::get('/social-links',[\App\Http\Controllers\PagesSettingsController::class,'social_links'])->name('admin.social_links');
    Route::post('/social-links',[\App\Http\Controllers\PagesSettingsController::class,'save_social_links'])->name('admin.social_links');
    
    Route::get('/about_us',[\App\Http\Controllers\PagesSettingsController::class,'about_us'])->name('admin.about_us');
    Route::post('/about_us',[\App\Http\Controllers\PagesSettingsController::class,'save_about_us'])->name('admin.about_us');

    Route::get('/payment_methods',[\App\Http\Controllers\PagesSettingsController::class,'payment_methods'])->name('admin.payment_methods');
    Route::post('/payment_methods',[\App\Http\Controllers\PagesSettingsController::class,'save_payment_methods'])->name('admin.save_payment_methods');
    Route::get('/money_back',[\App\Http\Controllers\PagesSettingsController::class,'money_back'])->name('admin.money_back');
    Route::post('/money_back',[\App\Http\Controllers\PagesSettingsController::class,'save_money_back'])->name('admin.save_money_back');
    Route::get('/return',[\App\Http\Controllers\PagesSettingsController::class,'returns'])->name('admin.returns');
    Route::post('/return',[\App\Http\Controllers\PagesSettingsController::class,'save_returns'])->name('admin.save_returns');
    Route::get('/shipping-policy',[\App\Http\Controllers\PagesSettingsController::class,'shipping'])->name('admin.shipping');
    Route::post('/shipping-policy',[\App\Http\Controllers\PagesSettingsController::class,'save_shipping'])->name('admin.save_shipping');

    Route::get('/terms',[\App\Http\Controllers\PagesSettingsController::class,'terms'])->name('admin.terms');
    Route::post('/terms',[\App\Http\Controllers\PagesSettingsController::class,'save_terms'])->name('admin.terms');

    Route::get('/privacy_policy',[\App\Http\Controllers\PagesSettingsController::class,'privacy_policy'])->name('admin.privacy_policy');
    Route::post('/privacy_policy',[\App\Http\Controllers\PagesSettingsController::class,'save_privacy_policy'])->name('admin.save_privacy_policy');

    Route::get('/faq',[\App\Http\Controllers\PagesSettingsController::class,'faqs'])->name('faq.index');
    Route::get('/faq/create',[\App\Http\Controllers\PagesSettingsController::class,'faq_create'])->name('faq.create');
    Route::post('/faq',[\App\Http\Controllers\PagesSettingsController::class,'faq_store'])->name('faq.store');
    Route::get('/faq/edit/{id}',[\App\Http\Controllers\PagesSettingsController::class,'faq_edit'])->name('faq.edit');
    Route::patch('/faq/update/{id}',[\App\Http\Controllers\PagesSettingsController::class,'faq_update'])->name('faq.update');
    Route::delete('/faq/delete/{id}',[\App\Http\Controllers\PagesSettingsController::class,'faq_destroy'])->name('faq.destroy');



    Route::get('/product/delete-image/{id}',[\App\Http\Controllers\ProductController::class,'delete_image']);
    
});

//************************** Customer Section *********************************** */ 

Route::group(['prefix' => '/customer', 'middleware'=> ['auth']], function(){
    Route::get('/',[\App\Http\Controllers\CustomerController::class,'index'])->name('customer.index');

    Route::get('/profile',[\App\Http\Controllers\CustomerController::class,'profile'])->name('customer.profile');

    Route::get('/reviews',[\App\Http\Controllers\CustomerController::class,'reviews'])->name('customer.reviews');
    Route::get('/reviews/{id}',[\App\Http\Controllers\CustomerController::class,'review_edit'])->name('customer.review_edit');
    Route::post('/reviews/delete/{id}',[\App\Http\Controllers\CustomerController::class,'review_delete'])->name('customer.review_delete');
    Route::post('/reviews/update/{id}',[\App\Http\Controllers\CustomerController::class,'review_update'])->name('customer.review_update');

    Route::get('/comments',[\App\Http\Controllers\CustomerController::class,'comments'])->name('customer.comments');
    Route::get('/comments/{id}',[\App\Http\Controllers\CustomerController::class,'comments_edit'])->name('customer.comments.edit');
    Route::post('/comments/update/{id}',[\App\Http\Controllers\CustomerController::class,'comments_update'])->name('customer.comment.update');

    Route::get('/order-detail/{id}',[\App\Http\Controllers\CustomerController::class,'showOrder'])->name('customer.ordershow');
    Route::post('/return-order-update','CustomerController@return_order_update')->name('customer.return_order_update');
});

// *************************   User section start   ***************************************//
Route::group(['prefix'=>'/user','middleware'=>['user']],function(){
    Route::get('/','HomeController@index')->name('user');
     // Profile
     Route::get('/profile','HomeController@profile')->name('user-profile');
     Route::post('/profile/{id}','HomeController@profileUpdate')->name('user-profile-update');
    //  Order
    Route::get('/order',"HomeController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}',"HomeController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}','HomeController@userOrderDelete')->name('user.order.delete');
    // Product Review
    Route::get('/user-review','HomeController@productReviewIndex')->name('user.productreview.index');
    Route::delete('/user-review/delete/{id}','HomeController@productReviewDelete')->name('user.productreview.delete');
    Route::get('/user-review/edit/{id}','HomeController@productReviewEdit')->name('user.productreview.edit');
    Route::patch('/user-review/update/{id}','HomeController@productReviewUpdate')->name('user.productreview.update');
    // Post comment
    Route::get('user-post/comment','HomeController@userComment')->name('user.post-comment.index');
    Route::delete('user-post/comment/delete/{id}','HomeController@userCommentDelete')->name('user.post-comment.delete');
    Route::get('user-post/comment/edit/{id}','HomeController@userCommentEdit')->name('user.post-comment.edit');
    Route::patch('user-post/comment/udpate/{id}','HomeController@userCommentUpdate')->name('user.post-comment.update');
    // Password Change
    // Route::get('change-password', 'HomeController@changePassword')->name('user.change.password.form');
    // Route::post('change-password', 'HomeController@changPasswordStore')->name('change.password');
    // Route::POST('user_order_status','OrderController@user_order_status')->name('user_order_status');
    // Route::post('update_order_status','OrderController@update_order_status')->name('user.update_order_status');

});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');


Route::get('/clear-all', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('view:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('optimize:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    echo "All Cache Cleared!"; exit;
});
