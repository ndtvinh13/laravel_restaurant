<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
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


//===================================Front-end===================================//
Route::get('/', [HomeController::class, 'index'])->name('');
Route::get('/main-page', [HomeController::class, 'index'])->name('main.page');
Route::get('/404', [HomeController::class, 'error_404'])->name('main.404');
Route::get('/500', [HomeController::class, 'error_500'])->name('main.500');
Route::get('/contact-aaa', [ServiceController::class, 'index'])->name('contact');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

//Category page on menu layout
Route::get('/category/{category_id}', [MenuController::class, 'category_menu'])->name('menu.category');
//Product detail on menu layout
Route::get('/product-detail/{product_id}', [MenuController::class, 'product_detail'])->name('product.detail');
//Search products
Route::get('/search', [MenuController::class, 'search_product'])->name('search.product');
Route::post('/searching', [MenuController::class, 'search_result'])->name('search.result');
Route::get('/search-ajax', [MenuController::class, 'search_product_ajax'])->name('search.product.ajax');
//Sort products
Route::get('/sort', [MenuController::class, 'sort_product'])->name('sort');

//-----------------------------Customer login--------------------------//
Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
Route::post('/customer-register', [CustomerController::class, 'register'])->name('customer.register');
Route::post('/customer-login', [CustomerController::class, 'login'])->name('customer.login');
Route::get('/customer-logout', [CustomerController::class, 'logout'])->name('customer.logout');


//-----------------------------Cart--------------------------------//
//Menu cart
Route::get('/cart',[CartController::class,'index'])->name('cart.show');
Route::post('/save-cart',[CartController::class,'save_cart'])->name('cart.save');
Route::get('/save-cart-ajax',[CartController::class,'save_cart_ajax'])->name('cart.save.ajax');
Route::get('/delete-cart/{rowId}',[CartController::class,'delete_cart'])->name('cart.delete');
Route::get('/delete-cart-all',[CartController::class,'delete_cart_all'])->name('cart.delete.all');
Route::post('/update-cart',[CartController::class,'update_cart'])->name('cart.update');
Route::get('/cart-item-ajax',[CartController::class,'cart_item_ajax'])->name('cart.item.ajax');
Route::get('/cart-item-del-ajax',[CartController::class,'cart_item_del_ajax'])->name('cart.item.del.ajax');
Route::post('/coupon-check',[CartController::class,'coupon_check'])->name('coupon.check');
Route::get('/coupon-check',[CartController::class,'session_coupon_del'])->name('coupon.session.del');


//==================== Middleware Customer ====================//
Route::middleware('loginCheck')->group(function () {
    
    //-----------------------------Checkout--------------------------------//
    Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout');
    Route::post('/save-checkout',[CheckoutController::class,'save_checkout'])->name('checkout.save');
    Route::get('/payment',[CheckoutController::class,'payment'])->name('payment');
    Route::post('/place-order',[CheckoutController::class,'place_order'])->name('order');
    Route::get('/confirmation',[CheckoutController::class,'confirmation'])->name('confirmation');
    Route::get('/reset-password',[CustomerController::class,'reset_password'])->name('user.reset.password');
    Route::get('/order-history',[CustomerController::class,'order_history'])->name('user.order.history');

});


// --------------------------- Review-----------------------------//
Route::post('/comment',[CommentController::class,'save_comment'])->name('comment');


//=====================================Back-end====================================//
Route::get('/admin-login', [LoginController::class, 'index'])->name('loginPage');

Route::post('/admin-dashboard', [LoginController::class, 'login'])->name('login');



//=============================================Middleware Admin============================================================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'show_dashboard'])->name('dashboard');

    //-----------------------------Category product-----------------------------//
    Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product'])->name('catadd');
    Route::get('/list-category-product', [CategoryProduct::class, 'list_category_product'])->name('catlist');
    Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
    Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
    Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);
    Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);
    Route::post('/import-csv', [CategoryProduct::class, 'import_csv'])->name('admin.import');
    Route::post('/export-csv', [CategoryProduct::class, 'export_csv'])->name('admin.export');


    //-----------------------------Product-----------------------------//
    Route::get('/add-product', [ProductController::class, 'add_product'])->name('prodadd');
    Route::get('/list-product', [ProductController::class, 'list_product'])->name('prodlist');
    Route::post('/save-product', [ProductController::class, 'save_product']);
    Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
    Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);
    Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);

    //-----------------------------Customer-----------------------------//
    Route::get('/list-customer', [CustomerController::class, 'list_customer'])->name('custlist');
    Route::get('/delete-customer/{user_id}', [CustomerController::class, 'delete_customer'])->name('custdelete');
    Route::get('/search-customer-ajax', [CustomerController::class, 'search_customer_ajax'])->name('cust.search.ajax');

    //-----------------------------Order-----------------------------//
    Route::get('/manage-order', [OrderController::class, 'manage_order'])->name('order.manage');
    Route::get('/view-order/{orderId}', [OrderController::class, 'view_order'])->name('order.view');
    Route::get('/delete-order/{orderId}', [OrderController::class, 'delete_order'])->name('order.delete');
    Route::get('/print-order/{code}', [OrderController::class, 'print_order'])->name('order.print');

    //-----------------------------Coupon-----------------------------//
    Route::get('/add-coupon', [CouponController::class, 'add_coupon'])->name('coupon.add');
    Route::post('/insert-coupon', [CouponController::class, 'insert_coupon'])->name('coupon.insert');
    Route::get('/list-coupon', [CouponController::class, 'list_coupon'])->name('coupon.list');
    Route::get('/delete-coupon/{couponId}', [CouponController::class, 'delete_coupon'])->name('coupon.delete');

    // ----------------------------Comment----------------------------//
    Route::get('/list-comment', [CommentController::class, 'list_comment'])->name('comment.list');
    Route::get('/search-comment-ajax', [CommentController::class, 'comment_search_ajax'])->name('comment.search.ajax');
    Route::get('/approval-comment-ajax', [CommentController::class, 'comment_approval_ajax'])->name('comment.approval.ajax');
    Route::get('/delete-comment/{commentId}', [CommentController::class, 'comment_delete'])->name('comment.delete');
});

// ---------------------------Admin Logout--------------------------//
Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Route::get('/product',[AdminController::class,'product'])->name('admin.product');



// Test
Route::get('/test', [CartController::class, 'test'])->name('test');