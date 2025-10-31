<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\FrontendCompanyController;

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

Route::get('/', [HomePageController::class,'index']);

Auth::routes();
Route::group(['prefix' => 'admins', 'middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class,'index']);
    Route::resource('users', UserController::class);
    Route::resource('company', CompanyController::class);
});
