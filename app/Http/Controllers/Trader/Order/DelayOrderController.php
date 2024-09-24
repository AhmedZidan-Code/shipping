<?php

namespace App\Http\Controllers\Trader\Order;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DelayOrderController extends Controller
{
    //
    use LogActivityTrait;
    
    public function index(Request $request)
    {
        $trader = auth('trader')->user();

        if ($request->ajax()) {
            $admins = Order::query()->where('trader_id', $trader->id)->with(['province', 'trader', 'delivery'])->where('status', 'delaying')->orderBy('updated_at', 'desc');
            return DataTables::of($admins)
                ->editColumn('province_id', function ($row) {
                    return $row->province->title ?? '';
                })
                ->editColumn('address', function ($data) {
                    $link = "https://www.google.com/maps/search/?api=1&query=" . $data->latitude . "," . $data->longitude;
                    return '<a target="_blank" class="btn btn-pill btn-info" href="' . $link . '"> عرض <i class="fa fa-map-marker-alt text-white"></i>  </a>';
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })

                ->editColumn('status', function ($row) {

                    $status = '';
                    $data = '';

                    if ($row->status == 'converted_to_delivery') {
                        $data = 'محول الي مندوب';
                    }

                    if ($row->status == 'total_delivery_to_customer') {
                        $data = 'تم التسليم';
                    }

                    if ($row->status == 'partial_delivery_to_customer') {
                        $data = 'تسليم جزئي';
                    }

                    if ($row->status == 'not_delivery') {
                        $data = 'عدم استلام';
                    }

                    if ($row->status == 'paid') {
                        $data = 'تم الدفع';
                    }

                    if ($row->status == 'collection') {
                        $data = 'تحصيل';
                    }

                    if ($row->status == 'delaying') {
                        $data = 'مؤجل';
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
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('trader')->user(), "تم عرض  الطلبات الملغاة ");

        }
        return view('Trader.Orders.cancelOrders.index');
    }
}
