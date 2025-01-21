<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TraderProfitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = DB::table('orders')->whereIn('status', ['total_delivery_to_customer', 'partial_delivery_to_customer', 'not_delivery', 'shipping_on_messanger']);
            if ($request->trader_id) {
                $rows->where('trader_id', $request->trader_id);
            }
            if ($request->fromDate) {
                $rows->whereDate('created_at', '>=', $request->fromDate);
            }
            if ($request->toDate) {
                $rows->whereDate('created_at', '<=', $request->toDate);
            }

            $rows->selectRaw('DATE(created_at) as order_date, COUNT(*) as orders_count, SUM(total_value) as total_value, SUM(shipment_value) as shipment_value,  SUM(delivery_value) as delivery_value')
                ->groupBy(DB::raw('DATE(created_at)'));

            $totalOrdersCount = $rows->get()->sum('orders_count');
            $totalOrdersValue = $rows->get()->sum('total_value');
            $totalOrdersShipment = $rows->get()->sum('shipment_value');
            // $totalDeliveryValue = $rows->get()->sum('delivery_value');
            $totalSum = $totalOrdersValue - $totalOrdersShipment ;

            $dataTable = DataTables::of($rows)
                ->addIndexColumn()
                ->addColumn('company_commission', function ($row) {
                    return $row->total_value - $row->shipment_value ;
                })
                ->with('total_orders_count', $totalOrdersCount)
                ->with('total_orders_value', $totalOrdersValue)
                ->with('total_orders_shipment', $totalOrdersShipment)
                // ->with('total_delivery_value', $totalDeliveryValue)
                ->with('total_sum', $totalSum)
                ->escapeColumns([])
                ->make(true);
            return $dataTable;
        }

        return view('Admin.reports.profits.trader');
    }
}
//