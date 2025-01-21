<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Trader;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
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

    // Initialize variable (seems unused in current code)
    $shipment_pieces_number = 0;
      $condition_mandoub =array();
    if ($request->ajax()) {
        $start = date('Y-m-d') . ' 00:00:00';
        $end = date('Y-m-d') . ' 23:59:59';
        if($request->delivery_id)
        {
            $condition_mandoub['deliveries.id']= $request->delivery_id ;
        }
         if ($request->fromDate) {
            $condition_mandoub[] = ['orders.converted_date', '>=', $request->fromDate . ' 00:00:00'];
        } else {
           // $condition_mandoub[] = ['orders.converted_date', '>=', $start];
        }

        if ($request->toDate) {
            $condition_mandoub[] = ['orders.converted_date', '<=', $request->toDate . ' 23:59:59'];
        } else {
          //  $condition_mandoub[] = ['orders.converted_date', '<=', $end];
        }
      

        $rows = DB::table('deliveries')
            ->leftJoin('orders', 'deliveries.id', '=', 'orders.delivery_id')
            ->select(
                'deliveries.id as id',
                'deliveries.name',
                
                DB::raw('COUNT(orders.id) as total_orders_count')
            )
            ->where('orders.status', 'converted_to_delivery')
            ->where($condition_mandoub)
            ->groupBy('deliveries.id', 'deliveries.name') // No need to group by orders.id
            ->orderBy('deliveries.id', 'asc');

         $total_orders_count = $rows->get()->sum(function ($row) {
               return $row->total_orders_count;
            });
        $dataTable = DataTables::of($rows)
            ->editColumn('name', function ($row) {
                return $row->name ?? '';
            })
            ->addColumn('orderDetails', function ($row) use ($request) {
                $url = route('todayOrdersReports.details', [
                    'delivery_id' => $row->id,
                    'fromDate' => $request->fromDate,
                    'toDate' => $request->toDate,
                ]);
                return "<a href='$url' class='btn btn-outline-dark'> التفاصيل</a>";
            })
            ->with([
                'total' => function () use ($total_orders_count) {
                    // Aggregate the total number of orders
                    return $total_orders_count;
                },
            ])
            ->escapeColumns([]); // Don't escape columns that need HTML rendering

        return $dataTable->make(true);
    } else {
        // Log activity for non-AJAX requests
        $this->add_log_activity(null, auth('admin')->user(), "تم عرض  تقارير يومية الطلبات  ");
    }

    // Fetch deliveries for view rendering
    $delivieries = Delivery::where('deleted_at',null)->get();
   
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
                $rows->where('converted_date', '>=', $request->fromDate . ' ' . '00:00:00');
            }
            if ($request->toDate) {
                $rows->where('converted_date', '<=', $request->toDate . ' ' . '23:59:59');
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
