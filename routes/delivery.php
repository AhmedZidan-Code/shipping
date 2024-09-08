<?php


use App\Http\Controllers\Delivery\{AuthController, HomeController,};
use Illuminate\Support\Facades\Route;

Route::get('delivery/login', [AuthController::class, 'loginView'])->name('delivery.login');
Route::post('delivery/login', [AuthController::class, 'postLogin'])->name('delivery.postLogin');


Route::group(['prefix' => 'delivery', 'middleware' => 'delivery'], function () {



    Route::get('/', [HomeController::class,'index'])->name('delivery.index');
    Route::get('calender', [HomeController::class,'calender'])->name('delivery.calender');

    Route::get('logout', [AuthController::class, 'logout'])->name('delivery.logout');


    Route::resource('myCurrentOrders', \App\Http\Controllers\Delivery\Order\CurrentOrderController::class);
    Route::get('changeMyOrderStatus', [\App\Http\Controllers\Delivery\Order\CurrentOrderController::class,'changeMyOrderStatus'])->name('delivery.changeMyOrderStatus');
    Route::get('deliveryChangeOrderStatus/{id}', [\App\Http\Controllers\Delivery\Order\CurrentOrderController::class,'deliveryChangeOrderStatus'])->name('delivery.deliveryChangeOrderStatus');
    Route::post('deliveryChangeOrderStatus_store/{id}', [\App\Http\Controllers\Delivery\Order\CurrentOrderController::class,'deliveryChangeOrderStatus_store'])->name('delivery.deliveryChangeOrderStatus_store');


    Route::resource('myEndOrders', \App\Http\Controllers\Delivery\Order\OrderController::class);


    Route::resource('deliveryProfile',App\Http\Controllers\Delivery\AuthController::class);


});
