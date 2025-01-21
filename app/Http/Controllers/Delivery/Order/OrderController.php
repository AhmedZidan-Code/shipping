<?php

namespace App\Http\Controllers\Delivery\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Order::query()->latest()->with(['province','trader'])->where('delivery_id',delivery()->user()->id)->whereNotIn('status',['new','converted_to_delivery']);
            if($request->status){
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

                ->editColumn('status', function ($row) {

                    if ($row->status=='total_delivery_to_customer')
                        return 'تم التسليم الكلي للعميل';
                    elseif ($row->status=='partial_delivery_to_customer')
                        return 'تم التسليم الجزئي للعميل';
                    elseif ($row->status=='not_delivery')
                        return 'لم يتم التسليم';
                    else
                        return '';
                })



                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        else{

        }
        return view('Delivery.myOrders.end');
    }
}
