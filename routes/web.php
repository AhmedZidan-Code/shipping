<?php

use App\Http\Controllers\Web\AboutController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\TrackingOrderController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

// Frontend Route
Route::redirect('/', '/home');

// Authentication Routes
Route::get('/login', [RegisterController::class, 'showLoginForm'])->name('web.login');
Route::post('/login', [RegisterController::class, 'login'])->name('doLogin');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('doRegister');

// Home Route
Route::get('/home', [HomeController::class, 'index'])->name('web.home');
Route::get('/about-us', [AboutController::class, 'index'])->name('web.about');
Route::get('/contact-us', [ContactController::class, 'index'])->name('web.contact');
Route::post('/contact-us', [ContactController::class, 'store'])->name('web.send.contact');

Route::get('/tracking-order/{order?}', [TrackingOrderController::class, 'trace'])->name('order.tracking');
Route::group(['middleware' => 'trader_web'], function () {

    Route::get('/profile', function () {
        return 'done';
    });
});
// Artisan Command Route
Route::get('migrate-run', function () {
    // \Artisan::call('optimize:clear');
    \Artisan::call('migrate');
    // \Artisan::call('db:seed');
    return "sd";
});
Route::get('storage-link', function () {
    \Artisan::call('storage:link');
    return "storage linked successfully";
});

Route::get('time-stamp', function () {
   return date("Y-m-d h:i");
});
