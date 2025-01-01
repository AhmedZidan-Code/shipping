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
            $rows = DB::table('delivery_orders')
                ->select(
                    'date',
                    DB::raw('MIN(id) as id'), 
                    DB::raw('SUM(num_mandoub_orders) as num_mandoub_orders'),
                    DB::raw('SUM(company_commission) as company_commission'),
                    DB::raw('SUM(fees) as fees'),
                    DB::raw('SUM(solar) as solar'),
                    // DB::raw('SUM(mandoub_commission) as mandoub_commission'),
                    DB::raw('SUM(company_commission - mandoub_commission) as remainder')
                );
               

            $salaries = DB::table('salaries');

            // Apply filters
            if ($request->delivery_id) {
                $rows->where('delivery_id', $request->delivery_id);
                $salaries->where('delivery_id', $request->delivery_id);
            }
            if ($request->month) {
                $rows->where('month', $request->month);
                $salaries->where('month', $request->month);
            }
            if ($request->year) {
                $rows->where('year', $request->year);
                $salaries->where('year', $request->year);
            }

            // Calculate totals from the base query to ensure filters are applied
            $totalsQuery = clone $rows;
            $totalRemainder = $totalsQuery->sum(DB::raw('company_commission - solar'));
            $total_salary = $salaries->sum('total_salary');
            $netProfit = $totalRemainder - $total_salary;

            // Get sums for the filtered data
            $sumsQuery = clone $rows;
            $ordersSum = $sumsQuery->sum('num_mandoub_orders');
            $commissionSum = $sumsQuery->sum('company_commission');
            $feesSum = $sumsQuery->sum('fees');
            $solarSum = $sumsQuery->sum('solar');
            $rows->groupBy('date');
            $dataTable = DataTables::of($rows)
                ->addIndexColumn()
                ->orderColumn('id', 'date $1') // Change ordering to use date instead of id
                ->with('total_salary', $total_salary)
                ->with('total_remainder', $totalRemainder)
                ->with('net_profit', $netProfit)
                ->with('orders_sum', $ordersSum)
                ->with('commission_sum', $commissionSum)
                ->with('fees_sum', $feesSum)
                ->with('solar_sum', $solarSum)
                ->escapeColumns([])
                ->make(true);

            return $dataTable;
        }

        return view('Admin.reports.profits.delivery');
    }
}
