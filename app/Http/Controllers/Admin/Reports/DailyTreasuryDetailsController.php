<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\OpeningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DailyTreasuryDetailsController extends Controller
{
    public function index()
    {
        return view('Admin.reports.daily_treasury.details');
    }

    public function getData(Request $request)
    {
        $fromDate = isset($request->fromDate) ? $request->fromDate : today()->format('Y-m-d');
        $toDate = isset($request->toDate) ? $request->toDate : today()->format('Y-m-d');
        $openingBalance = OpeningBalance::first();
        if ($openingBalance && $fromDate < $openingBalance->date) {
            $fromDate = $openingBalance->date;
        }
        $previousBalance = $this->previousBalance($fromDate, isset($openingBalance) ? $openingBalance->date : null);

        $query = DB::query()->fromSub(function ($query) use ($fromDate, $toDate) {
            $query->from('delivery_orders')
                ->when($fromDate, fn($q) => $q->whereDate('date', '>=', $fromDate))
                ->when($toDate, fn($q) => $q->whereDate('date', '<=', $toDate))
                ->select([
                    DB::raw('DATE(date) as date'),
                    'total_orders',
                    'cash',
                    'cheque',
                    'solar',
                    'fees',
                    DB::raw('0 as expenses'),
                    DB::raw('0 as trader_amount'),
                    DB::raw('0 as trader_cash'),
                    DB::raw('0 as trader_cheque')
                ])
                ->unionAll(
                    // Expenses Query
                    DB::table('expenses')
                        ->when($fromDate, fn($q) => $q->whereDate('date', '>=', $fromDate))
                        ->when($toDate, fn($q) => $q->whereDate('date', '<=', $toDate))
                        ->select([
                            DB::raw('DATE(date) as date'),
                            DB::raw('0 as total_orders'),
                            DB::raw('0 as cash'),
                            DB::raw('0 as cheque'),
                            DB::raw('0 as solar'),
                            DB::raw('0 as fees'),
                            'value as expenses',
                            DB::raw('0 as trader_amount'),
                            DB::raw('0 as trader_cash'),
                            DB::raw('0 as trader_cheque')
                        ])
                )
                ->unionAll(
                    // Trader Payments Query
                    DB::table('trader_payments')
                        ->whereIn('type', [1, 2])
                        ->when($fromDate, fn($q) => $q->whereDate('date', '>=', $fromDate))
                        ->when($toDate, fn($q) => $q->whereDate('date', '<=', $toDate))
                        ->select([
                            DB::raw('DATE(date) as date'),
                            DB::raw('0 as total_orders'),
                            DB::raw('0 as cash'),
                            DB::raw('0 as cheque'),
                            DB::raw('0 as solar'),
                            DB::raw('0 as fees'),
                            DB::raw('0 as expenses'),
                            'amount as trader_amount',
                            'cash as trader_cash',
                            'cheque as trader_cheque'
                        ])
                );
        }, 'union_table')
            ->select([
                'date',
                DB::raw('SUM(total_orders) as daily_orders'),
                DB::raw('SUM(cash) as cash_orders'),
                DB::raw('SUM(cheque) as cheque_orders'),
                DB::raw('SUM(solar) as solar'),
                DB::raw('SUM(fees) as fees'),
                DB::raw('SUM(expenses) as expenses'),
                DB::raw('SUM(trader_amount) as trader_payments'),
                DB::raw('SUM(trader_cash) as trader_cash'),
                DB::raw('SUM(trader_cheque) as trader_cheque'),
                DB::raw('(
                SUM(total_orders) - 
                (SUM(solar) + SUM(fees) + SUM(expenses) + SUM(trader_amount))
            ) as daily_net'),
                DB::raw('(
                SUM(cash) - 
                (SUM(solar) + SUM(fees) + SUM(expenses) + SUM(trader_cash))
            ) as daily_cash_net'),
                DB::raw('(
                SUM(cheque) - SUM(trader_cheque)
            ) as daily_cheque_net')
            ])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return DataTables::of($query)
            ->addColumn('details', function ($row) {
                // $url = route('admin.d', $row->date);
                $url = '#';
                return  '<a href=' . $url . ' class="btn rounded-pill btn-outline-dark treasur_details" data-date=' . $row->date . '><i class="fa fa-eye" aria-hidden="true"></i></a>';
            })
            ->with('total_daily_orders', function () use ($query) {
                return $query->sum('daily_orders');
            })
            ->with('total_solar', function () use ($query) {
                return $query->sum('solar');
            })
            ->with('total_fees', function () use ($query) {
                return $query->sum('fees');
            })
            ->with('total_expenses', function () use ($query) {
                return $query->sum('expenses');
            })
            ->with('total_trader_payments', function () use ($query) {
                return $query->sum('trader_payments');
            })
            ->with('total_cash_orders', function () use ($query) {
                return $query->sum('cash_orders');
            })
            ->with('total_cheque_orders', function () use ($query) {
                return $query->sum('cheque_orders');
            })
            ->with('total_trader_cash', function () use ($query) {
                return $query->sum('trader_cash');
            })
            ->with('total_trader_cheque', function () use ($query) {
                return $query->sum('trader_cheque');
            })
            ->with('previous_balance', function () use ($previousBalance) {
                return $previousBalance;
            })
            ->with('total_daily_net', function () use ($query) {
                return $query->sum('daily_net');
            })
            ->with('total_daily_cash_net', function () use ($query) {
                return $query->sum('daily_cash_net');
            })
            ->with('total_daily_cheque_net', function () use ($query) {
                return $query->sum('daily_cheque_net');
            })
            ->rawColumns(['details'])
            ->make(true);
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
            ->whereIn('type', [1, 2])
            ->when($fromDate, fn($q) => $q->whereDate('date', '<', $fromDate))
            ->when($openingDate, fn($q) => $q->whereDate('date', '>=', $openingDate))
            ->selectRaw('SUM(amount) as previous_traderPayment, SUM(cash) as previous_traderCash, SUM(cheque) as previous_traderCheque')
            ->first();
        $openingBalance =  DB::table('opening_balances')
            ->first();

        $data = (object) array_merge((array) $dliveryOrders, (array) $expenses, (array) $traderPayments);
        $balance = isset($openingBalance) ? $openingBalance->balance : 0;
        $balanceCash = isset($openingBalance) ? $openingBalance->cash : 0;
        $balanceCheque = isset($openingBalance) ? $openingBalance->cheque : 0;
        $previous['total_previous'] = ($data->previous_total_orders + $balance) - ($data->previous_fees + $data->previous_solar + $data->previous_expenses + $data->previous_traderPayment);
        $previous['previous_cash'] =  ($data->previous_cash + $balanceCash) - ($data->previous_fees + $data->previous_solar + $data->previous_expenses + $data->previous_traderCash);
        $previous['previous_cheque'] =  ($data->previous_cheque + $balanceCheque) - ($data->previous_fees + $data->previous_solar + $data->previous_expenses + $data->previous_traderCheque);
        return $previous;
    }

    public function getDataOfDay($date)
    {
        $dliveryOrders =  DB::table('delivery_orders')
            ->when($date, fn($q) => $q->whereDate('date',  $date))
            ->get();
        $expenses =  DB::table('expenses')
            ->when($date, fn($q) => $q->whereDate('date',  $date))
            ->get();
        $traderPayments =  DB::table('trader_payments')
            ->whereIn('type', [1, 2])
            ->when($date, fn($q) => $q->whereDate('date',  $date))
            ->get();

        $view = \view('Admin.reports.daily_treasury.parts.day_details', \compact('dliveryOrders', 'expenses', 'traderPayments'))->render();

        return \response()->json(['view' => $view]);
    }
}
