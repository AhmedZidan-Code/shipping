<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Trader;
use App\Models\TraderPayments;

class TraderAccountController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        //  $this->middleware('permission:عرض حسابات التجار', ['only' => ['index']]);
    }
    public function index()
    {
        return view('Admin.reports.traders.account');
    }
    
    public function show($trader_id)
    {
        $trader = Trader::findOrFail($trader_id);
        $orders = $trader->orders()->has('payment');
        $count = $orders->count();
        $total = $orders->sum('shipment_value');

        $paymentOrders = TraderPayments::where('trader_id', $trader_id)
            ->withCount('orders')
            ->get()
            ->toArray();

        $view = view('Admin.reports.traders.parts.account_table', compact('trader', 'count', 'total', 'paymentOrders'))->render();
        return response(['view' => $view]);
        // First part of the union query: Orders table
//         $firstQuery = DB::table('orders')
//             ->select(
//                 DB::raw('SUM(orders.shipment_value) AS amount'),
//                 DB::raw('DATE(orders.created_at) AS today'),
//                 DB::raw('GROUP_CONCAT(orders.notes SEPARATOR "; ") AS notes'),
//                 DB::raw('COUNT(*) AS order_count'),
//                 DB::raw('0 AS type'), 
//                 DB::raw('1 AS order_or_payment')
//             )
//             ->where('orders.trader_id', $trader_id)
//             ->groupBy(DB::raw('DATE(orders.created_at)'))
//             ->orderBy('today', 'ASC');

// // Second part of the union query: Trader Payments table
//         $secondQuery = DB::table('trader_payments')
//             ->select(
//                 'trader_payments.amount AS amount',
//                 'trader_payments.date AS today',
//                 'trader_payments.notes',
//                 'trader_payments.type',
//                 DB::raw('2 AS order_or_payment'),
//                 DB::raw('(SELECT COUNT(*) FROM orders WHERE trader_payments.id = orders.paid_id  AND DATE(orders.created_at) = trader_payments.date) AS order_count')
//             )
//             ->where('trader_payments.trader_id', $trader_id);

//         $combinedQuery = $firstQuery
//             ->union($secondQuery)
//             ->orderBy('today', 'ASC')
//             ->get();

    }
}
