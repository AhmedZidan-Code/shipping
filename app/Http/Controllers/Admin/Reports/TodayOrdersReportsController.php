<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Trader;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TodayOrdersReportsController extends Controller
{
    use LogActivityTrait;
    protected $total;
    public function __construct()
    {
        $this->middleware('permission:عرض يومية الطلبات')->only(['index']);
    }

    public function index(Request $request)
    {
        $shipment_pieces_number = 0;

        if ($request->ajax()) {
            $start = date('Y-m-d') . ' ' . '00:00:00';
            $end = date('Y-m-d') . ' ' . '23:59:59';

            $rows = Delivery::query()->latest()->whereHas('orders', function ($q) use ($request, $start, $end) {

                $q->where('status', 'converted_to_delivery');

            })->withCount(['orders as total_orders_count' => function ($query) use ($request, $start, $end) {
                $query->where('status', 'converted_to_delivery');
                if ($request->fromDate) {
                    $query->whereDate('created_at', '<=', $request->fromDate);
                }

                if ($request->toDate) {
                    $query->whereDate('created_at', '>=', $request->toDate);
                }
            }]);
            if ($request->delivery_id) {
                $rows->where('id', $request->delivery_id) /*->whereDate(DB::raw('DATE(converted_date)'), today())*/;
            }

            $dataTable = DataTables::of($rows)

                ->editColumn('name', function ($row) {
                    return $row->name ?? '';
                })
                ->addColumn('orderDetails', function ($row) use ($request) {
                    $url = route('todayOrdersReports.details', ['delivery_id' => $row->id, 'fromDate' => $request->fromDate, 'toDate' => $request->toDate]);
                    return "<a href='$url' class='btn btn-outline-dark'> التفاصيل</a>";
                })
                ->with([
                    'total' => function () use ($rows) {
                        return $rows->get()->sum('total_orders_count');
                    },
                ])
                ->escapeColumns([])
                ->make(true);

            return $dataTable;

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  تقارير يومية الطلبات  ");

        }
        $delivieries = Delivery::whereHas('orders', function ($q) {$q->where('status', 'converted_to_delivery');})->get();

        return view('Admin.reports.todayOrders.index', compact('request', 'delivieries'));

    }

    public function details(Request $request)
    {
        $traders = Trader::get();

        $shipment_pieces_number = 0;
        if ($request->ajax()) {
            $start = date('Y-m-d') . ' ' . '00:00:00';
            $end = date('Y-m-d') . ' ' . '23:59:59';

            $rows = Order::query()->where('status', 'converted_to_delivery')->latest()->with(['province', 'trader', 'delivery']);
            if ($request->delivery_id) {
                $rows->where('delivery_id', $request->delivery_id);
            }
            if ($request->fromDate) {
                $rows->where('created_at', '<=', $request->fromDate . ' ' . '00:00:00');

            }
            if ($request->toDate) {
                $rows->where('created_at', '>=', $request->toDate . ' ' . '23:59:59');

            }

            $dataTable = DataTables::of($rows)

                ->editColumn('province_id', function ($row) {
                    return $row->province->title ?? '';
                })

                ->editColumn('delivery_id', function ($row) {
                    return $row->delivery->name ?? '';
                })
                ->addColumn('orderDetails', function ($row) {
                    $url = route('admin.orderDetails', $row->id);
                    return "<a href='$url' class='btn btn-outline-dark'>تفاصيل الطلب</a>";
                })

                ->editColumn('status', function ($row) {

                    $status = '';
                    if ($row->status == 'new') {
                        $status = 'طلب جديد';
                    } elseif ($row->status == 'converted_to_delivery') {
                        $status = 'طلب محول الي المندوب';
                    } elseif ($row->status == 'total_delivery_to_customer') {
                        $status = 'طلب مسلم كليا';
                    } elseif ($row->status == 'partial_delivery_to_customer') {
                        $status = 'طلب مسلم جزئيا';
                    } elseif ($row->status == 'not_delivery') {
                        $status = 'طلب لم يسلم';
                    } else {
                        $status = 'لم يحدد';
                    }

                    return $status;

                })

                ->editColumn('address', function ($data) {
                    $link = "https://www.google.com/maps/search/?api=1&query=" . $data->latitude . "," . $data->longitude;
                    return '<a target="_blank" class="btn btn-pill btn-info" href="' . $link . '"> عرض <i class="fa fa-map-marker-alt text-white"></i>  </a>';
                })
                ->editColumn('trader_id', function ($row) {
                    return $row->trader->name ?? '';
                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);

            return $dataTable;

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  تقارير يومية الطلبات  ");

        }
        // $delivieries = Delivery::whereHas('orders', function ($q) {$q->where('status', 'converted_to_delivery');})->get();

        return view('Admin.reports.todayOrders.details', compact('request', 'traders', 'shipment_pieces_number'));

    }

}
