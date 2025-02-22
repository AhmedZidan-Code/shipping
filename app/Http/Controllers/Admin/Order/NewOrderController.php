<?php

namespace App\Http\Controllers\Admin\Order;

use App\Exports\OrderFormExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Imports\OrderImport;
use App\Models\AgentPrice;
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

    public function __construct()
    {
        $this->middleware('permission:عرض طلبات بوصلة')->only(['index', 'getOrderDetails', 'getDeliveryForOrder', 'orderDetails', 'get_delivery_value', 'exportExcel', 'exportForm', 'insertBulkOrdersForDelivery']);
        $this->middleware('permission:تعديل طلبات بوصلة')->only(['edit', 'update', 'changeDelivery', 'changeStatus', 'changeStatus', 'insertingDeliveryForOrder', 'importOrders']);
        $this->middleware('permission:إنشاء طلبات بوصلة')->only(['create', 'store']);
        $this->middleware('permission:حذف طلبات بوصلة')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::query()->with(['province', 'trader', 'delivery']);
            if ($request->delivery_id) {
                $orders->where('delivery_id', $request->delivery_id);
            }

            if ($request->trader_id) {
                $orders->where('trader_id', $request->trader_id);
            }
            if ($request->fromDate) {
                $orders->where('created_at', '>=', $request->fromDate . ' ' . '00:00:00');
            }
            if ($request->toDate) {
                $orders->where('created_at', '<=', $request->toDate . ' ' . '23:59:59');
            }

            $orders->where('status', 'new')->with(['province', 'trader'])->/* where('status', 'new')-> */orderBy('updated_at', 'desc');

            $rowsCount = $orders->count();
            $total = $orders->sum('shipment_value');
            return DataTables::of($orders)
                ->addColumn('checkbox', function ($row) {

                    return '<input type="checkbox" class="orders_ids"  value="' . $row->id . '" />';
                })
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل طلبات بوصلة')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('تعديل طلبات بوصلة')) {
                        $delete = 'hidden';
                    }

                    $url = route('admin.orderDetails', $row->id);
                    $route = route('orders.edit', $row->id);

                    return '

                            <button ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </span>
                            </button>

                           <a href=' . $url . ' class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>
                           <a href="#" class="btn rounded-pill btn-outline-dark print" data-order=' . $row->id . '><i class="fa fa-print" aria-hidden="true"></i></a>
                           <a href=' . $route . ' class="btn rounded-pill btn-outline-dark"><i class="fa fa-edit" aria-hidden="true"></i></a>

                       ';
                })

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
                ->addColumn('orderDetails', function ($row) {
                    $url = route('admin.orderDetails', $row->id);
                    return "<a href='$url' class='btn btn-outline-dark'><i class='fa fa-eye' aria-hidden='true'></i></a>";
                })

                ->editColumn('delivery_id', function ($row) {

                    $delivery = '';
                    if (!auth()->user()->can('تعديل طلبات بوصلة')) {
                        $delivery = 'hidden';
                    }

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
                ->with(['rowsCount' => $rowsCount, 'total' => $total])
                ->escapeColumns([])
                ->make(true);
        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الطلبات  الجديدة");
        }
        $delivieries = DB::table('deliveries')->whereNull('deleted_at')->get();

        return view('Admin.CRUDS.Orders.newOrders.index', compact('delivieries'));
    }

    public function create(Request $request)
    {
        $traders = Trader::get();
        $provinces = Area::where('from_id', '!=', null)->get();
        $delivers = Delivery::get();

        return view('Admin.CRUDS.Orders.newOrders.parts.create', compact('traders', 'provinces', 'delivers'));
    }

    public function store(Request $request)
    {
        $trans = $this->validate($request, [
            'trader_id' => 'required|array',
            'trader_id.*' => 'required',
            //            'delivery_id'=>'required|array',
            //            'delivery_id.*'=>'required',
            'customer_address' => 'required|array',
            'customer_address.*' => 'required',
            'customer_name' => 'required|array',
            'customer_name.*' => 'required',
            'customer_phone' => 'required|array',
            'customer_phone.*' => 'required',
            'delivery_ratio' => 'nullable|array',
            'delivery_ratio.*' => 'nullable',
            //            'delivery_time'=>'required|array',
            //            'delivery_time.*'=>'required',
            'delivery_value' => 'required|array',
            'delivery_value.*' => 'nullable',
            'province_id' => 'nullable|array',
            'province_id.*' => 'required|exists:areas,id',
            'shipment_pieces_number' => 'nullable|array',
            'shipment_pieces_number.*' => 'nullable',
            'shipment_value' => 'nullable|array',
            'shipment_value.*' => 'nullable',
            'notes' => 'required',

        ]);

        $sql = [];
        if ($request->customer_name) {
            for ($i = 0; $i < count($request->customer_name); $i++) {
                $status = 'new';

                $total_value = 0;
                $delivery_id = null;

                $total_value = $total_value + (int) $request->delivery_value[$i] + (int) $request->shipment_value[$i];
                $row = [];
                if ($request->delivery_id[$i] != null && $request->delivery_id[$i] != 0) {
                    $status = 'converted_to_delivery';
                    $delivery_id = $request->delivery_id[$i];
                    $delivery = Delivery::where('id', $delivery_id)->first();
                    if ($delivery && $delivery->type == 'agent') {
                        if ($agentPrice = AgentPrice::where(['agent_id' => $delivery->id, 'govern_id' => $request->province_id[$i]])->first()) {
                            $row['agent_shipping'] = $agentPrice->value;
                            $total_value = $total_value + (int) $agentPrice->value + (int) $request->shipment_value[$i];
                        } else {
                            return response()->json([
                                'code' => 404,
                                'message' => ' من فضلك أدخل أسعار شحن الوكيل ' . $delivery->name,
                            ]);
                        }
                    }
                }
                $row += [
                    'trader_id' => $request->trader_id[$i],
                    'status' => $status,
                    'shipment_value' => $request->shipment_value[$i],
                    'shipment_pieces_number' => $request->shipment_pieces_number[$i],
                    'province_id' => $request->province_id[$i],
                    'delivery_value' => $request->delivery_value[$i],
                    //                    'delivery_time'=>$request->delivery_time[$i],
                    'delivery_ratio' => $request->delivery_ratio[$i],
                    'customer_phone' => $request->customer_phone[$i],
                    'customer_name' => $request->customer_name[$i],
                    'customer_address' => $request->customer_address[$i],
                    'delivery_id' => $delivery_id,
                    'total_value' => $total_value,
                    'notes' => $request->notes[$i],
                    'trader_collection' => $request->shipment_value[$i],

                    'created_at' => date('Y-m-d H:i:s'),
                    'converted_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    'converted_date_s' => strtotime(Carbon::now()->format('Y-m-d H:i:s')),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'publisher' => auth()->id(),
                    'first_status' => $status,

                ];
                array_push($sql, $row);
            }
        }

        DB::table('orders')->insert($sql);

        $this->add_log_activity(null, auth('admin')->user(), "  تم اضافة طلبات جديدة   ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function edit(Order $order)
    {

        $traders = Trader::get();
        $provinces = Area::where('from_id', '!=', null)->get();
        $delivers = Delivery::get();
        $order->load(['province', 'trader']);

        return view('Admin.CRUDS.Orders.newOrders.parts.edit', compact('traders', 'provinces', 'delivers', 'order'));
    }

    public function update(Request $request, Order $order)
    {

        $data = $request->validate([

            'customer_address' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'delivery_ratio' => 'nullable',
            'delivery_value' => 'required',
            'province_id' => 'required',
            'shipment_pieces_number' => 'nullable',
            'shipment_value' => 'required',
            'notes' => 'nullable',
            'trader_collection' => 'required',
            'delivery_id' => 'nullable|exists:deliveries,id',
            'trader_id' => 'nullable|exists:traders,id',

        ]);

        $history['order_id'] = $order->id;
        $history['previous_status'] = $order->status;
        $history['next_status'] = $order->status;
        $history['reason'] = 'edit';
        $history['from_mandoub'] = $order->delivery_id;
        $history['to_mandoub'] = $data['delivery_id'];
        $history['publisher'] = auth()->id();
        $history['date'] = strtotime(date('Y-m-d'));
        $history['time'] = date('h:i a');
        if ($order->trader_id != $data['trader_id']) {
            $history['before_edit'] = $order->trader_id . '->' . DB::table('traders')->where('id', $order->trader_id)->first()->name;
            $history['after_edit'] = $data['trader_id'] . '->' . DB::table('traders')->where('id', $data['trader_id'])->first()->name;
            $history['notes'] = "تغيير في التاجر ";
            //save_history($history);
            DB::table('order_history')->insert($history);
        }
        if ($order->delivery_id != $data['delivery_id'] && $order->status != 'new') {
            $history['before_edit'] = $order->delivery_id . '->' . DB::table('deliveries')->where('id', $order->delivery_id)->first()->name;
            $history['after_edit'] = $data['delivery_id'] . '->' . DB::table('deliveries')->where('id', $data['delivery_id'])->first()->name;

            //===========================================
            $data['converted_date'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['converted_date_s'] = strtotime(Carbon::now()->format('Y-m-d H:i:s'));

            //=====================================================

            $history['notes'] = "تغيير في المندوب";
            save_history($history);
        }

        if ($order->shipment_value != $data['shipment_value']) {
            $history['before_edit'] = $order->shipment_value;
            $history['after_edit'] = $data['shipment_value'];
            $history['notes'] = "تغير في قيمه الاوردر";
            save_history($history);
        }
        if ($order->notes != $data['notes']) {
            $history['before_edit'] = $order->notes;
            $history['after_edit'] = $data['notes'];
            $history['notes'] = "تغير في الملاحظات";
            save_history($history);
        }

        $data['total_value'] = (int) $request->delivery_value + (int) $request->shipment_value;
        // $data['converted_date']=date('Y-m-d H:i:s') ;
        $old = $order;
        if ($data['delivery_id'] != null && $data['delivery_id'] != 0) {
            $delivery = Delivery::where('id', $data['delivery_id'])->first();
            if ($delivery && $delivery->type == 'agent') {
                if ($agentPrice = AgentPrice::where(['agent_id' => $delivery->id, 'govern_id' => $data['province_id']])->first()) {
                    $data['agent_shipping'] = $agentPrice->value;
                    $data['total_value'] = (int) $agentPrice->value + (int) $data['shipment_value'];
                } else {
                    return response()->json([
                        'code' => 404,
                        'message' => ' من فضلك أدخل أسعار شحن الوكيل ' . $delivery->name,
                    ]);
                }
            }
        }

        $order->update($data);

        $this->add_log_activity($old, auth('admin')->user(), " تم  تعديل بيانات الطلب    $order->id ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $old = $order;
        $order->delete();

        $this->add_log_activity($old, auth('admin')->user(), " تم   حذف بيانات الطلب    $old->id ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    } //end fun

    public function getOrderDetails(Request $request)
    {
        $id = rand(1, 999999999999999);
        $html = view('Admin.CRUDS.Orders.newOrders.parts.details', compact('id'))->render();

        return response()->json(['status' => true, 'html' => $html, 'id' => $id]);
    }

    public function changeDelivery(Request $request)
    {
        $order = Order::findOrFail($request->id);

        $before_edit = DB::table('deliveries')->where('id', $order->delivery_id)->first();
        $after_edit = DB::table('deliveries')->where('id', $request->delivery_id)->first();

        $history['order_id'] = $request->id;
        $history['previous_status'] = $order->status;
        $history['next_status'] = 'converted_to_delivery';
        $history['reason'] = '';
        $history['from_mandoub'] = $order->delivery_id;
        $history['to_mandoub'] = $request->delivery_id;
        $history['publisher'] = auth()->id();
        $history['date'] = strtotime(date('Y-m-d'));
        $history['time'] = date('h:i a');
        $history['before_edit'] = $order->delivery_id . '->' . !empty($before_edit) ? $before_edit->name : '';
        $history['after_edit'] = $request->delivery_id . '->' . !empty($after_edit) ? $after_edit->name : '';
        $history['notes'] = "تغيير في المندوب";
        save_history($history);

        $old = $order;
        $order->update([
            'status' => 'converted_to_delivery',
            'delivery_id' => $request->delivery_id,
        ]);

        //=============================================

        //=============================================
        $this->add_log_activity(null, auth('admin')->user(), "    تم اختيار المندوب للطلب رقم $order->id ");

        return response()->json(['status' => true]);
    }

    public function changeStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);

        $order->update([
            'status' => $request->status,
        ]);

        $this->add_log_activity(null, auth('admin')->user(), "تم تغير حالة الطلب $order->id");

        return response()->json(['status' => true]);
    }

    public function getDeliveryForOrder($id)
    {
        $order = Order::findOrFail($id);

        $delivers = Delivery::get();

        return view('Admin.CRUDS.Orders.newOrders.parts.deliveries', compact('delivers', 'order'));
    }

    public function insertingDeliveryForOrder(Request $request, $id)
    {
        $row = Order::findOrFail($id);

        $data = $request->validate([
            'delivery_id' => 'required|exists:deliveries,id',

        ]);
        $data['status'] = 'converted_to_delivery';
        $data['converted_date'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['converted_date_s'] = strtotime($data['converted_date']);

        //=====================

        $history['order_id'] = $id;
        $history['previous_status'] = $row->status;
        $history['next_status'] = $data['status'];
        $history['reason'] = 'change_status';
        $history['from_mandoub'] = $row->delivery_id;
        $history['to_mandoub'] = $request->delivery_id;
        $history['publisher'] = auth()->id();
        $history['date'] = strtotime(date('Y-m-d'));
        $history['time'] = date('h:i a');

        $history['before_edit'] = $row->status;
        $history['after_edit'] = $data['status'];
        $history['notes'] = "تغيير في الحاله";
        save_history($history);
        // DB::table('order_history')->insert($history);
        if ($request->delivery_id != null && $request->delivery_id != 0) {
            $delivery_id = $request->delivery_id;
            $delivery = Delivery::where('id', $delivery_id)->first();
            if ($delivery && $delivery->type == 'agent') {
                if ($agentPrice = AgentPrice::where(['agent_id' => $delivery->id, 'govern_id' => $row->province_id])->first()) {
                    $data['agent_shipping'] = $agentPrice->value;
                    $data['total_value'] = (int) $agentPrice->value + (int) $row->shipment_value;
                } else {
                    return response()->json([
                        'code' => 404,
                        'message' => ' من فضلك أدخل أسعار شحن الوكيل ' . $delivery->name,
                    ]);
                }
            }
        }

        $row->update($data);
        //=============================

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function orderDetails($id)
    {

        //$order=Order::findOrFail($id);
        // $traders=Trader::get();
        //   $provinces=Area::where('from_id','!=',null)->get();

        // return view('Admin.CRUDS.Orders.orderDetails.index', compact('order','traders','provinces'));
        // $order= Order::with('delivery')->findOrFail($id);
        $order = DB::table('orders')
            ->leftjoin('admins', 'admins.id', '=', 'orders.publisher')
            ->leftjoin('deliveries', 'orders.delivery_id', '=', 'deliveries.id')
            ->select('orders.*', 'admins.name as user_name', 'deliveries.name as mandoub')
            ->where('orders.id', $id)
            ->first();

        $traders = Trader::get();
        $provinces = Area::where('from_id', '!=', null)->get();
        $history = DB::table('order_history')
            ->join('admins', 'order_history.publisher', '=', 'admins.id')
            ->join('deliveries', 'order_history.to_mandoub', '=', 'deliveries.id')
            ->where('order_history.order_id', $id)
            ->orderBy('order_history.id', 'asc')
            ->select('order_history.*', 'admins.name as user_name', 'deliveries.name as mandoub')
            ->get();

        return view('Admin.CRUDS.Orders.orderDetails.index', compact('order', 'traders', 'provinces', 'history'));
    }

    public function get_delivery_value(Request $request)
    {
        $city_id = $request->province_id;
        $trader_id = $request->trader_id;

        $govern_id = Area::where('id', $city_id)->first()->from_id;
        $row = DB::table('prices')->where('trader_id', $trader_id)->where('govern_id', $govern_id)->first();

        if (isset($row) && !empty($row)) {
            echo $row->value;
        }
    }

    public function exportExcel()
    {
        return view('Admin.CRUDS.Orders.newOrders.parts.import');
    }

    public function exportForm()
    {
        return Excel::download(new OrderFormExport, 'orders-form.xlsx');
    }
    public function importOrders(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
            'trader_id' => 'required',
            'delivery_id' => 'nullable',
        ]);
        try {
            Excel::import(new OrderImport, $request->file('file'));

            return response()->json(
                [
                    'code' => 200,
                    'message' => 'تمت العملية بنجاح!',
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'code' => 400,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }

    public function insertBulkOrdersForDelivery(Request $request)
    {
        $validation = $request->validate([
            'delivery_id' => 'required|exists:deliveries,id',
            'orders_ids.*' => 'required|exists:orders,id',
        ]);

        $rows = Order::whereIn('id', $request->orders_ids)->get();

        foreach ($rows as $row) {
            $data['status'] = 'converted_to_delivery';
            $data['converted_date'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['converted_date_s'] = strtotime($data['converted_date']);
            $data['delivery_id'] = $validation['delivery_id'];

            //=====================

            $history['order_id'] = $row->id;
            $history['previous_status'] = $row->status;
            $history['next_status'] = $data['status'];
            $history['reason'] = 'change_status';
            $history['from_mandoub'] = $row->delivery_id;
            $history['to_mandoub'] = $request->delivery_id;
            $history['publisher'] = auth()->id();
            $history['date'] = strtotime(date('Y-m-d'));
            $history['time'] = date('h:i a');

            $history['before_edit'] = $row->status;
            $history['after_edit'] = $data['status'];
            $history['notes'] = "تغيير في الحاله";
            save_history($history);
            if ($request->delivery_id != null && $request->delivery_id != 0) {
                $delivery_id = $request->delivery_id;
                $delivery = Delivery::where('id', $delivery_id)->first();
                if ($delivery && $delivery->type == 'agent') {
                    if ($agentPrice = AgentPrice::where(['agent_id' => $delivery->id, 'govern_id' => $row->province_id])->first()) {
                        $data['agent_shipping'] = $agentPrice->value;
                        $data['total_value'] = (int) $agentPrice->value + (int) $row->shipment_value;
                    } else {
                        return response()->json([
                            'code' => 404,
                            'message' => ' من فضلك أدخل أسعار شحن الوكيل ' . $delivery->name,
                        ]);
                    }
                }
            }

            $row->update($data);
        }

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }
}
