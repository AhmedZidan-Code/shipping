<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DeliveryProfitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = DB::query()->fromSub(function ($query) {
                $query->from(function ($subquery) {
                    // First query for delivery orders
                    $subquery->from('delivery_orders')
                        ->select(
                            DB::raw('SUM(num_mandoub_orders) as num_mandoub_orders'),
                            DB::raw('SUM(company_commission) as company_commission'),
                            DB::raw('SUM(fees) as fees'),
                            DB::raw('SUM(solar) as solar'),
                            DB::raw('0 as expenses'),
                            'date'
                        )
                        ->when(request('delivery_id'), function ($q) {
                            return $q->where('delivery_id', request('delivery_id'));
                        })
                        ->when(request('year'), function ($q) {
                            return $q->where('year', request('year'));
                        })
                        ->when(request('month'), function ($q) {
                            return $q->where('month', request('month'));
                        })
                        ->groupBy('date')
                        ->unionAll(
                            // Second query for expenses
                            DB::table('expenses')
                                ->whereNotNull('delivery_id')
                                ->select(
                                    DB::raw('0 as num_mandoub_orders'),
                                    DB::raw('0 as company_commission'),
                                    DB::raw('0 as fees'),
                                    DB::raw('0 as solar'),
                                    DB::raw('SUM(value) as expenses'),
                                    'date'
                                )
                                ->when(request('delivery_id'), function ($q) {
                                    return $q->where('delivery_id', request('delivery_id'));
                                })
                                ->when(request('year'), function ($q) {
                                    return $q->whereYear('date', request('year'));
                                })
                                ->when(request('month'), function ($q) {
                                    return $q->whereMonth('date', request('month'));
                                })
                                ->groupBy('date')
                        );
                }, 'union_table')
                    ->select(
                        'date',
                        DB::raw('SUM(num_mandoub_orders) as num_mandoub_orders'),
                        DB::raw('SUM(company_commission) as company_commission'),
                        DB::raw('SUM(fees) as fees'),
                        DB::raw('SUM(solar) as solar'),
                        DB::raw('SUM(expenses) as expenses'),
                    )
                    ->groupBy('date');
            }, 'final_results')
                ->select('*')
                ->orderBy('date');;

            $salaries = DB::table('salaries');

            // Apply filters
            if ($request->delivery_id) {
                $salaries->where('delivery_id', $request->delivery_id);
            }

            // Calculate totals from the base query to ensure filters are applied
            $total_salary = $salaries->sum('base_salary');

            // Get sums for the filtered data
            $ordersSum = $rows->sum('num_mandoub_orders');
            $commissionSum = $rows->sum('company_commission');
            $expensesSum = $rows->sum('expenses');
            $totalRemainder = $rows->sum('company_commission') ;
            $netProfit = $totalRemainder - $total_salary;
            $dataTable = DataTables::of($rows)
                ->addIndexColumn()
                ->addColumn('remainder', function ($row) {
                    return $row->company_commission - $row->expenses;
                })
                ->with('total_salary', $total_salary)
                ->with('total_remainder', $totalRemainder)
                ->with('net_profit', $netProfit)
                ->with('orders_sum', $ordersSum)
                ->with('commission_sum', $commissionSum)
                ->with('expenses_sum', $expensesSum)
                ->escapeColumns([])
                ->make(true);

            return $dataTable;
        }

        return view('Admin.reports.profits.delivery');
    }
}
