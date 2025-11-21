<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Backend\EngineController;
use App\Http\Controllers\Backend\SliderController;
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
    // return "Cleared!";
    return "<script>alert('Cache cleared!'); window.location.href='/';</script>";
});

Route::get('/', [HomePageController::class,'index']);
Route::get('/logins', [HomePageController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logoutForm'])->name('logout');
Route::get('frontend/product/detail/{id}', [HomePageController::class,'productDetail']);
Route::get('frontend/product/filter/{id}', [HomePageController::class, 'filter'])->name('product.filter');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/add-to-cart-detail', [CartController::class, 'addToCartDetail'])->name('addToCart.Detail');
Route::get('/load-miniCart', [CartController::class, 'loadMiniCart'])->name('loadMiniCart');
Route::get('product/category/filter', [HomePageController::class, 'productCategoryFilter'])->name('product.category.filter');
Route::get('product/suc-category/filter', [HomePageController::class, 'subCategoryFilter'])->name('product.suc-category.filter');
Route::get('product/engine/filter', [HomePageController::class, 'engineFilter'])->name('product.engine.filter');


Route::get('category/filter', [HomePageController::class,'categoryFilter']);
Route::resource('frontend-contact', FrontendContactController::class);
Route::resource('about-as', AboutAsController::class);

// Route សម្រាប់ AJAX
Route::get('/frontend-categorys', [HomePageController::class, 'frontendCategory']);
Route::get('/frontend-sub-categorys', [HomePageController::class, 'frontendSubCategory']);
Route::get('frontend/product/search', [HomePageController::class, 'frontendSearchProduct']);

Route::group(['prefix' => 'admins', 'middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class,'index']);
    Route::resource('users', UserController::class);
    Route::resource('product', ProductController::class);
    Route::get('product/category/onchange', [ProductController::class,'onchangeCagegory']);
    Route::get('product/sub-category/onchange', [ProductController::class,'onchangeSubCagegory']);
    Route::post('product/change/publish/{id}', [ProductController::class,'changePublish']);
    Route::resource('backend-contact', BackendContactController::class);
    Route::resource('category', ProductCategoryController::class);
    Route::resource('sub-category', ProductSubcategoryController::class);
    Route::resource('engine', EngineController::class);
    Route::resource('product-type', ProductTypeController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('shops', BackendShopController::class);
    Route::resource('slide', SliderController::class);

    Route::delete('/product/{id}/delete-photo', [ProductController::class, 'deletePhoto'])->name('product.delete_photo');
    Route::delete('/category/{id}/delete-photo', [ProductCategoryController::class, 'deletePhoto'])->name('productcate.delete_photo');
    Route::delete('/category/{category}/delete-photo', [ProductCategoryController::class, 'deletePhoto'])->name('productcate.delete_photo');
    Route::delete('/gallery-image/{id}/delete', [ProductController::class, 'deleteGalleryImage'])->name('product.delete_gallery_image');
    Route::post('admins/slide/change/status/{id}', [SliderController::class, 'changeStatus'])->name('admins.slide.change.status');

    Route::get('province', [AddressController::class, 'province']);
    Route::post('district', [AddressController::class, 'district']);
    Route::post('commune', [AddressController::class, 'commune']);
    Route::post('village', [AddressController::class, 'village']);
});
/**dd */
