<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TreasuryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type && $request->type == '1') {
            $startDate = $request->input('fromDate') ? Carbon::parse($request->input('fromDate'))->startOfDay() : null;
            $endDate = $request->input('toDate') ? Carbon::parse($request->input('toDate'))->endOfDay() : null;

            if ($request->ajax()) {
                $query = $this->getUnionQuery($startDate, $endDate);

                return DataTables::of($query)
                    ->addColumn('total_value', function ($row) {
                        return $row->total_orders - ($row->value + $row->amount + $row->solar + $row->shipment_value);
                    })
                    ->make(true);
            }

            return view('Admin.reports.treasury.index', ['type' => '1']);
        }

        $fromDate = request()->input('fromDate');
        $toDate = request()->input('toDate');

        $allOrdersValues = DB::table('delivery_orders')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('date', [$fromDate, $toDate]);
            })
            ->sum('total_orders');

        $expenses = DB::table('expenses')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('date', [$fromDate, $toDate]);
            })
            ->sum('value');

        $traderPayments = DB::table('trader_payments')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('date', [$fromDate, $toDate]);
            })
            ->sum('amount');

        $agentPayments = DB::table('agent_payments')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('date', [$fromDate, $toDate]);
            })
            ->sum('total');

        $solar = DB::table('delivery_orders')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('date', [$fromDate, $toDate]);
            })
            ->sum('solar');

        $tahseel = DB::table('orders')
            ->whereIn('status', ['total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger'])
            ->where('paid_as_money', 0)
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('created_at', [$fromDate, $toDate]);
            })
            ->sum('shipment_value');

        return view('Admin.reports.treasury.index', [
            'type' => '2',
            'allOrdersValues' => $allOrdersValues,
            'expenses' => $expenses,
            'traderPayments' => $traderPayments,
            'agentPayments' => $agentPayments,
            'solar' => $solar,
            'tahseel' => $tahseel,
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
                    DB::raw('0 as shipment_value'),
                    DB::raw('DATE(date) as date'),
                ])
                ->unionAll(DB::table('expenses')
                        ->select([
                            DB::raw('0 as total_orders'),
                            'value',
                            DB::raw('0 as amount'),
                            DB::raw('0 as total'),
                            DB::raw('0 as solar'),
                            DB::raw('0 as shipment_value'),
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
                            DB::raw('0 as shipment_value'),
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
                            DB::raw('0 as shipment_value'),
                            DB::raw('DATE(date) as date'),
                        ])
                )
                ->unionAll(DB::table('orders')
                        ->select([
                            DB::raw('0 as total_orders'),
                            DB::raw('0 as value'),
                            DB::raw('0 as amount'),
                            DB::raw('0 as total'),
                            DB::raw('0 as solar'),
                            'shipment_value',
                            DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
                        ])
                        ->whereIn('status', ['total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger'])
                        ->where('paid_as_money', 0)
                );

            if ($startDate && $endDate) {
                $query->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()]);
            }
        }, 'union_subquery');

        return $subQuery
            ->select([
                DB::raw('SUM(total_orders) as total_orders'),
                DB::raw('SUM(value) as value'),
                DB::raw('SUM(amount) as amount'),
                DB::raw('SUM(total) as total'),
                DB::raw('SUM(solar) as solar'),
                DB::raw('SUM(shipment_value) as shipment_value'),
                'date',
            ])
            ->groupBy('date')
            ->orderBy('date', 'desc');
    }
}
