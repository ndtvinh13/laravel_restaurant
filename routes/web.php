<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
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
Route::get('/main-page', [HomeController::class, 'index']);
Route::get('/contact-aaa', [ServiceController::class, 'index'])->name('contact');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

//Category page on menu layout
Route::get('/category/{category_id}', [MenuController::class, 'category_menu'])->name('menu.category');
//Product detail on menu layout
Route::get('/product-detail/{product_id}', [MenuController::class, 'product_detail'])->name('product.detail');
//Search products
Route::get('/search', [MenuController::class, 'search_product'])->name('search.product');
Route::post('/searching', [MenuController::class, 'search_result'])->name('search.result');
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
Route::get('/delete-cart/{rowId}',[CartController::class,'delete_cart'])->name('cart.delete');
Route::post('/update-cart',[CartController::class,'update_cart'])->name('cart.update');



//-----------------------------Back-end-----------------------------//
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
});


// Route::get('/dashboard',[AdminController::class,'show_dashboard'])->name('admin.dashboard');

// Route::post('/admin-dashboard',[AdminController::class,'dashboard']);
Route::get('/logout', [LoginController::class, 'logout']);

// Route::get('/product',[AdminController::class,'product'])->name('admin.product');

