<?php

namespace App\Http\Controllers\Delivery\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CurrentOrderController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Order::query()->latest()->with(['province','trader'])->where('delivery_id',delivery()->user()->id)->where('status','converted_to_delivery');
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

//
//                ->editColumn('status', function ($row) {
//
//
//
//
//                    $option1 = '';
//                    $option2 = '';
//                    $option3 = '';
//                    $option4 = '';
//                    if ($row->status == 'converted_to_delivery')
//                        $option1 = 'selected';
//                    elseif ($row->status == 'total_delivery_to_customer')
//                        $option2 = 'selected';
//                    elseif ($row->status == 'partial_delivery_to_customer')
//                        $option3 = 'selected';
//                    elseif ($row->status == 'not_delivery') {
//                        $option4 = 'selected';
//                    } else {
//
//                    }
//                    $status = "<select name='status-data' data-id='$row->id' class='form-control changeStatus'>
//                       <option selected disabled> اختر  الحالة</option>
//                       <option $option1 value='converted_to_delivery'>تم التحويل التاجر  </option>
//                       <option $option2 value='total_delivery_to_customer'>تم التسليم الكلي للعميل </option>
//                       <option $option3 value='partial_delivery_to_customer'>  تم التسليم الجزئي للعميل  </option>
//                       <option $option4 value='not_delivery'>  لم يتم التسليم </option>
//
//                     </select>";
//
//                    return $status;
//
//                })



                ->editColumn('status', function ($row) {

                    $status='';



                    return "<button $status  data-id='$row->id' class='btn btn-success changeStatusData'>تغير حالة الطلب</button>";



//                    $option1 = '';
//                    $option2 = '';
//                    $option3 = '';
//                    $option4 = '';
//                    if ($row->status == 'converted_to_delivery')
//                        $option1 = 'selected';
//                    elseif ($row->status == 'total_delivery_to_customer')
//                        $option2 = 'selected';
//                    elseif ($row->status == 'partial_delivery_to_customer')
//                        $option3 = 'selected';
//                    elseif ($row->status == 'not_delivery') {
//                        $option4 = 'selected';
//                    } else {
//
//                    }
//                    $status = "<select name='status' data-id='$row->id' class='form-control changeStatus'>
//                       <option selected disabled> اختر  الحالة</option>
//                       <option $option1 value='converted_to_delivery'>تم التحويل التاجر  </option>
//                       <option $option2 value='total_delivery_to_customer'>تم التسليم الكلي للعميل </option>
//                       <option $option3 value='partial_delivery_to_customer'>  تم التسليم الجزئي للعميل  </option>
//                       <option $option4 value='not_delivery'>  لم يتم التسليم </option>
//
//                     </select>";
//
//                    return $status;

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
        return view('Delivery.myOrders.current');
    }

    public function changeMyOrderStatus(Request  $request){
        $order=Order::findOrFail($request->id);
        $order->update([
            'status'=>$request->status,
        ]);

        return response()->json(['status'=>true]);
    }

    public function deliveryChangeOrderStatus($id){
        $row=Order::findOrFail($id);
        return view('Delivery.myOrders.parts.changeStatus',compact('row'));
    }
    public function deliveryChangeOrderStatus_store(Request $request,$id ){
        $order=Order::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:not_delivery,partial_delivery_to_customer,total_delivery_to_customer',
            'refused_reason'=>'nullable',

        ]);
        $order->update($data);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);


    }
}
