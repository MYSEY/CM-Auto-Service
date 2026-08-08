<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\AddressController;
use App\Http\Controllers\Backend\BackendContactController;
use App\Http\Controllers\Backend\BackendShopController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\EngineController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductSubcategoryController;
use App\Http\Controllers\Backend\ProductTypeController;
use App\Http\Controllers\Backend\SellController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\AboutAsController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FrontendContactController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// use Illuminate\Support\Facades\Storage;

/*
    php artisan make:controller Backend/UserController --resource
    php artisan make:model Company -m
|--------------------------------------------------------------------------
| Web Routess
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

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/', [HomePageController::class,'index'])->name('products.index');

// PWA Routes
Route::get('/splash', [\App\Http\Controllers\Pwa\PwaController::class, 'splash'])->name('pwa.splash');

// Push Notification Routes
Route::post('/pwa/push/subscribe', [\App\Http\Controllers\Pwa\PushNotificationController::class, 'subscribe'])->name('pwa.push.subscribe');
Route::post('/pwa/push/unsubscribe', [\App\Http\Controllers\Pwa\PushNotificationController::class, 'unsubscribe'])->name('pwa.push.unsubscribe');
Route::get('/pwa/push/vapid-key', [\App\Http\Controllers\Pwa\PushNotificationController::class, 'vapidPublicKey'])->name('pwa.push.vapid-key');
Route::post('/admins/push/send', [\App\Http\Controllers\Pwa\PushNotificationController::class, 'sendNotification'])->name('admin.push.send');
Route::get('/pwa', [\App\Http\Controllers\Pwa\PwaController::class, 'home'])->name('pwa.home');
Route::get('/pwa/search', [\App\Http\Controllers\Pwa\PwaController::class, 'search'])->name('pwa.search');
Route::get('/pwa/product/{id}', [\App\Http\Controllers\Pwa\PwaController::class, 'productDetail'])->name('pwa.product');
Route::get('/pwa/cart', [\App\Http\Controllers\Pwa\PwaController::class, 'cart'])->name('pwa.cart');
Route::post('/pwa/cart/add', [\App\Http\Controllers\Pwa\PwaController::class, 'addToCart'])->name('pwa.cart.add');
Route::post('/pwa/cart/update', [\App\Http\Controllers\Pwa\PwaController::class, 'updateCart'])->name('pwa.cart.update');
Route::post('/pwa/cart/remove', [\App\Http\Controllers\Pwa\PwaController::class, 'removeCart'])->name('pwa.cart.remove');
Route::get('/pwa/wishlist', [\App\Http\Controllers\Pwa\PwaController::class, 'wishlist'])->name('pwa.wishlist');
Route::get('/pwa/contact', [\App\Http\Controllers\Pwa\PwaController::class, 'contact'])->name('pwa.contact');
Route::get('/pwa/account', [\App\Http\Controllers\Pwa\PwaController::class, 'account'])->name('pwa.account');
Route::get('/pwa/chat', [\App\Http\Controllers\Pwa\ChatController::class, 'index'])->name('pwa.chat');
Route::post('/pwa/chat/send', [\App\Http\Controllers\Pwa\ChatController::class, 'send'])->name('pwa.chat.send');
Route::get('/pwa/chat/poll', [\App\Http\Controllers\Pwa\ChatController::class, 'poll'])->name('pwa.chat.poll');
Route::get('/logins', [HomePageController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logoutForm'])->name('logout');
Route::get('frontend/product/detail/{id}', [HomePageController::class,'productDetail']);
Route::get('/product-detail', [HomePageController::class, 'productDetail'])->name('productDetail');
Route::get('frontend/product/filter/{id}', [HomePageController::class, 'filter'])->name('product.filter');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/add-to-cart-detail', [CartController::class, 'addToCartDetail'])->name('addToCart.Detail');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/load-miniCart', [CartController::class, 'loadMiniCart'])->name('loadMiniCart');

// Cart Page
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place');

// Wishlist
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/check', [WishlistController::class, 'check'])->name('wishlist.check');

// Account (requires auth)
Route::group(['middleware' => ['auth']], function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::put('/account/update', [AccountController::class, 'updateProfile'])->name('account.update');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{id}', [AccountController::class, 'orderDetail'])->name('account.order.detail');
});
Route::get('product/category/filter', [HomePageController::class, 'productCategoryFilter'])->name('product.category.filter');
Route::get('product/suc-category/filter', [HomePageController::class, 'subCategoryFilter'])->name('product.suc-category.filter');
Route::get('product/engine/filter', [HomePageController::class, 'engineFilter'])->name('product.engine.filter');
// web.php
Route::get('/ajax/filter/products', [HomePageController::class, 'ajaxFilterProducts'])->name('ajax.filter.products');


Route::get('category/filter', [HomePageController::class,'categoryFilter']);
Route::resource('frontend-contact', FrontendContactController::class);
Route::resource('about-as', AboutAsController::class);
// Route::get('/products/tab', [HomeController::class, 'loadProducts'])->name('products.tab');

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
    Route::resource('order', OrderController::class);
    Route::post('order/change-status', [OrderController::class, 'changeStatus'])->name('order.change-status');
    Route::resource('sell',  SellController::class);
    Route::post('sell/change-status', [SellController::class, 'changeStatus'])->name('sell.change-status');


    Route::delete('/product/{id}/delete-photo', [ProductController::class, 'deletePhoto'])->name('product.delete_photo');
    Route::delete('/category/{id}/delete-photo', [ProductCategoryController::class, 'deletePhoto'])->name('productcate.delete_photo');
    Route::delete('/gallery-image/{id}/delete', [ProductController::class, 'deleteGalleryImage'])->name('product.delete_gallery_image');
    Route::post('admins/slide/change/status/{id}', [SliderController::class, 'changeStatus'])->name('admins.slide.change.status');

    Route::get('chatbot', [\App\Http\Controllers\Backend\ChatBotController::class, 'index'])->name('admin.chatbot.index');
    Route::post('chatbot', [\App\Http\Controllers\Backend\ChatBotController::class, 'store'])->name('admin.chatbot.store');
    Route::put('chatbot/{id}', [\App\Http\Controllers\Backend\ChatBotController::class, 'update'])->name('admin.chatbot.update');
    Route::delete('chatbot/{id}', [\App\Http\Controllers\Backend\ChatBotController::class, 'destroy'])->name('admin.chatbot.destroy');
    Route::get('chatbot/{id}/toggle', [\App\Http\Controllers\Backend\ChatBotController::class, 'toggle'])->name('admin.chatbot.toggle');
    Route::post('chatbot/default', [\App\Http\Controllers\Backend\ChatBotController::class, 'defaultReply'])->name('admin.chatbot.default');

    Route::get('chat', [\App\Http\Controllers\Backend\AdminChatController::class, 'index'])->name('admin.chat.index');
    Route::get('chat/{sessionId}', [\App\Http\Controllers\Backend\AdminChatController::class, 'show'])->name('admin.chat.show');
    Route::post('chat/{sessionId}/send', [\App\Http\Controllers\Backend\AdminChatController::class, 'send'])->name('admin.chat.send');
    Route::get('chat/{sessionId}/poll', [\App\Http\Controllers\Backend\AdminChatController::class, 'poll'])->name('admin.chat.poll');
    Route::delete('chat/{sessionId}', [\App\Http\Controllers\Backend\AdminChatController::class, 'destroy'])->name('admin.chat.destroy');

    Route::get('province', [AddressController::class, 'province']);
    Route::post('district', [AddressController::class, 'district']);
    Route::post('commune', [AddressController::class, 'commune']);
    Route::post('village', [AddressController::class, 'village']);
});
/**dd */
