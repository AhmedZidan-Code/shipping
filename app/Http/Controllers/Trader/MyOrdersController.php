<?php

namespace App\Http\Controllers\Trader;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MyOrdersController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Order::query()->latest()->with(['province','trader'])->where('trader_id',trader()->user()->id);
            if ($request->status){
                $admins->where('status',$request->status);
            }
            return DataTables::of($admins)
                ->addColumn('action', function ($row) {

                    $edit='';
                    $delete='';

                    return '

                            <button '.$delete.'  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </span>
                            </button>
                       ';



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
                ->editColumn('province_id', function ($row) {
                    return $row->province->title??'';
                })

                ->editColumn('address', function ($data) {
                    $link = "https://www.google.com/maps/search/?api=1&query=".$data->latitude.",".$data->longitude;
                    return '<a target="_blank" class="btn btn-pill btn-info" href="'.$link.'"> عرض <i class="fa fa-map-marker-alt text-white"></i>  </a>';
                })
                ->editColumn('trader_id', function ($row) {
                    return  $row->trader->name??'';
                })


                ->editColumn('delivery_id', function ($row) {

                    return $row->delivery->name??'';


                })




                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        else{

        }
        return view('Trader.myOrders.index');
    }
}
