<?php

use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'trader'], function () {
    Route::get('/profile', function () {
        return 'done';
    });
});
// Artisan Command Route
Route::get('migrate-run', function () {
    \Artisan::call('migrate');
    return "sd";
});
Route::get('storage-link', function () {
    \Artisan::call('storage:link');
    return "storage linked successfully";
});
//
