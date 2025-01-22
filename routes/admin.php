<?php

use App\Http\Controllers\Admin\Agent\AgentController;
use App\Http\Controllers\Admin\Agent\AgentOrderController;
use App\Http\Controllers\Admin\Agent\AgentPaymentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OpeningBalanceController;
use App\Http\Controllers\Admin\Order\DeliveryConvertedOrderController;
use App\Http\Controllers\Admin\Reports\CompanyProfitController;
use App\Http\Controllers\Admin\Reports\DailyTreasuryController;
use App\Http\Controllers\Admin\Reports\DailyTreasuryDetailsController;
use App\Http\Controllers\Admin\Reports\DeliveryProfitController;
use App\Http\Controllers\Admin\Reports\MandoubSalaryController;
use App\Http\Controllers\Admin\Reports\TraderAccountController;
use App\Http\Controllers\Admin\Reports\TraderProfitController;
use App\Http\Controllers\Admin\Reports\TreasuryController;
use App\Http\Controllers\Admin\TraderDebtController;
use App\Http\Controllers\Admin\Web\ContactController;
use App\Http\Controllers\Admin\Web\FeatureController;
use App\Http\Controllers\Admin\Web\MemberController;
use App\Http\Controllers\Admin\Web\ProcessController;
use App\Http\Controllers\Admin\Web\ServiceController;
use App\Http\Controllers\Admin\Web\SliderController;
use App\Http\Controllers\Admin\Web\StaticPageController;
use App\Http\Controllers\Admin\Web\StatisticsController;
use App\Http\Controllers\Admin\Web\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AuthController::class, 'loginView'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'postLogin'])->name('admin.postLogin');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('admin.index');
    Route::get('calender', [HomeController::class, 'calender'])->name('admin.calender');

    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    ### admins

    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
    Route::resource('price', \App\Http\Controllers\Admin\PriceController::class);
    Route::resource('agent-price', \App\Http\Controllers\Admin\AgentPriceController::class);
    Route::get('activateAdmin', [App\Http\Controllers\Admin\AdminController::class, 'activate'])->name('admin.active.admin');

    ### roles
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class); //setting

    ### categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class); //setting

    ### countries
    Route::resource('countries', \App\Http\Controllers\Admin\CountryController::class); //setting

    ###administrative-settings
    Route::resource('administrative-settings', \App\Http\Controllers\Admin\AdministrativeSettingController::class); //administrative-settings

    ###expenses
    Route::resource('expenses', \App\Http\Controllers\Admin\ExpenseController::class); //expenses

    ### categories
    Route::resource('provinces', \App\Http\Controllers\Admin\ProvinceController::class); //setting
    Route::get('getGovernorates', [\App\Http\Controllers\Admin\ProvinceController::class, 'getGovernorates'])->name('admin.getGovernorates'); //setting

    ### delivers
    Route::resource('delivers', \App\Http\Controllers\Admin\DeliveryController::class); //setting
    Route::get('getDeliveries', [\App\Http\Controllers\Admin\DeliveryController::class, 'getDeliveries'])->name('admin.getDeliveries'); //setting

    ### traders
    Route::resource('traders', \App\Http\Controllers\Admin\TraderController::class); //setting
    Route::get('addOrderToTrader/{id}', [\App\Http\Controllers\Admin\TraderController::class, 'addOrderToTrader'])->name('admin.addOrderToTrader');
    Route::post('storeOrderToTrader/{id}', [\App\Http\Controllers\Admin\TraderController::class, 'storeOrderToTrader'])->name('admin.storeOrderToTrader');
    Route::get('getTraders', [\App\Http\Controllers\Admin\TraderController::class, 'getTraders'])->name('admin.getTraders'); //setting

    Route::resource('orders', \App\Http\Controllers\Admin\Order\NewOrderController::class); //setting
    Route::get('import-form', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'exportExcel'])->name('import.excel'); //setting
    Route::get('excel-orders-form', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'exportForm'])->name('orders.export'); //setting
    Route::post('orders-excel', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'importOrders'])->name('orders.import'); //setting
    //  Route::post('get_delivery_value', \App\Http\Controllers\Admin\Order\NewOrderController::class,'get_delivery_value')->name('admin.get_delivery_value');//setting
    Route::post('get_delivery_value', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'get_delivery_value'])->name('admin.get_delivery_value');
    Route::get('getOrderDetails', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'getOrderDetails'])->name('admin.getOrderDetails');
    Route::get('changeDelivery', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'changeDelivery'])->name('admin.changeDelivery');
    Route::get('changeStatus', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'changeStatus'])->name('admin.changeStatus');
    Route::get('getDeliveryForOrder/{id}', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'getDeliveryForOrder'])->name('admin.getDeliveryForOrder');
    Route::post('insertingDeliveryForOrder/{id}', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'insertingDeliveryForOrder'])->name('admin.insertingDeliveryForOrder');
    Route::post('insertBulkOrdersForDelivery', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'insertBulkOrdersForDelivery'])->name('admin.insertBulkOrdersForDelivery');
    Route::get('orderDetails/{id}', [\App\Http\Controllers\Admin\Order\NewOrderController::class, 'orderDetails'])->name('admin.orderDetails');

    Route::resource('trader-payments', \App\Http\Controllers\Admin\TraderPaymentController::class);

    Route::resource('deliveryConvertedOrders', \App\Http\Controllers\Admin\Order\DeliveryConvertedOrderController::class); //setting
    Route::get('changeStatusForOrder/{id}', [\App\Http\Controllers\Admin\Order\DeliveryConvertedOrderController::class, 'changeStatusForOrder'])->name('admin.changeStatusForOrder');
    Route::post('changeStatusForOrder_store/{id}', [\App\Http\Controllers\Admin\Order\DeliveryConvertedOrderController::class, 'changeStatusForOrder_store'])->name('admin.changeStatusForOrder_store');
    Route::post('convert_order', [\App\Http\Controllers\Admin\Order\DeliveryConvertedOrderController::class, 'convert_order'])->name('admin.convert_order');

    Route::resource('totalDeliveryOrders', \App\Http\Controllers\Admin\Order\TotalDeliveryOrderController::class); //setting

    Route::resource('partialDeliveryOrders', \App\Http\Controllers\Admin\Order\PartialDeliveryOrderController::class); //setting

    Route::resource('notDeliveryOrders', \App\Http\Controllers\Admin\Order\NotDeliveryOrderController::class); //setting

    Route::resource('cancel_orders', \App\Http\Controllers\Admin\Order\CancelOrderController::class); //setting

    Route::resource('collection_orders', \App\Http\Controllers\Admin\Order\CollectionOrderController::class); //setting
    Route::resource('paid_orders', \App\Http\Controllers\Admin\Order\PaidOrderController::class); //setting
    Route::resource('under_implementation_orders', \App\Http\Controllers\Admin\Order\UnderImplementationOrderController::class); //setting
    Route::resource('shipping_on_messanger', \App\Http\Controllers\Admin\Order\ShippingOnMessanger::class); //setting

    ### activities
    Route::resource('activities', App\Http\Controllers\Admin\ActivityController::class);

    ### settings
    Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class); //setting

    #reports

    Route::resource('deliversReports', \App\Http\Controllers\Admin\Reports\DeliveryReportsController::class); //setting

    Route::resource('mandoubReports', \App\Http\Controllers\Admin\Reports\MandoubReportsController::class); //setting

    Route::resource('tradersReports', \App\Http\Controllers\Admin\Reports\TraderReportsController::class); //setting
    Route::resource('mandoub-salary', MandoubSalaryController::class);

    Route::resource('todayOrdersReports', \App\Http\Controllers\Admin\Reports\TodayOrdersReportsController::class); //setting
    Route::get('todayOrdersReports-details', [\App\Http\Controllers\Admin\Reports\TodayOrdersReportsController::class, 'details'])->name('todayOrdersReports.details'); //setting

    Route::resource('delayedOrders', \App\Http\Controllers\Admin\Order\DelayOrderController::class); //setting
    Route::post('get_delivery_orders', [\App\Http\Controllers\Admin\Reports\MandoubReportsController::class, 'get_delivery_orders'])->name('admin.get_delivery_orders');
    Route::post('add_delivery_orders', [\App\Http\Controllers\Admin\Reports\MandoubReportsController::class, 'add_delivery_orders'])->name('admin.add_delivery_orders');
    Route::post('add_agent_orders', [AgentOrderController::class, 'addAgentOrders'])->name('admin.add_agent_orders');

    Route::get('get_order_mandoub_details/{id}', [\App\Http\Controllers\Admin\Reports\MandoubReportsController::class, 'get_order_mandoub_details'])->name('admin.get_order_mandoub_details');

    //=============================================================
    Route::resource('hadback', \App\Http\Controllers\Admin\Order\HadbackController::class); //

    Route::resource('Tahseel', \App\Http\Controllers\Admin\Order\TahseelController::class); //
    Route::resource('trader-payment-details', \App\Http\Controllers\Admin\OrderDetailsController::class)->only('index'); //

    Route::get('get_hadback', [\App\Http\Controllers\Admin\Order\HadbackController::class, 'get_hadback'])->name('admin.get_hadback'); //
    Route::get('get_tahseel', [\App\Http\Controllers\Admin\Order\TahseelController::class, 'get_tahseel'])->name('admin.get_tahseel'); //
    Route::get('trader-accounts', [TraderAccountController::class, 'index'])->name('trader-accounts.index'); //

    Route::get('mandoub_orders', [\App\Http\Controllers\Admin\Reports\MandoubReportsController::class, 'mandoub_orders'])->name('admin.mandoub_orders');
    Route::post('change_button', [\App\Http\Controllers\Admin\Reports\MandoubReportsController::class, 'change_button'])->name('admin.change_button');

    // Route::post('add_hadback',[\App\Http\Controllers\Admin\Order\HadbackController::class,'add_hadback'])->name('admin.add_hadback');
    Route::get('treasury', [TreasuryController::class, 'index'])->name('treasury.index');
    Route::get('daily-treasury-data', [DailyTreasuryController::class, 'data'])->name('daily-treasury.data');
    Route::get('daily-treasury', [DailyTreasuryController::class, 'index'])->name('daily-treasury.index');

    ### Agents
    Route::resource('agents', AgentController::class)->except('show'); //setting
    Route::get('getAgents', [AgentController::class, 'getAgents'])->name('admin.getAgents'); //setting
    Route::get('agents/import-form', [AgentOrderController::class, 'exportExcel'])->name('agent.import.excel'); //setting
    Route::get('agents/excel-orders-form', [AgentOrderController::class, 'exportForm'])->name('agent.orders.export'); //setting
    Route::post('agent/sorders-excel', [AgentOrderController::class, 'importOrders'])->name('agent.orders.import'); //setting
    // Route::post('orders-total-value/update', [AgentOrderController::class, 'updateOrders'])->name('agent.orders-update-value'); //setting
    Route::resource('agent-payments', AgentPaymentController::class);
    Route::resource('opening-balance', OpeningBalanceController::class);
    Route::resource('traders-debt', TraderDebtController::class);

    Route::get('/daily-treasury-details', [DailyTreasuryDetailsController::class, 'index'])->name('detailed');
    Route::get('/daily-treasury-details/details/data', [DailyTreasuryDetailsController::class, 'getData'])->name('detailed.data');
    Route::get('/treasury-day/{day}', [DailyTreasuryDetailsController::class, 'getDataOfDay'])->name('treasury-details.day');

    //profits
    Route::resource('company-profits', CompanyProfitController::class);
    Route::resource('delivery-profits', DeliveryProfitController::class);
    Route::resource('trader-profits', TraderProfitController::class);
    Route::get('print-order-details', [DeliveryConvertedOrderController::class, 'printOrderDetails'])->name('admin.print.order');

    //sliders
    Route::resource('sliders', SliderController::class);

    /* wed site routes */
    //features
    Route::resource('features', FeatureController::class);

    //static pages
    Route::resource('static-pages', StaticPageController::class);
    //processes
    Route::resource('processes', ProcessController::class);
    //services
    Route::resource('services', ServiceController::class);
    //videos
    Route::resource('videos', VideoController::class);
    //statistics
    Route::resource('statistics', StatisticsController::class);
    //statistics
    Route::resource('members', MemberController::class);
    //contacts
    Route::resource('contacts', ContactController::class);
});
//
