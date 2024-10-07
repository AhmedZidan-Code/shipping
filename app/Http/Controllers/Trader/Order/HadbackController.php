<?php

namespace App\Http\Controllers\Trader\Order;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Trader;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HadbackController extends Controller
{
    use LogActivityTrait;

    public function index(Request $request)
    {
        $trader = auth('trader')->user();

        $shipment_pieces_number = 0;
        $statusArray = array('cancel', 'not_delivery', 'partial_delivery_to_customer', 'shipping_on_messanger');
        if ($request->ajax()) {
            $rows = Order::query()->where('trader_id', $trader->id)->with(['province', 'trader', 'delivery'])->whereIn('status', $statusArray)->where('paid_as_mortag3', 0)->orderBy('converted_date', 'desc');
            $condition = [];

            if ($request->fromDate) {
                $rows->where('converted_date', '>=', $request->fromDate . ' ' . '00:00:00');

                $condition['converted_date >='] = $request->fromDate . ' ' . '00:00:00';
            }
            if ($request->toDate) {
                $rows->where('converted_date', '<=', $request->toDate . ' ' . '23:59:59');

                $condition['converted_date <='] = $request->toDate . ' ' . '23:59:59';

            }

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
                    if ($row->status == 'new') {
                        $status = 'طلب جديد';
                        $class = 'btn btn-info';
                    } elseif ($row->status == 'converted_to_delivery') {
                        $status = 'طلب محول الي المندوب';
                        $class = 'btn btn-info';
                    } elseif ($row->status == 'total_delivery_to_customer') {
                        $status = 'طلب مسلم كليا';
                        $class = 'btn btn-success';
                    } elseif ($row->status == 'partial_delivery_to_customer') {
                        $status = 'طلب مسلم جزئيا';
                        $class = 'btn btn-warning';
                    } elseif ($row->status == 'not_delivery') {
                        $class = 'btn btn-warning';
                        $status = 'عدم استلام';
                    } elseif ($row->status == 'under_implementation') {
                        $status = 'تحت التنفيذ';
                        $class = 'btn btn-warning';
                    } elseif ($row->status == 'cancel') {
                        $status = 'لاغي';
                        $class = 'btn btn-danger';
                    } elseif ($row->status == 'delaying') {
                        $status = 'طلب مؤجل';
                        $class = 'btn btn-danger';
                    } elseif ($row->status == 'collection') {
                        $status = 'طلب محصل';
                        $class = 'btn btn-success';
                    } elseif ($row->status == 'paid') {
                        $status = 'مدفوع';
                        $class = 'btn btn-success';
                    } elseif ($row->status == 'shipping_on_messanger') {
                        $status = 'شحن علي الراسل';
                        $class = 'btn btn-success';
                    } else {
                        $status = 'لم يحدد';
                        $class = '';
                    }

                    return '<button class="' . $class . '"> ' . $status . ' </button>';

                })

                ->editColumn('address', function ($data) {
                    $link = "https://www.google.com/maps/search/?api=1&query=" . $data->latitude . "," . $data->longitude;
                    return '<a target="_blank" class="btn btn-pill btn-info" href="' . $link . '"> عرض <i class="fa fa-map-marker-alt text-white"></i>  </a>';
                })
                ->editColumn('trader_id', function ($row) {
                    return $row->trader->name ?? '';
                })
                ->editColumn('shipment_value', function ($row) {
                    if ($row->status == 'partial_delivery_to_customer') {
                        return $row->total_value - $row->partial_value;
                    } else if ($row->status == 'shipping_on_messanger') {
                        return -$row->delivery_value;
                    } else {

                        return $row->shipment_value;
                    }
                })

                ->editColumn('total_value', function ($row) {
                    if ($row->status == 'partial_delivery_to_customer') {
                        return ($row->shipment_value - $row->partial_value) + $row->delivery_value;
                    } else {
                        return $row->total_value;
                    }
                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->editColumn('converted_date', function ($admin) {
                    return date('Y/m/d', strtotime($admin->converted_date));
                })

                ->with('total2', function () use ($totalShipmentValue) {
                    return $totalShipmentValue;
                })
                ->escapeColumns([])
                ->make(true);

            return $dataTable;

        } else {
            $this->add_log_activity(null, auth('trader')->user(), "تم عرض  تقارير التجار  ");

        }

        return view('Trader.Orders.hadback.index', compact('request'));

    }

    public function get_hadback(Request $request)
    {

        $trader = auth('trader')->user();
        $statusArray = ['cancel', 'not_delivery', 'partial_delivery_to_customer', 'shipping_on_messanger'];

        if ($request->ajax()) {
            $rows = Order::query()->where('trader_id', $trader->id)->latest()->with(['province', 'trader', 'delivery'])
                ->whereIn('status', $statusArray)
                ->where('paid_as_mortag3', 1)->orderBy('converted_date', 'desc');

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
                ->with('total2', function () use ($totalShipmentValue) {
                    return $totalShipmentValue;
                })
                ->escapeColumns([])
                ->make(true);

            return $dataTable;
        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض تقارير التجار");

            return view('Trader.Orders.hadback.get_hadback', compact('request'));
        }
    }
}
