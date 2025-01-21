<?php

use App\Http\Controllers\Trader\AuthController;
use App\Http\Controllers\Trader\HomeController;
use App\Http\Controllers\Trader\Order\TraderOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Trader\Reports\TraderAccountController;

Route::get('trader/login', [AuthController::class, 'loginView'])->name('trader.login');
Route::post('trader/login', [AuthController::class, 'postLogin'])->name('trader.postLogin');

Route::group(['prefix' => 'trader', 'middleware' => 'trader'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('trader.index');
    Route::get('calender', [HomeController::class, 'calender'])->name('trader.calender');

    Route::get('logout', [AuthController::class, 'logout'])->name('trader.logout');

    Route::resource('myOrders', \App\Http\Controllers\Trader\MyOrdersController::class);

    Route::resource('traderProfile', App\Http\Controllers\Trader\AuthController::class);
    Route::group(['as' => 'trader.'], function () {

        Route::resource('orders', \App\Http\Controllers\Trader\Order\NewOrderController::class)->only('index'); //setting
        Route::get('import-form', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'exportExcel'])->name('import.excel'); //setting
        Route::get('excel-orders-form', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'exportForm'])->name('orders.export'); //setting
        Route::post('orders-excel', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'importOrders'])->name('orders.import'); //setting
//  Route::post('get_delivery_value', \App\Http\Controllers\Trader\Order\NewOrderController::class,'get_delivery_value')->name('admin.get_delivery_value');//setting
        Route::post('get_delivery_value', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'get_delivery_value'])->name('admin.get_delivery_value');
        Route::get('getOrderDetails', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'getOrderDetails'])->name('admin.getOrderDetails');
        Route::get('changeDelivery', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'changeDelivery'])->name('admin.changeDelivery');
        Route::get('changeStatus', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'changeStatus'])->name('admin.changeStatus');
        Route::get('getDeliveryForOrder/{id}', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'getDeliveryForOrder'])->name('admin.getDeliveryForOrder');
        Route::post('insertingDeliveryForOrder/{id}', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'insertingDeliveryForOrder'])->name('admin.insertingDeliveryForOrder');
        Route::get('orderDetails/{id}', [\App\Http\Controllers\Trader\Order\NewOrderController::class, 'orderDetails'])->name('admin.orderDetails');
        Route::resource('deliveryConvertedOrders', \App\Http\Controllers\Trader\Order\DeliveryConvertedOrderController::class)->only('index'); //setting
        Route::get('changeStatusForOrder/{id}', [\App\Http\Controllers\Trader\Order\DeliveryConvertedOrderController::class, 'changeStatusForOrder'])->name('admin.changeStatusForOrder');
        Route::post('changeStatusForOrder_store/{id}', [\App\Http\Controllers\Trader\Order\DeliveryConvertedOrderController::class, 'changeStatusForOrder_store'])->name('admin.changeStatusForOrder_store');

        Route::resource('totalDeliveryOrders', \App\Http\Controllers\Trader\Order\TotalDeliveryOrderController::class)->only('index'); //setting

        Route::resource('partialDeliveryOrders', \App\Http\Controllers\Trader\Order\PartialDeliveryOrderController::class)->only('index'); //setting

        Route::resource('notDeliveryOrders', \App\Http\Controllers\Trader\Order\NotDeliveryOrderController::class)->only('index'); //setting

        Route::resource('cancel_orders', \App\Http\Controllers\Trader\Order\CancelOrderController::class)->only('index'); //setting

        Route::resource('collection_orders', \App\Http\Controllers\Trader\Order\CollectionOrderController::class)->only('index'); //setting
        Route::resource('paid_orders', \App\Http\Controllers\Trader\Order\PaidOrderController::class)->only('index'); //setting
        Route::resource('under_implementation_orders', \App\Http\Controllers\Trader\Order\UnderImplementationOrderController::class)->only('index'); //setting
        Route::resource('delayedOrders', \App\Http\Controllers\Trader\Order\DelayOrderController::class)->only('index'); //setting

        Route::resource('hadback', \App\Http\Controllers\Trader\Order\HadbackController::class)->only('index'); //

        Route::resource('Tahseel', \App\Http\Controllers\Trader\Order\TahseelController::class)->only('index'); //
        Route::resource('shipping_on_messanger', \App\Http\Controllers\Trader\Order\ShippingOnMessanger::class)->only('index'); //setting

        Route::get('get_hadback', [\App\Http\Controllers\Trader\Order\HadbackController::class, 'get_hadback'])->name('get_hadback'); //
        Route::get('get_tahseel', [\App\Http\Controllers\Trader\Order\TahseelController::class, 'get_tahseel'])->name('get_tahseel'); //
       Route::get('trader-accounts', [TraderAccountController::class, 'index'])->name('trader_account'); //
       Route::resource('trader-orders', TraderOrderController::class)->only('index'); //

    });
});
