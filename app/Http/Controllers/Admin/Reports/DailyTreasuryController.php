<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\OpeningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyTreasuryController extends Controller
{
    public function data(Request $request)
    {
        $fromDate = $request->has('fromDate') ? $request->fromDate : today()->format('Y-m-d');
        $toDate = $request->has('toDate') ? $request->toDate : today()->format('Y-m-d');
        $openingBalance = OpeningBalance::first();
        if ($openingBalance && $fromDate < $openingBalance->date) {
            $fromDate = $openingBalance->date;
        }
        $data = (array) array_merge((array) $this->filteredBalance($fromDate, $toDate), (array) $this->previousBalance($fromDate, isset($openingBalance) ? $openingBalance->date : null));
        $view = \view('Admin.reports.daily_treasury.parts.data', $data)->render();

        return response()->json(['view' => $view]);
    }

    public function index()
    {
        return \view('Admin.reports.daily_treasury.index');
    }

    public function previousBalance($fromDate, $openingDate = null)
    {
        $dliveryOrders =  DB::table('delivery_orders')
            ->when($fromDate, fn($q) => $q->whereDate('date', '<', $fromDate))
            ->when($openingDate, fn($q) => $q->whereDate('date', '>=', $openingDate))
            ->selectRaw('SUM(total_orders) as previous_total_orders, SUM(solar) as previous_solar, SUM(fees) as previous_fees, SUM(cash) as previous_cash, SUM(cheque) as previous_cheque')
            ->first();
        $expenses =  DB::table('expenses')
            ->when($fromDate, fn($q) => $q->whereDate('date', '<', $fromDate))
            ->when($openingDate, fn($q) => $q->whereDate('date', '>=', $openingDate))
            ->selectRaw('SUM(value) as previous_expenses')
            ->first();
        $traderPayments =  DB::table('trader_payments')
            ->when($fromDate, fn($q) => $q->whereDate('date', '<', $fromDate))
            ->when($openingDate, fn($q) => $q->whereDate('date', '>=', $openingDate))
            ->selectRaw('SUM(amount) as previous_traderPayment, SUM(cash) as previous_traderCash, SUM(cheque) as previous_traderCheque')
            ->first();
        $openingBalance =  DB::table('opening_balances')
            ->first();

        $data = (object) array_merge((array) $dliveryOrders, (array) $expenses, (array) $traderPayments);
        $previous['total_previous'] = ($data->previous_total_orders + $openingBalance?->balance ?? 0) - ($data->previous_fees + $data->previous_solar + $data->previous_expenses + $data->previous_traderPayment);
        $previous['previous_cash'] =  ($data->previous_cash + $openingBalance?->cash ?? 0) - ($data->previous_fees + $data->previous_solar + $data->previous_expenses + $data->previous_traderCash);
        $previous['previous_cheque'] =  ($data->previous_cheque + $openingBalance?->cheque ?? 0) - ($data->previous_fees + $data->previous_solar + $data->previous_expenses + $data->previous_traderCheque);
        return $previous;
    }

    public function filteredBalance($fromDate, $toDate)
    {
        $dliveryOrders =  DB::table('delivery_orders')
            ->when($fromDate, fn($q) => $q->whereDate('date', '>=', $fromDate))
            ->when($toDate, fn($q) => $q->whereDate('date', '<=', $toDate))
            ->selectRaw('SUM(total_orders) as total_orders, SUM(solar) as solar, SUM(fees) as fees, SUM(cash) as cash, SUM(cheque) as cheque')
            ->first();
        $expenses =  DB::table('expenses')
            ->when($fromDate, fn($q) => $q->whereDate('date', '>=', $fromDate))
            ->when($toDate, fn($q) => $q->whereDate('date', '<=', $toDate))
            ->selectRaw('SUM(value) as expenses')
            ->first();
        $traderPayments =  DB::table('trader_payments')
            ->when($fromDate, fn($q) => $q->whereDate('date', '>=', $fromDate))
            ->when($toDate, fn($q) => $q->whereDate('date', '<=', $toDate))
            ->selectRaw('SUM(amount) as traderPayment, SUM(cash) as traderCash, SUM(cheque) as traderCheque')
            ->first();

        return (array) array_merge((array) $dliveryOrders, (array) $expenses, (array) $traderPayments);
    }
}
