<?php

namespace App\Http\Controllers\Trader\Order;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DeliveryConvertedOrderController extends Controller
{
    use LogActivityTrait;

    public function index(Request $request)
    {
        $trader = auth('trader')->user();

        if ($request->ajax()) {

            $rows = Order::query()->where('trader_id', $trader->id)->with(['province', 'trader', 'delivery'])
                ->where('status', 'converted_to_delivery')->orderBy('converted_date', 'desc');
           

            if ($request->delivery_id) {
                $rows->where('delivery_id', $request->delivery_id);
            }
            if ($request->province_id) {
                $rows->where('province_id', $request->province_id);
            }

            return DataTables::of($rows)
              
                ->editColumn('province_id', function ($row) {
                    return $row->province->title ?? '';
                })
                ->addColumn('orderDetails', function ($row) {
                    $url = route('admin.orderDetails', $row->id);
                    return "<a href='$url' class='btn btn-outline-dark'><i class='fa fa-eye' aria-hidden='true'></i></a>";
                })

                ->addColumn('residual', function ($row) {
                    return '';
                })

                ->editColumn('status', function ($row) {

                    $status = '';
                    $data = '';

                    if ($row->status == 'converted_to_delivery') {
                        $data = 'محول الي مندوب';
                    }

                    if ($row->status == 'total_delivery_to_customer') {
                        $data = 'التسليم';
                    }

                    if ($row->status == 'partial_delivery_to_customer') {
                        $data = 'تسليم جزئي';
                    }

                    if ($row->status == 'not_delivery') {
                        $data = 'عدم استلام';
                    }

                    if ($row->status == 'total_delivery_to_customer') {
                        $data = 'تم الدفع';
                    }

                    if ($row->status == 'collection') {
                        $data = 'تحصيل';
                    }

                    if ($row->status == 'delaying') {
                        $data = 'ماجل';
                    }

                    if ($row->status == 'cancel') {
                        $data = 'لاغي';
                    }

                    if ($row->status == 'under_implementation') {
                        $data = 'تحت التنفيذ';
                    }

                    return "<button $status  data-id='$row->id' class='btn btn-success '>  $data

                </button>";

                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->with('total_sum', function() use ($rows) {
                    return $rows->sum('total_value');
                })  
                ->escapeColumns([])

                ->make(true);

        } else {
            $this->add_log_activity(null, auth('trader')->user(), "تم عرض  الطلبات المحولة للمناديب");

        }
        $delivieries = DB::table('deliveries')->get();

        return view('Trader.Orders.deliveryConvertedOrders.index', compact('delivieries'));
    }

}
