<?php

namespace App\Http\Controllers\Trader\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TraderOrderController extends Controller
{
        public function index(Request $request)
    {

        $trader = auth('trader')->user();

        if ($request->ajax()) {
            $rows = Order::query()->where('trader_id', $trader->id)->latest()->with(['province', 'trader', 'delivery'])->orderBy('created_at', 'desc');

            $totalShipmentValue1 = $rows->get()->sum(function ($row) {
                if ($row->status == 'partial_delivery_to_customer') {
                    return ($row->total_value - $row->partial_value);
                } else {
                    return $row->shipment_value;
                }
            });

            $totalShipmentValue2 = $rows->get()->sum(function ($row) {
                if ($row->status == 'shipping_on_messanger') {
                    return $row->delivery_value;
                }
            });

            $totalShipmentValue = $totalShipmentValue1 - $totalShipmentValue2;

            $dataTable = DataTables::of($rows)
                ->editColumn('province_id', function ($row) {
                    return $row->province->title ?? '';
                })
                ->editColumn('delivery_id', function ($row) {
                    return $row->delivery->name ?? '';
                })
                ->editColumn('status', function ($row) {
                    $status = '';
                    $class = '';

                    switch ($row->status) {
                        case 'new':
                            $status = 'طلب جديد';
                            $class = 'btn btn-info';
                            break;
                        case 'converted_to_delivery':
                            $status = 'طلب محول الي المندوب';
                            $class = 'btn btn-info';
                            break;
                        case 'total_delivery_to_customer':
                            $status = 'طلب مسلم كليا';
                            $class = 'btn btn-success';
                            break;
                        case 'partial_delivery_to_customer':
                            $status = 'طلب مسلم جزئيا';
                            $class = 'btn btn-warning';
                            break;
                        case 'not_delivery':
                            $status = 'عدم استلام';
                            $class = 'btn btn-warning';
                            break;
                        case 'under_implementation':
                            $status = 'تحت التنفيذ';
                            $class = 'btn btn-warning';
                            break;
                        case 'cancel':
                            $status = 'لاغي';
                            $class = 'btn btn-danger';
                            break;
                        case 'delaying':
                            $status = 'طلب مؤجل';
                            $class = 'btn btn-danger';
                            break;
                        case 'collection':
                            $status = 'طلب محصل';
                            $class = 'btn btn-success';
                            break;
                        case 'paid':
                            $status = 'مدفوع';
                            $class = 'btn btn-success';
                            break;
                        case 'shipping_on_messanger':
                            $status = 'شحن علي الراسل';
                            $class = 'btn btn-success';
                            break;
                        default:
                            $status = 'لم يحدد';
                            $class = '';
                            break;
                    }

                    return '<button class="' . $class . '"> ' . $status . ' </button>';
                })
                ->editColumn('address', function ($data) {
                    $link = "https://www.google.com/maps/search/?api=1&query=" . $data->latitude . "," . $data->longitude;
                    return '<a target="_blank" class="btn btn-pill btn-info" href="' . $link . '"> عرض <i class="fa fa-map-marker-alt text-white"></i> </a>';
                })
                ->editColumn('shipment_value', function ($row) {
                    if ($row->status == 'partial_delivery_to_customer') {
                        return $row->total_value - $row->partial_value;
                    } elseif ($row->status == 'shipping_on_messanger') {
                        return -$row->delivery_value; // Replace with the actual logic for your else if condition
                    } else {
                        return $row->shipment_value;
                    }

                    //return $row->status == 'partial_delivery_to_customer' ? $row->total_value - $row->partial_value : $row->shipment_value;
                })
                ->editColumn('total_value', function ($row) {
                    return $row->status == 'partial_delivery_to_customer' ? ($row->shipment_value - $row->partial_value) + $row->delivery_value : $row->total_value;
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->editColumn('converted_date', function ($admin) {
                    return date('Y/m/d', strtotime($admin->converted_date));
                })
                ->escapeColumns([])
                ->make(true);

            return $dataTable;
        } else {

            return view('Trader.Orders.trader_orders.index', compact('request'));
        }
    }
}
