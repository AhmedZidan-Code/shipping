<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TotalDeliveryOrderController extends Controller
{
    use LogActivityTrait;

    function __construct()
    {
        $this->middleware('permission:عرض الطلبات', ['only' => ['index']]);
        $this->middleware('permission:العمليات علي الطلبات', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $admins = Order::query()->with(['province', 'trader', 'delivery'])->where('status', 'total_delivery_to_customer')->orderBy('updated_at', 'desc');
            return DataTables::of($admins)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    $url=route('admin.orderDetails',$row->id);
                    $route=route('orders.edit',$row->id);




                    if(!auth()->user()->can('العمليات علي الطلبات'))
                        $edit='hidden';
                    if(!auth()->user()->can('العمليات علي الطلبات'))
                        $delete='hidden';


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
                ->addColumn('orderDetails', function ($row) {
                    $url=route('admin.orderDetails',$row->id);
                    return "<a href='$url' class='btn btn-outline-dark'><i class='fa fa-eye' aria-hidden='true'></i></a>";
                })
                ->editColumn('province_id', function ($row) {
                    return $row->province->title ?? '';
                })

                ->editColumn('trader_id', function ($row) {
                    return $row->trader->name ?? '';
                })
                ->editColumn('address', function ($data) {
                    $link = "https://www.google.com/maps/search/?api=1&query=".$data->latitude.",".$data->longitude;
                    return '<a target="_blank" class="btn btn-pill btn-info" href="'.$link.'"> عرض <i class="fa fa-map-marker-alt text-white"></i>  </a>';
                })
                ->editColumn('status', function ($row) {

                    $status='';
                    if(!auth()->user()->can('العمليات علي الطلبات'))
                        $status='hidden';

                    $data='';

                    if($row->status=='converted_to_delivery')
                        $data='محول الي مندوب';

                    if($row->status=='total_delivery_to_customer')
                        $data='تم التسليم';
                    if($row->status=='partial_delivery_to_customer')
                        $data='تسليم جزئي';

                    if($row->status=='not_delivery')
                        $data='عدم استلام';

                    if($row->status=='paid')
                        $data='تم الدفع';

                    if($row->status=='collection')
                        $data='تحصيل';
                    if($row->status=='delaying')
                        $data='مؤجل';

                    if($row->status=='cancel')
                        $data='لاغي';
                    if($row->status=='under_implementation')
                        $data='تحت التنفيذ';



                    return "<button $status  data-id='$row->id' class='btn btn-success changeStatusData'>  $data

</button>";



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


                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الطلبات  المسلمة كليا للعميل");

        }
        return view('Admin.CRUDS.Orders.totalDeliveryOrders.index');
    }

    public function destroy($id )
    {
        $order=Order::findOrFail($id);

        $old = $order;
        $order->delete();

        $this->add_log_activity($old, auth('admin')->user(), " تم   حذف بيانات الطلب    $old->id ");


        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);
    }//end fun

}
