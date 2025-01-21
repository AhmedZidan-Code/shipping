<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Trader;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TraderReportsController extends Controller
{
    use LogActivityTrait;

    function __construct()
    {
        //  $this->middleware('permission:عرض التقارير', ['only' => ['index']]);
    }


    public function index(Request $request)
    {
        $traders = Trader::get();

        $shipment_pieces_number = 0;

        if ($request->ajax()) {
            $rows = Order::query()->latest()->with(['province', 'trader', 'delivery']);
            $condition = [];

            if ($request->fromDate) {
                $rows->where('created_at', '>=', $request->fromDate . ' ' . '00:00:00');

                $condition['created_at >='] = $request->fromDate . ' ' . '00:00:00';
            }
            if ($request->toDate) {
                $rows->where('created_at', '<=', $request->toDate . ' ' . '23:59:59');

                $condition['created_at <='] = $request->toDate . ' ' . '23:59:59';
            }
            if ($request->trader_id) {
                $rows->where('trader_id', $request->trader_id);
                $condition['trader_id'] = $request->trader_id;
            }
            if ($request->status) {
                $rows->where('status', $request->status);

                $condition['status'] = $request->status;
            }





            $dataTable = DataTables::of($rows)



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

                            <button ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </span>
                            </button>

                            <a href=' . $url . ' class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>

                          <a href=' . $route . ' class="btn rounded-pill btn-outline-dark"><i class="fa fa-edit" aria-hidden="true"></i></a>

                       ';
                })


                ->editColumn('status', function ($row) {
                    // paid_as_money     paid_as_mortag3
                    $status = '';
                    if ($row->status == 'new')
                        $status =  '<button class="btn btn-primary"> طلب جديد </button>';
                    elseif ($row->status == 'converted_to_delivery')
                        $status =  '<button class="btn btn-success"> محول الي المندوب  </button>';
                    elseif ($row->status == 'total_delivery_to_customer' && $row->paid_as_money == 0)

                        $status =  '<button class="btn btn-success"> مسلم كليا  </button>';
                    elseif ($row->status == 'total_delivery_to_customer' && $row->paid_as_money == 1)

                        $status =  '<button class="btn btn-success"> تم التحصيل  </button>';
                    elseif ($row->status == 'partial_delivery_to_customer'  && $row->paid_as_mortag3 == 0  && $row->paid_as_money == 0)

                        $status =  '<button class="btn  btn-info"> مسلم جزئيا  </button>';
                    elseif ($row->status == 'partial_delivery_to_customer'  && $row->paid_as_mortag3 == 1  && $row->paid_as_money == 0)

                        $status =  '<button class="btn  btn-danger"> تم كمرتجع  </button>';

                    elseif ($row->status == 'partial_delivery_to_customer'  && $row->paid_as_mortag3 == 0  && $row->paid_as_money == 1)
                        // $status='طلب تم التحصيل';
                        $status =  '<button class="btn  btn-success"> تم كتحصيل  </button>';
                    elseif ($row->status == 'partial_delivery_to_customer'  && $row->paid_as_mortag3 == 1 && $row->paid_as_money == 1)
                        $status =  '<button class="btn  btn-success"> تم كمرتجع وتحصيل </button>';
                    elseif ($row->status == 'not_delivery' && $row->paid_as_mortag3 == 0)
                        $status =  '<button class="btn  btn-warning"> لم يسلم </button>';
                    elseif ($row->status == 'not_delivery' && $row->paid_as_mortag3 == 1)
                        $status =  '<button class="btn  btn-danger"> تم كمرتجع  </button>';
                    elseif ($row->status == 'under_implementation')
                        $status =  '<button class="btn  btn-warning"> تحت التنفيذ  </button>';
                    elseif ($row->status == 'cancel' && $row->paid_as_mortag3 == 0)
                        $status =  '<button class="btn  btn-danger"> ملغي  </button>';
                    elseif ($row->status == 'cancel' && $row->paid_as_mortag3 == 1)
                        $status =  '<button class="btn  btn-danger"> تم كمرتجع  </button>';
                    elseif ($row->status == 'delaying')

                        $status =  '<button class="btn  btn-warning"> مؤجل  </button>';
                    elseif ($row->status == 'collection')
                        $status =  '<button class="btn btn-success"> محصل </button>';
                    elseif ($row->status == 'paid')
                        $status =  '<button class="btn btn-success"> مدفوع  </button>';
                    elseif ($row->status == 'shipping_on_messanger')
                        $status =  '<button class="btn btn-success"> الشحن علي الراسل  </button>';
                    else
                        $status = 'لم يحدد';

                    return $status;
                })

                ->editColumn('address', function ($data) {
                    $link = "https://www.google.com/maps/search/?api=1&query=" . $data->latitude . "," . $data->longitude;
                    return '<a target="_blank" class="btn btn-pill btn-info" href="' . $link . '"> عرض <i class="fa fa-map-marker-alt text-white"></i>  </a>';
                })
                ->editColumn('trader_id', function ($row) {
                    return  $row->trader->name ?? '';
                })






                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->editColumn('converted_date', function ($admin) {
                    return date('Y/m/d', strtotime($admin->converted_date));
                })

                ->with('total2', function () use ($rows) {
                    return $rows->sum('shipment_value');
                })
                ->escapeColumns([])
                ->make(true);


            return  $dataTable;
        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  تقارير التجار  ");
        }

        $rows = Order::query()->latest()->with(['province', 'trader', 'delivery']);

        if ($request->fromDate) {
            $rows->where('delivery_time', '>=', $request->fromDate . ' ' . '00:00:00');
        }
        if ($request->toDate) {
            $rows->where('delivery_time', '<=', $request->toDate . ' ' . '23:59:59');
        }
        if ($request->trader_id) {
            $rows->where('trader_id', $request->trader_id);
        }
        if ($request->status) {
            $rows->where('status', $request->status);
        }
        $shipment_pieces_number = $rows->sum('shipment_pieces_number');
        $shipment_value = $rows->sum('shipment_value');
        $delivery_value = $rows->sum('delivery_value');
        $total_value = $rows->sum('total_value');
        $delivery_ratio = $rows->sum('delivery_ratio');
        $delivery_ratio_val = $delivery_ratio * $total_value / 100;

        return view('Admin.reports.traders.index', compact('request', 'traders', 'shipment_pieces_number', 'shipment_value', 'delivery_value', 'total_value', 'delivery_ratio', 'delivery_ratio_val'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $old = $order;
        $order->delete();

        $this->add_log_activity($old, auth('admin')->user(), " تم   حذف بيانات الطلب    $old->id ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }
}
