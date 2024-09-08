<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Area;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Trader;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DeliveryReportsController extends Controller
{
    use LogActivityTrait;

    function __construct()
    {
      //  $this->middleware('permission:عرض التقارير', ['only' => ['index']]);
    }


    public function index(Request $request)
    {

        $deliveries=Delivery::get();

        $shipment_pieces_number=0;

        if ($request->ajax()) {
            $rows = Order::query()->latest()->with(['province','trader','delivery']);

            if ($request->fromDate){
                $rows->where('created_at','>=',$request->fromDate.' '.'00:00:00');
            }
            if ($request->toDate){
                $rows->where('created_at','<=',$request->toDate.' '.'23:59:59');

            }
            if ($request->delivery_id){
               $rows->where('delivery_id',$request->delivery_id);
            }
            if ($request->status){
                $rows->where('status',$request->status);

            }



             $dataTable= DataTables::of($rows)



                ->editColumn('province_id', function ($row) {
                    return $row->province->title??'';
                })


                ->editColumn('delivery_id', function ($row) {
                    return $row->delivery->name??'';
                })
                ->addColumn('orderDetails', function ($row) {
                    $edit = '';
                    $delete = '';

                    $url=route('admin.orderDetails',$row->id);

                    $route=route('orders.edit',$row->id);

                    return '

                            <button ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </span>
                            </button>

                            <a href='.$url.' class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>

                          <a href='.$route.' class="btn rounded-pill btn-outline-dark"><i class="fa fa-edit" aria-hidden="true"></i></a>

                       ';

                })


                ->editColumn('status', function ($row) {

                    $status='';
                    if ($row->status=='new')
                        $status= 'طلب جديد';
                    elseif ($row->status=='converted_to_delivery')
                        $status='طلب محول الي المندوب';
                    elseif ($row->status=='total_delivery_to_customer')
                        $status='طلب مسلم كليا';
                    elseif ($row->status=='partial_delivery_to_customer')
                        $status='طلب مسلم جزئيا';
                    elseif ($row->status=='not_delivery')
                        $status='طلب لم يسلم';
                    elseif ($row->status=='under_implementation')
                        $status='تحت التنفيذ';
                    elseif ($row->status=='cancel')
                        $status='طلب ملغي';
                    elseif ($row->status=='delaying')
                        $status='طلب مؤجل';
                    elseif ($row->status=='collection')
                        $status='طلب محصل';
                    elseif ($row->status=='paid')
                        $status='مدفوع';
                    else
                        $status='لم يحدد';

                    return $status;

                })

                    ->editColumn('address', function ($data) {
                    $link = "https://www.google.com/maps/search/?api=1&query=".$data->latitude.",".$data->longitude;
                    return '<a target="_blank" class="btn btn-pill btn-info" href="'.$link.'"> عرض <i class="fa fa-map-marker-alt text-white"></i>  </a>';
                })
                ->editColumn('trader_id', function ($row) {
                    return  $row->trader->name??'';
                })




                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


            return  $dataTable ;

        }
        else{
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  تقارير المناديب  ");

        }

        $rows = Order::query()->latest()->with(['province','trader','delivery']);

        if ($request->fromDate){
            $rows->where('delivery_time','>=',$request->fromDate.' '.'00:00:00');
        }
        if ($request->toDate){
            $rows->where('delivery_time','<=',$request->toDate.' '.'23:59:59');

        }
        if ($request->delivery_id){
            $rows->where('delivery_id',$request->delivery_id);
        }
        if ($request->status){
            $rows->where('status',$request->status);

        }
                    $shipment_pieces_number=$rows->sum('shipment_pieces_number');
                    $shipment_value=$rows->sum('shipment_value');
                    $delivery_value=$rows->sum('delivery_value');
                    $total_value=$rows->sum('total_value');
                    $delivery_ratio=$rows->sum('delivery_ratio');
                    $delivery_ratio_val=$delivery_ratio*$total_value/100;

        return view('Admin.reports.deliveries.index',compact('request','deliveries','shipment_pieces_number','shipment_value','delivery_value','total_value','delivery_ratio','delivery_ratio_val'));
    }



}
