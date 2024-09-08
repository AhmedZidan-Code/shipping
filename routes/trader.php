<?php


use App\Http\Controllers\Trader\{AuthController, HomeController,};
use Illuminate\Support\Facades\Route;

Route::get('trader/login', [AuthController::class, 'loginView'])->name('trader.login');
Route::post('trader/login', [AuthController::class, 'postLogin'])->name('trader.postLogin');


Route::group(['prefix' => 'trader', 'middleware' => 'trader'], function () {



    Route::get('/', [HomeController::class,'index'])->name('trader.index');
    Route::get('calender', [HomeController::class,'calender'])->name('trader.calender');

    Route::get('logout', [AuthController::class, 'logout'])->name('trader.logout');


    Route::resource('myOrders', \App\Http\Controllers\Trader\MyOrdersController::class);


    Route::resource('traderProfile',App\Http\Controllers\Trader\AuthController::class);


});
