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

class MandoubReportsController extends Controller
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
                   $rows->whereDate('created_at', $request->fromDate);
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

                            

                            <a href='.$url.' class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>

                          

                       ';

                })
                
                 ->addColumn('checkbox', function ($row) {
              
                  return  '<input  type="checkbox" value=" '.$row->id.' "/>' ;
                    
                })


                ->editColumn('status', function ($row) {

                    $status='';
                    $button= " ";
                    if ($row->status=='new'){
                        $status= 'طلب جديد';
                        $button ="btn btn-primary"; 
                    }elseif ($row->status=='converted_to_delivery')
                    {
                        $status='طلب محول الي المندوب';
                        $button ="btn btn-secondary";
                    }elseif ($row->status=='total_delivery_to_customer'){
                        $status='طلب مسلم كليا';
                        $button ='btn btn-success';
                  }  elseif ($row->status=='partial_delivery_to_customer'){
                        $status='طلب مسلم جزئيا';
                        $button ='btn btn-light';
                  }  elseif ($row->status=='not_delivery'){
                        $status='طلب لم يسلم';
                        $button ='btn btn-danger';
                    } elseif ($row->status=='under_implementation') {
                        $status='تحت التنفيذ';
                         $button ='btn btn-info';
                    } elseif ($row->status=='cancel'){
                        $status='طلب ملغي';
                         $button ='btn btn-dark';
                    }elseif ($row->status=='delaying'){
                        $status='طلب مؤجل';
                         $button ='btn btn-warning' ;
                 } elseif ($row->status=='collection') {
                        $status='طلب محصل';
                         $button ='btn btn-success';
                  }  elseif ($row->status=='paid') {
                        $status='مدفوع';
                         $button ='btn btn-success';
                   } else{
                        $status='لم يحدد';
                        }

                    return '<button class="'.$button.'">'.$status.'</button>';

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
           $rows->whereDate('created_at', $request->fromDate);
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

        return view('Admin.reports.mandoubs.index',compact('request','deliveries','shipment_pieces_number','shipment_value','delivery_value','total_value','delivery_ratio','delivery_ratio_val'));
    }



}
