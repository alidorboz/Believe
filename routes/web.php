<?php

use App\Http\Controllers\Admin\ProductsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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

//Route::get('/', function () {
     //return view('welcome');
//});
use App\Models\Category;
//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    //all the admine routes here
    Route::match(['get','post'],'/','AdminController@login');
    Route::group(['middleware'=>['admin']],function(){
        Route::get('dashboard','AdminController@dashboard');
        Route::get('settings','AdminController@settings');
        Route::get('logout','AdminController@logout');
        Route::post('check-current-pwd','AdminController@checkCurrentPassword');
        Route::post('update-current-pwd','AdminController@updateCurrentPassword');
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails');

        //Sections
        Route::get('sections','SectionController@sections');
        Route::post('update-section-status','SectionController@updateSectionStatus');
        //Categories
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        Route::post('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        //Products
        Route::get('products','ProductsController@products');
        Route::post('update-product-status','ProductsController@updateProductStatus');
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');
        //Attributes
        Route::match(['get','post'],'add-attributes/{id}','ProductsController@addAttributes');
        Route::post('edit-attributes/{id}','ProductsController@editAttributes');
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');

        //Images
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');

        //Banners
        Route::get('banners','BannerController@banners');
        Route::match(['get','post'],'add-edit-banner/{id?}','BannerController@addeditBanner');
        Route::post('update-banner-status','BannerController@updateBannerStatus');
        Route::get('delete-banner/{id}','BannerController@deleteBanner');

        //Coupons
        Route::get('coupons','CouponController@coupons');
        Route::post('update-coupon-status','CouponController@updateCouponStatus');
        Route::match(['get','post'],'add-edit-coupon/{id?}','CouponController@addeditCoupon');
        Route::get('delete-coupon/{id}','CouponController@deleteCoupon');
        //Orders
        Route::get('orders','OrdersController@orders');
        Route::get('orders/{id}','OrdersController@orderDetails');
        Route::post('update-order-status','OrdersController@updateOrderStatus');
        Route::get('view-order-invoice/{id}','OrdersController@viewOrderInvoice');
        Route::get('print-pdf-invoice/{id}','OrdersController@printPDFInvoice');

        //Export Orders
        Route::get('export-orders','OrdersController@exportOrders');

        //Users
        Route::get('users','UsersController@users');
        Route::post('update-user-status','UsersController@updateUserStatus');
        //Export Users
        Route::get('export-users','UsersController@exportUsers');

        Route::get('newsletter-subscribers','NewsletterController@newsletterSubscribers');
        Route::post('update-subscriber-status','NewsletterController@updateSubscriberStatus');
        Route::get('delete-subscriber/{id}','NewsletterController@deleteSubscriber');


    });
});
Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/','IndexController@index');
    //
    // Get Category Url's
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach( $catUrls as $url){
        Route::get('/'.$url,'ProductsController@listing');
    }
   // Product Detail Route
   Route::get('/product/{id}','ProductsController@detail');

   //Get Product Attribute Price
   Route::post('/get-product-price','ProductsController@getProductPrice');
   

   Route::post('/add-to-cart','ProductsController@addtoCart');
   Route::get('/cart','ProductsController@cart');
  
    //Update Cart Item Quantity
    Route::post('/update-cart-item-qty','ProductsController@updateCartItemQty');
    Route::get('/cart-totals', function() {
        $total_price = 0;
        $delivery_tax = 5;
        $cartItems = Session::get('cart');
        if ($cartItems) {
            foreach ($cartItems as $cartItem) {
                $total_price += $cartItem['price'] * $cartItem['quantity'];
            }
        }
        $CouponAmount = Session::get('CouponAmount');
        $total_price = $total_price - ($CouponAmount ? $CouponAmount : 0);
        return view('cart.cart_items', compact('total_price', 'delivery_tax'));
    });
    

    //Delete Cart Item

    Route::post('/delete-cart-item','ProductsController@deleteCartItem');

    // Login/Register
    Route::get('/login-register',['as'=>'login','uses'=>'UsersController@loginRegister']);

    //Login User
    Route::post('/login','UsersController@loginUser');
    Route::get('/about','UsersController@about');


    //Register User
    Route::post('/register','UsersController@registerUser');
    //logout user
    Route::get('/logout','UsersController@logoutUser');

    //Check email
    Route::match(['get','post'],'/check-email','UsersController@checkEmail');
    // Confirm Account
    Route::match(['get','post'],'/confirm/{code}','UsersController@confirmAccount');
    Route::match(['get','post'],'/forgot-password','UsersController@forgotPassword');
    Route::post('/add-subscriber-email','NewsletterController@addSubscriber');
    Route::group(['middleware'=>['auth']],function(){
        //Forgot Password
       
        //Users Account
        Route::match(['get','post'],'/account','UsersController@account');
        //Users Orders
        Route::get('/orders','OrdersController@orders');
        //User Order Details
        Route::get('/orders/{id}','OrdersController@orderDetails');
        //Check current password
        Route::post('/check-user-pwd','UsersController@chkUserPassword');
        //Update Password
        Route::post('/update-password','UsersController@updateUserPassword');
        //Apply coupon
        Route::post('/apply-coupon','ProductsController@applyCoupon');
        //checkout
        Route::match(['get','post'],'/checkout','ProductsController@checkout');
        //Add/Edit Delivery Address
        Route::match(['get','post'],'/add-edit-delivery-address/{id?}','ProductsController@addEditDeliveryAddress');
        //Delete delivery adddress
        Route::get('/delete-delivery-address/{id}','ProductsController@deleteDeliveryAddress');
        //Thanks
        Route::get('/thanks','ProductsController@thanks');
   
    });



});

