<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\CartController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Backend\AddressController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\AboutAsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Backend\BackendShopController;
use App\Http\Controllers\Backend\ProductTypeController;
use App\Http\Controllers\Backend\BackendContactController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Frontend\FrontendContactController;
use App\Http\Controllers\Backend\ProductSubcategoryController;

/*
    php artisan make:controller Backend/UserController --resource
    php artisan make:model Company -m
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});

Route::get('/', [HomePageController::class,'index']);
Route::get('/logins', [HomePageController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logoutForm'])->name('logout');
Route::get('frontend/product/detail/{id}', [HomePageController::class,'productDetail']);
Route::get('frontend/product/filter/{id}', [ProductController::class, 'filter'])->name('product.filter');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');


Route::get('category/filter', [HomePageController::class,'categoryFilter']);
Route::resource('frontend-contact', FrontendContactController::class);
Route::resource('about-as', AboutAsController::class);

Route::group(['prefix' => 'admins', 'middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class,'index']);
    Route::resource('users', UserController::class);
    Route::resource('product', ProductController::class);
    Route::get('product/category/onchange', [ProductController::class,'onchangeCagegory']);
    Route::post('product/change/publish/{id}', [ProductController::class,'changePublish']);
    Route::resource('backend-contact', BackendContactController::class);
    Route::resource('category', ProductCategoryController::class);
    Route::resource('sub-category', ProductSubcategoryController::class);
    Route::resource('product-type', ProductTypeController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('shops', BackendShopController::class);

    Route::get('province', [AddressController::class, 'province']);
    Route::post('district', [AddressController::class, 'district']);
    Route::post('commune', [AddressController::class, 'commune']);
    Route::post('village', [AddressController::class, 'village']);
});
