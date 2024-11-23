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
            $rows = $rows = DB::table('delivery_orders');
            $salaries = DB::table('salaries');
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
            $totalRemainder = $rows->sum(DB::raw('company_commission - (fees + solar)'));
            $total_salary = $salaries->sum('total_salary');
            $netProfit = $totalRemainder - $total_salary;
            $ordersSum = $rows->sum('num_mandoub_orders');
            $commissionSum = $rows->sum('company_commission');
            $feesSum = $rows->sum('fees');
            $solarSum = $rows->sum('solar');
            $dataTable = DataTables::of($rows)
                ->editColumn('remainder', function ($row) {
                    return $row->company_commission - ($row->fees + $row->solar);
                })
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
