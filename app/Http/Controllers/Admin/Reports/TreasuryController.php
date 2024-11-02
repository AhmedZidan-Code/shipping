<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TreasuryController extends Controller
{
    protected $total;
    public function index(Request $request)
    {
        if ($request->type && $request->type == '1') {
            $startDate = $request->input('fromDate') ? Carbon::parse($request->input('fromDate'))->startOfDay() : null;
            $endDate = $request->input('toDate') ? Carbon::parse($request->input('toDate'))->endOfDay() : null;

            if ($request->ajax()) {

                $query = $this->getUnionQuery($startDate, $endDate);

                if ($startDate) {
                    $query->where('date', '>=', $startDate->toDateString());
                }
                if ($endDate) {
                    $query->where('date', '<=', $endDate->toDateString());
                }
                if (!$startDate && !$endDate) {
                    $query->where('date', '=', date('Y-m-d'));
                }

                return DataTables::of($query)
                    ->addColumn('total_value', function ($row) {
                        return $this->total += $row->total_orders - ($row->value + $row->fees + $row->amount + $row->total + $row->solar + $row->balance/*+ $row->shipment_value*/);
                    })
                    ->editColumn('value', function ($row) {
                        return $row->fees + $row->value;
                    })
                    ->make(true);
            }
            return view('Admin.reports.treasury.index', ['type' => '1']);
        }
        $fromDate = request()->input('fromDate');
        $toDate = request()->input('toDate');

        $allOrdersValues = DB::table('delivery_orders')
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('date_time', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('date_time', '<=', $toDate);
            })
            ->when(!$fromDate && !$toDate, function ($query) use ($toDate) {
                return $query->whereDate('date_time', '=', date('Y-m-d'));
            })
            ->sum('total_orders');

        $expenses = DB::table('expenses')
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '<=', $toDate);
            })
            ->when(!$fromDate && !$toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '=', date('Y-m-d'));
            })
            ->sum('value');

        $traderPayments = DB::table('trader_payments')
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '<=', $toDate);
            })
            ->when(!$fromDate && !$toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '=', date('Y-m-d'));
            })
            ->sum('amount');

        $agentPayments = DB::table('agent_payments')
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '<=', $toDate);
            })
            ->when(!$fromDate && !$toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '=', date('Y-m-d'));
            })
            ->sum('total');

        $solar = DB::table('delivery_orders')
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('date_time', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('date_time', '<=', $toDate);
            })
            ->when(!$fromDate && !$toDate, function ($query) use ($toDate) {
                return $query->whereDate('date_time', '=', date('Y-m-d'));
            })
            ->sum('solar');

        $fees = DB::table('delivery_orders')
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('date_time', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('date_time', '<=', $toDate);
            })
            ->when(!$fromDate && !$toDate, function ($query) use ($toDate) {
                return $query->whereDate('date_time', '=', date('Y-m-d'));
            })
            ->sum('fees');
        // $tahseel = DB::table('orders')
        //     ->whereIn('status', ['total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger'])
        //     ->where('paid_as_money', 0)
        //     ->when($fromDate, function ($query) use ($fromDate) {
        //         return $query->whereDate('converted_date', '>=', $fromDate);
        //     })
        //     ->when($toDate, function ($query) use ($toDate) {
        //         return $query->whereDate('converted_date', '<=', $toDate);
        //     })
        //     ->sum('shipment_value');
        $balance = DB::table('opening_balances')
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '<=', $toDate);
            })
            ->when(!$fromDate && !$toDate, function ($query) use ($toDate) {
                return $query->whereDate('date', '=', date('Y-m-d'));
            })
            ->sum('balance');

        return view('Admin.reports.treasury.index', [
            'type' => '2',
            'allOrdersValues' => $allOrdersValues,
            'expenses' => $expenses + $fees,
            'traderPayments' => $traderPayments,
            'agentPayments' => $agentPayments,
            'solar' => $solar,
            // 'tahseel' => $tahseel,
            'balance' => $balance,
        ]);
    }

    private function getUnionQuery($startDate, $endDate)
    {
        $subQuery = DB::query()->fromSub(function ($query) use ($startDate, $endDate) {
            $query->from('delivery_orders')
                ->select([
                    'total_orders',
                    DB::raw('0 as value'),
                    DB::raw('0 as amount'),
                    DB::raw('0 as total'),
                    'solar',
                    'fees',
                    // DB::raw('0 as shipment_value'),
                    DB::raw('0 as balance'),
                    DB::raw("DATE_FORMAT(date_time, '%Y-%m-%d') as date"),
                ])
                ->unionAll(DB::table('expenses')
                        ->select([
                            DB::raw('0 as total_orders'),
                            'value',
                            DB::raw('0 as amount'),
                            DB::raw('0 as total'),
                            DB::raw('0 as solar'),
                            DB::raw('0 as fees'),
                            // DB::raw('0 as shipment_value'),
                            DB::raw('0 as balance'),
                            DB::raw('DATE(date) as date'),
                        ])
                )
                ->unionAll(DB::table('agent_payments')
                        ->select([
                            DB::raw('0 as total_orders'),
                            DB::raw('0 as value'),
                            DB::raw('0 as amount'),
                            'total',
                            DB::raw('0 as solar'),
                            DB::raw('0 as fees'),
                            // DB::raw('0 as shipment_value'),
                            DB::raw('0 as balance'),
                            DB::raw('DATE(date) as date'),
                        ])
                )
                ->unionAll(DB::table('trader_payments')
                        ->select([
                            DB::raw('0 as total_orders'),
                            DB::raw('0 as value'),
                            'amount',
                            DB::raw('0 as total'),
                            DB::raw('0 as solar'),
                            DB::raw('0 as fees'),
                            // DB::raw('0 as shipment_value'),
                            DB::raw('0 as balance'),
                            DB::raw('DATE(date) as date'),
                        ])
                )
                ->unionAll(DB::table('opening_balances')
                        ->select([
                            DB::raw('0 as total_orders'),
                            DB::raw('0 as value'),
                            DB::raw('0 as amount'),
                            DB::raw('0 as total'),
                            DB::raw('0 as solar'),
                            DB::raw('0 as fees'),
                            DB::raw('balance'),
                            DB::raw('DATE(date) as date'),
                        ])
                );
            // ->unionAll(DB::table('orders')
            //         ->select([
            //             DB::raw('0 as total_orders'),
            //             DB::raw('0 as value'),
            //             DB::raw('0 as amount'),
            //             DB::raw('0 as total'),
            //             DB::raw('0 as solar'),
            //             DB::raw('0 as fees'),
            //             // 'shipment_value',
            //             DB::raw("DATE_FORMAT(converted_date, '%Y-%m-%d') as date"),
            //         ])
            //         ->whereIn('status', ['total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger'])
            //         ->where('paid_as_money', 0)
            // );

        }, 'union_subquery');

        return $subQuery
            ->select([
                DB::raw('SUM(total_orders) as total_orders'),
                DB::raw('SUM(value) as value'),
                DB::raw('SUM(fees) as fees'),
                DB::raw('SUM(amount) as amount'),
                DB::raw('SUM(total) as total'),
                DB::raw('SUM(solar) as solar'),
                // DB::raw('SUM(shipment_value) as shipment_value'),
                DB::raw('SUM(balance) as balance'),
                'date',
            ])
            ->groupBy('date')
            ->orderBy('date', 'desc');
    }
}
