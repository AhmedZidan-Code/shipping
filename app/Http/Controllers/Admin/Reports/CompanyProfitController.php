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
            $deliveryOrders = DB::table('delivery_orders');
            if ($request->month) {
                $deliveryOrders->where('month', $request->month);
            }
            if ($request->year) {
                $deliveryOrders->where('year', $request->year);
            }
            $deliveryOrders->select(
                'date',
                'company_commission',
                'fees',
                'solar',
                DB::raw('0 as value')
            );

            $expenses = DB::table('expenses');
            if ($request->month) {
                $expenses->whereRaw('MONTH(date) = ?', [$request->month]);
            }
            if ($request->year) {
                $expenses->whereRaw('YEAR(date) = ?', [$request->year]);
            }
            $expenses->select(
                'date',
                DB::raw('0 as company_commission'),
                DB::raw('0 as fees'),
                DB::raw('0 as solar'),
                'value'
            );

            $rows = $deliveryOrders->unionAll($expenses);
            $salaries = DB::table('salaries');
            $totalExpenses = DB::table('expenses');
            if ($request->month) {
                $salaries->where('month', $request->month);
                $totalExpenses->whereRaw('MONTH(date) = ?', [$request->month]);
            }
            if ($request->year) {
                $salaries->where('year', $request->year);
                $totalExpenses->whereRaw('YEAR(date) = ?', [$request->year]);
            }
            $commissionAfterFees = $rows->sum(DB::raw('company_commission - (fees + solar)'));
            $totalExpenses = $totalExpenses->sum('value');
            $totalRemainder = $commissionAfterFees - $totalExpenses;
            $total_salary = $salaries->sum('total_salary');
            $netProfit = $totalRemainder - $total_salary;
            $commissionSum = $rows->sum('company_commission');
            $feesSum = $rows->sum('fees');
            $solarSum = $rows->sum('solar');
            $valueSum = $rows->sum('value');

            $dataTable = DataTables::of($rows)
                ->addIndexColumn()
                ->editColumn('remainder', function ($row) {
                    return $row->company_commission - ($row->fees + $row->solar);
                })
                ->with('total_salary', $total_salary)
                ->with('total_remainder', $totalRemainder)
                ->with('net_profit', $netProfit)
                ->with('commission_sum', $commissionSum)
                ->with('fees_sum', $feesSum)
                ->with('solar_sum', $solarSum)
                ->with('value_sum', $valueSum)
                ->escapeColumns([])
                ->make(true);

            return $dataTable;
        }

        return view('Admin.reports.profits.company');
    }
}
