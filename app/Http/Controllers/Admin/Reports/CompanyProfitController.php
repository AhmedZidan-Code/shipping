<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CompanyProfitController extends Controller
{
public function index(Request $request)
{
    if ($request->ajax()) {
        // Prepare base queries with common filtering
        $baseQuery = function ($query) use ($request) {
            return $query
                ->when($request->month, function ($q) use ($request) {
                    return $q->whereMonth('date', $request->month);
                })
                ->when($request->year, function ($q) use ($request) {
                    return $q->whereYear('date', $request->year);
                });
        };

        // Delivery Orders Query
        $deliveryOrders = DB::table('delivery_orders')
            ->when($request->month, function ($query) use ($request) {
                return $query->where('month', $request->month);
            })
            ->when($request->year, function ($query) use ($request) {
                return $query->where('year', $request->year);
            })
            ->select(
                'date',
                DB::raw('SUM(company_commission) as company_commission'),
                DB::raw('SUM(fees) as fees'),
                DB::raw('SUM(solar) as solar'),
                DB::raw('0 as value')
            )
            ->groupBy('date');

        // Expenses Query
        $expenses = DB::table('expenses')
            ->when($request->month, function ($query) use ($request) {
                return $query->whereRaw('MONTH(date) = ?', [$request->month]);
            })
            ->when($request->year, function ($query) use ($request) {
                return $query->whereRaw('YEAR(date) = ?', [$request->year]);
            })
            ->select(
                'date',
                DB::raw('0 as company_commission'),
                DB::raw('0 as fees'),
                DB::raw('0 as solar'),
                DB::raw('SUM(value) as value')
            )
            ->groupBy('date');

        // Combine Queries
        $unionQuery = DB::query()->fromSub(function ($query) use ($deliveryOrders, $expenses) {
            $query->from($deliveryOrders)
                ->unionAll($expenses);
        }, 'combined_data')
        ->select([
            'date',
            DB::raw('SUM(company_commission) as company_commission'),
            DB::raw('SUM(fees) as fees'),
            DB::raw('SUM(solar) as solar'),
            DB::raw('SUM(value) as value'),
        ])
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

        // Salaries Query
        $salaries = DB::table('salaries')
            ->when($request->month, function ($query) use ($request) {
                return $query->where('month', $request->month);
            })
            ->when($request->year, function ($query) use ($request) {
                return $query->where('year', $request->year);
            });

        // Expenses Query for Total Calculation
        $totalExpensesQuery = DB::table('expenses')
            ->when($request->month, function ($query) use ($request) {
                return $query->whereRaw('MONTH(date) = ?', [$request->month]);
            })
            ->when($request->year, function ($query) use ($request) {
                return $query->whereRaw('YEAR(date) = ?', [$request->year]);
            });

        // Calculations
        $commissionSum = $unionQuery->sum('company_commission');
        $totalExpenses = $totalExpensesQuery->sum('value');
        $solarSum = $unionQuery->sum('solar');
        $commissionAfterFees = $commissionSum - $totalExpenses;
        $total_salary = $salaries->sum('total_salary');
        $totalRemainder = $commissionAfterFees - $totalExpenses;
        $netProfit = $totalRemainder - $total_salary;

        // Sums
        $feesSum = $unionQuery->sum('fees');
        $valueSum = $unionQuery->sum('value');

        // DataTables Response
        return DataTables::of($unionQuery)
            ->addIndexColumn()
            ->editColumn('remainder', function ($row) {
                return $row->company_commission - $row->value;
            })
            ->with([
                'total_salary' => $total_salary,
                'total_remainder' => $totalRemainder,
                'net_profit' => $netProfit,
                'commission_sum' => $commissionSum,
                'fees_sum' => $feesSum,
                'solar_sum' => $solarSum,
                'value_sum' => $valueSum,
            ])
            ->escapeColumns([])
            ->make(true);
    }

    return view('Admin.reports.profits.company');
}
}
