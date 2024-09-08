<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Area;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class NewOrderController extends Controller
{
    use LogActivityTrait;


    function __construct()
    {
        $this->middleware('permission:عرض الطلبات', ['only' => ['index']]);
        $this->middleware('permission:العمليات علي الطلبات', ['only' => ['create','store']]);
        $this->middleware('permission:العمليات علي الطلبات', ['only' => ['edit','update']]);
        $this->middleware('permission:العمليات علي الطلبات', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Order::query()->with(['province','trader'])->where('status','new')->orderBy('updated_at', 'desc');
            return DataTables::of($admins)
                ->addColumn('action', function ($row) {

                    $edit='';
                    $delete='';


                    if(!auth()->user()->can('العمليات علي الطلبات'))
                        $edit='hidden';
                    if(!auth()->user()->can('العمليات علي الطلبات'))
                        $delete='hidden';

                    $url=route('admin.orderDetails',$row->id);
                    $route=route('orders.edit',$row->id);



                    return '

                            <button '.$delete.'  class="btn rounded-pill btn-danger waves-effect waves-light delete"
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
                ->addColumn('orderDetails', function ($row) {
                    $url=route('admin.orderDetails',$row->id);
                    return "<a href='$url' class='btn btn-outline-dark'><i class='fa fa-eye' aria-hidden='true'></i></a>";
                })


                ->editColumn('delivery_id', function ($row) {

                    $delivery='';
                    if(!auth()->user()->can('العمليات علي الطلبات'))
                        $delivery='hidden';

                    return "<button $delivery data-id='$row->id' class='btn btn-info insertDelivery'>       $row->status
</button>";



//                    $options = '<option selected disabled> اختر المندوب الان </option>';
//
//                    foreach (Delivery::get() as $delivery) {
//                        $data = '';
//                        if ($row->deliver_id != null) ;
//                        {
//                            if ($row->deliver_id == $delivery->id) {
//                                $data = 'selected';
//                            }
//                        }
//                        $options .= '<option ' . $data . ' value="' . $delivery->id . '">' . $delivery->name . '</option>';
//                    }
//                    $select = "<select class='form-control changeDelivery' data-id='" . $row->id . "'>
//
//                         " . $options . "
//                    </select>";
//
//                    return $select;


                })




                    ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        else{
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الطلبات  الجديدة");

        }
        return view('Admin.CRUDS.Orders.newOrders.index');
    }


    public function create(Request $request)
    {
        $traders=Trader::get();
        $provinces=Area::where('from_id','!=',null)->get();
        $delivers=Delivery::get();


        return view('Admin.CRUDS.Orders.newOrders.parts.create',compact('traders','provinces','delivers'));

    }

    public function store(Request $request)
    {
        $trans = $this->validate($request,[
            'trader_id'=>'required|array',
            'trader_id.*'=>'required',
//            'delivery_id'=>'required|array',
//            'delivery_id.*'=>'required',
            'customer_address'=>'required|array',
            'customer_address.*'=>'required',
            'customer_name'=>'required|array',
            'customer_name.*'=>'required',
            'customer_phone'=>'required|array',
            'customer_phone.*'=>'required',
            'delivery_ratio'=>'nullable|array',
            'delivery_ratio.*'=>'nullable',
//            'delivery_time'=>'required|array',
//            'delivery_time.*'=>'required',
            'delivery_value'=>'required|array',
            'delivery_value.*'=>'nullable',
            'province_id'=>'nullable|array',
            'province_id.*'=>'required',
            'shipment_pieces_number'=>'nullable|array',
            'shipment_pieces_number.*'=>'nullable',
            'shipment_value'=>'nullable|array',
            'shipment_value.*'=>'nullable',
            'notes'=>'required',
            'trader_collection'=>'required',
        ]);
        
        // $maxId = DB::table('orders')->max('id');
       $sql=[];
        if ($request->customer_name )
            for ($i=0;$i<count($request->customer_name);$i++)
            {
                $status='new';

                $total_value=0;
                $delivery_id=null;

                $total_value= $total_value+(int)$request->delivery_value[$i]+(int)$request->shipment_value[$i];

                if ($request->delivery_id[$i]!=null){
                    if ($request->delivery_id[$i]!=0)
                    {
                        $status='converted_to_delivery';
                        $delivery_id=$request->delivery_id[$i];

                    }
                }
              $row=[];
              $row= [
                    'trader_id'=>$request->trader_id[$i],
                    'status'=>$status,
                    'shipment_value'=>$request->shipment_value[$i],
                    'shipment_pieces_number'=>$request->shipment_pieces_number[$i],
                    'province_id'=>$request->province_id[$i],
                    'delivery_value'=>$request->delivery_value[$i],
//                    'delivery_time'=>$request->delivery_time[$i],
                    'delivery_ratio'=>$request->delivery_ratio[$i],
                    'customer_phone'=>$request->customer_phone[$i],
                    'customer_name'=>$request->customer_name[$i],
                    'customer_address'=>$request->customer_address[$i],
                    'delivery_id'=>$delivery_id,
                    'total_value'=>$total_value,
                  'notes'=>$request->notes[$i],
                  'trader_collection'=>$request->trader_collection[$i],

                  'created_at'=>date('Y-m-d H:i:s'),
                  'converted_date'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'publisher'=>auth()->id()

                ];

              array_push($sql,$row);
              
              
          DB::table('orders')->insert($sql);
      //============================
      
      
      

            }

    
      
      
      
      //==================================
        

        $this->add_log_activity(null,auth('admin')->user(),"  تم اضافة طلبات جديدة   ");



        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);
    }



    public function edit(Order $order)
    {

        $traders=Trader::get();
        $provinces=Area::where('from_id','!=',null)->get();
        $delivers=Delivery::get();


        return view('Admin.CRUDS.Orders.newOrders.parts.edit',compact('traders','provinces','delivers','order'));



    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([

            'customer_address'=>'required',
            'customer_name'=>'required',
            'customer_phone'=>'required',
            'delivery_ratio'=>'nullable',
            'delivery_value'=>'required',
            'shipment_pieces_number'=>'nullable',
            'shipment_value'=>'required',
            'notes'=>'nullable',
            'trader_collection'=>'required',
            'delivery_id'=>'nullable|exists:deliveries,id',
            'trader_id'=>'nullable|exists:traders,id',


        ]);



        $data['total_value']=(int)$request->delivery_value+(int)$request->shipment_value;
        $data['converted_date']=date('Y-m-d H:i:s') ;
        $old=$order;

        $order->update($data);

        $this->add_log_activity($old,auth('admin')->user()," تم  تعديل بيانات الطلب    $order->id ");


        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }


    public function destroy($id )
    {
        $order=Order::findOrFail($id);

        $old=$order;
        $order->delete();

        $this->add_log_activity($old,auth('admin')->user()," تم   حذف بيانات الطلب    $old->id ");


        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);
    }//end fun

    public function getOrderDetails(Request $request){
        $id=rand(1,999999999999999);
        $html=  view('Admin.CRUDS.Orders.newOrders.parts.details', compact('id'))->render();

        return response()->json(['status'=>true,'html'=>$html,'id'=>$id]);

    }

    public function changeDelivery(Request $request){
        $order=Order::findOrFail($request->id);

        $old=$order;

        $order->update([
            'status'=>'converted_to_delivery',
            'delivery_id'=>$request->delivery_id,
        ]);

        $this->add_log_activity(null, auth('admin')->user(), "    تم اختيار المندوب للطلب رقم $order->id ");

        return response()->json(['status'=>true]);


    }

    public function changeStatus(Request $request){
        $order=Order::findOrFail($request->id);

        $order->update([
            'status'=>$request->status,
        ]);

        $this->add_log_activity(null, auth('admin')->user(), "تم تغير حالة الطلب $order->id");

        return response()->json(['status'=>true]);

    }


    public function getDeliveryForOrder($id){
        $order=Order::findOrFail($id);

        $delivers=Delivery::get();


        return view('Admin.CRUDS.Orders.newOrders.parts.deliveries',compact('delivers','order'));


    }

    public function insertingDeliveryForOrder(Request $request,$id ){
        $row=Order::findOrFail($id);

        $data = $request->validate([
            'delivery_id' => 'required|exists:deliveries,id',


        ]);
        $data['status']='converted_to_delivery';
        $data['converted_date']=date('Y-m-d h:i:s');
         $row->update($data);
         //=====================
         
         $history['order_id'] = $id ;
        $history['previous_status'] = $row->status ;
        $history['next_status'] =  $data['status'] ;
       $history['reason'] = '';
        $history['from_mandoub'] = $row->delivery_id ;
        $history['to_mandoub'] = $request->delivery_id ;
        $history['publisher'] = auth()->id() ;
        $history['date'] = strtotime(date('Y-m-d'));
       $history['time'] = date('h:i a');
        DB::table('order_history')->insert($history);
          //=============================

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function orderDetails($id){

        $order= Order::with('delivery')->findOrFail($id);
        $admin= DB::table('admins')->where('id',$order->publisher)->first();
        
         $traders=Trader::get();
        $provinces=Area::where('from_id','!=',null)->get();
        $history = DB::table('order_history')
                ->join('admins', 'order_history.publisher', '=', 'admins.id')
                ->join('deliveries', 'order_history.to_mandoub', '=', 'deliveries.id')
                ->where('order_history.order_id', $id)
                ->select('order_history.*', 'admins.name as user_name', 'deliveries.name as mandoub')
                ->get();
               
       return view('Admin.CRUDS.Orders.orderDetails.index', compact('order','traders','provinces','history','admin'));


    }
}
