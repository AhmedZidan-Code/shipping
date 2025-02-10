<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Trader;
use App\Models\TraderPayments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TahseelController extends Controller
{
    use LogActivityTrait;

    public $statusArray = array('total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger');

    public function __construct()
    {
        $this->middleware('permission:عرض طلبات قيد التحصيل')->only(['index']);
        $this->middleware('permission:تعديل طلبات قيد التحصيل')->only(['edit', 'update']);
        $this->middleware('permission:حذف طلبات قيد التحصيل')->only('destroy');
    }

    public function index(Request $request)
    {
        $traders = Trader::get();

        $shipment_pieces_number = 0;

        if ($request->ajax()) {
            $rows = Order::query()->with(['province', 'trader', 'delivery'])->whereIn('status', $this->statusArray)->where('paid_as_money', 0)->orderBy('converted_date', 'desc');
            $condition = [];

            if ($request->fromDate) {
                $rows->where('converted_date', '>=', $request->fromDate . ' ' . '00:00:00');

                $condition['converted_date >='] = $request->fromDate . ' ' . '00:00:00';
            }
            if ($request->toDate) {
                $rows->where('converted_date', '<=', $request->toDate . ' ' . '23:59:59');

                $condition['converted_date <='] = $request->toDate . ' ' . '23:59:59';
            }
            if ($request->trader_id) {
                $rows->where('trader_id', $request->trader_id);
                $condition['trader_id'] = $request->trader_id;
            }
            if ($request->status) {
                $rows->where('status', $request->status);

                $condition['status'] = $request->status;
            }

            $totalShipmentValue1 = $rows->get()->sum(function ($row) {
                if ($row->status == 'partial_delivery_to_customer') {
                    return ($row->partial_value - $row->delivery_value);
                } else if ($row->status == 'shipping_on_messanger') {
                    return 0;
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

                ->addColumn('checkbox', function ($row) {
                    $change_status = '';
                    if ($row->status == 'partial_delivery_to_customer') {
                        $data = $row->partial_value - $row->delivery_value;
                    } elseif ($row->status == 'shipping_on_messanger') {
                        $data = -$row->delivery_value;
                    } else {
                        $data = $row->shipment_value;
                    }

                    return '<input  type="checkbox" class="myCheckboxClass orders_ids" data_base="' . $data . '" value="' . $row->id . '";  name="check" ' . $change_status . '/>';
                })
                ->editColumn('province_id', function ($row) {
                    return $row->province->title ?? '';
                })
                ->editColumn('delivery_id', function ($row) {
                    return $row->delivery->name ?? '';
                })
                ->addColumn('orderDetails', function ($row) {
                    $edit = '';
                    $delete = '';

                    $url = route('admin.orderDetails', $row->id);

                    $route = route('orders.edit', $row->id);

                    return '



                            <a href=' . $url . ' class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>

                          <a href=' . $route . ' class="btn rounded-pill btn-outline-dark"><i class="fa fa-edit" aria-hidden="true"></i></a>

                       ';
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
                        $status = 'طلب لم يسلم';
                    } elseif ($row->status == 'under_implementation') {
                        $status = 'تحت التنفيذ';
                        $class = 'btn btn-warning';
                    } elseif ($row->status == 'cancel') {
                        $status = 'طلب ملغي';
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
                        return $row->partial_value - $row->delivery_value;
                    } else if ($row->status == 'shipping_on_messanger') {
                        return -$row->delivery_value;
                    } else {
                        return $row->shipment_value;
                    }
                })

                ->editColumn('total_value', function ($row) {
                    if ($row->status == 'partial_delivery_to_customer') {
                        return $row->partial_value;
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
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  تقارير التجار  ");
        }

        return view('Admin.CRUDS.Orders.tahseel.index', compact('request', 'traders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'selectedValues' => 'required',
            'orders_count' => 'required',
            'total_balance' => 'required',
            'trader_id' => 'required|exists:traders,id',
            'date' => 'required|date',
            'cash' => 'required',
            'cheque' => 'required',
            'notes' => 'nullable',
        ]);

        $sum = $request->cash + $request->cheque;
        if ($sum > $request->total_balance) {
            return response()->json([
                'code' => 422,
                'message' => 'لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ',
                'errors' => [
                    'sum' => ['لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ'],
                ],
            ], 422);
        }

        $traderPayment = TraderPayments::create([
            'trader_id' => $data['trader_id'],
            'orders_count' => $data['orders_count'],
            'total_balance' => $data['total_balance'],
            'date' => $data['date'],
            'cash' => $data['cash'],
            'notes' => $data['notes'],
            'cheque' => $data['cheque'],
            'amount' => $data['cheque'] + $data['cash'],
        ]);
        if (isset($request->selectedValues) && !empty($request->selectedValues)) {
            $count = count($request->selectedValues);

            for ($x = 0; $x < $count; $x++) {

                $data_update['paid_as_money'] = 1;
                $data_update['converted_date'] = Carbon::now()->format('Y-m-d H:i:s');
                $data_update['converted_date_s'] = strtotime(Carbon::now()->format('Y-m-d H:i:s'));
                Order::where('id', $request->selectedValues[$x])->update($data_update + ['paid_id' => $traderPayment->id]);
            }
        }

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    //===============================================================================

    public function get_tahseel(Request $request)
    {
        $traders = Trader::get();
        $shipment_pieces_number = 0;

        if ($request->ajax()) {
            $rows = Order::query()->latest()->with(['province', 'trader', 'delivery'])
                ->whereIn('status', $this->statusArray)
                ->where('paid_as_money', 1)->orderBy('converted_date', 'desc');

            $condition = [];

            if ($request->fromDate) {
                $rows->where('converted_date', '>=', $request->fromDate . ' 00:00:00');
                $condition['converted_date >='] = $request->fromDate . ' 00:00:00';
            }
            if ($request->toDate) {
                $rows->where('converted_date', '<=', $request->toDate . ' 23:59:59');
                $condition['converted_date <='] = $request->toDate . ' 23:59:59';
            }
            if ($request->trader_id) {
                $rows->where('trader_id', $request->trader_id);
                $condition['trader_id'] = $request->trader_id;
            }
            if ($request->status) {
                $rows->where('status', $request->status);
                $condition['status'] = $request->status;
            }

            $totalShipmentValue1 = $rows->get()->sum(function ($row) {
                if ($row->status == 'partial_delivery_to_customer') {
                    return ($row->partial_value - $row->delivery_value);
                } else if ($row->status == 'shipping_on_messanger') {
                    return 0;
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
                ->addColumn('orderDetails', function ($row) {
                    $url = route('admin.orderDetails', $row->id);
                    $route = route('orders.edit', $row->id);

                    return '<a href=' . $url . ' class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a href=' . $route . ' class="btn rounded-pill btn-outline-dark"><i class="fa fa-edit" aria-hidden="true"></i></a>';
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
                            $status = 'طلب لم يسلم';
                            $class = 'btn btn-warning';
                            break;
                        case 'under_implementation':
                            $status = 'تحت التنفيذ';
                            $class = 'btn btn-warning';
                            break;
                        case 'cancel':
                            $status = 'طلب ملغي';
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
                            break;
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
                //  ->editColumn('shipment_value', function ($row) {
                //    return $row->status == 'partial_delivery_to_customer' ? $row->partial_value - $row->delivery_value : $row->shipment_value;
                // })
                ->editColumn('shipment_value', function ($row) {
                    if ($row->status == 'partial_delivery_to_customer') {
                        return $row->partial_value - $row->delivery_value;
                    } else if ($row->status == 'shipping_on_messanger') {
                        return -$row->delivery_value;
                    } else {
                        return $row->shipment_value;
                    }
                })




                ->editColumn('total_value', function ($row) {
                    return $row->status == 'partial_delivery_to_customer' ? $row->partial_value : $row->total_value;
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

            return view('Admin.CRUDS.Orders.tahseel.get_tahseel', compact('request', 'traders'));
        }
    }
}
