<?php

namespace App\Http\Controllers\Trader\Reports;

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
        $trader = auth('trader')->user();
        $orders = $trader->orders();
        $count = $orders->count();
        $total = $orders->sum('shipment_value');

        $paymentOrders = TraderPayments::where('trader_id', $trader->id)
            ->withCount('orders')
            ->get()
            ->toArray();

        return view('Trader.reports.traders.account', compact('trader', 'count', 'total', 'paymentOrders'));
    }
    

}
