<?php

namespace App\Http\Controllers\Trader\Order;

use App\Exports\OrderFormExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Imports\OrderImport;
use App\Models\Area;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Trader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class NewOrderController extends Controller
{
    use LogActivityTrait;

    public function index(Request $request)
    {
        $trader = auth('trader')->user();

        if ($request->ajax()) {
            $admins = Order::query()->where('trader_id', $trader->id)->with(['province', 'trader'])->where('status', 'new')->orderBy('updated_at', 'desc');
            return DataTables::of($admins)
                ->editColumn('province_id', function ($row) {
                    return $row->province->title ?? '';
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

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الطلبات  الجديدة");

        }
        return view('Trader.Orders.newOrders.index');
    }

}
