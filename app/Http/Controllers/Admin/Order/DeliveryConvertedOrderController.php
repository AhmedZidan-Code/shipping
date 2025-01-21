<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\AgentPrice;
use App\Models\Delivery;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DeliveryConvertedOrderController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض الطلبات المحولة للمناديب')->only(['index']);
        $this->middleware('permission:تعديل الطلبات المحولة للمناديب')->only(['edit', 'update', 'changeStatusForOrder', 'convert_order', 'changeStatusForOrder_store']);
        $this->middleware('permission:إنشاء الطلبات المحولة للمناديب')->only(['create', 'store']);
        $this->middleware('permission:حذف الطلبات المحولة للمناديب')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Order::query()->with(['province', 'trader', 'delivery'])

                ->where('status', 'converted_to_delivery')->orderBy('converted_date', 'desc');

            if ($request->delivery_id) {
                $rows->where('delivery_id', $request->delivery_id);
            }
            if ($request->trader_id) {
                $rows->where('trader_id', $request->trader_id);
            }
            if ($request->province_id) {
                $rows->where('province_id', $request->province_id);
            }
            if ($request->fromDate) {
                $rows->where('converted_date', '>=', $request->fromDate . ' ' . '00:00:00');
            }
            if ($request->toDate) {
                $rows->where('converted_date', '<=', $request->toDate . ' ' . '23:59:59');
            }

            $rowsCount = $rows->count();
            $total = $rows->sum('shipment_value');
            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل الطلبات المحولة للمناديب')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف الطلبات المحولة للمناديب')) {
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

                ->addColumn('convert_order', function ($row) {

                    return '<input type="checkbox" class="orders_ids" data-delivery="' . $row->delivery_id . '" value="' . $row->id . '" />';
                })
                ->addColumn('delivery_name', function ($row) {

                    return isset($row->delivery) ? $row->delivery->name : '';
                })

                ->editColumn('province_id', function ($row) {
                    return $row->province->title ?? '';
                })
                ->addColumn('orderDetails', function ($row) {
                    $url = route('admin.orderDetails', $row->id);
                    return "<a href='$url' class='btn btn-outline-dark'><i class='fa fa-eye' aria-hidden='true'></i></a>";
                })

                ->addColumn('residual', function ($row) {
                    return '';
                })

                ->editColumn('status', function ($row) {

                    $status = '';
                    if (!auth()->user()->can('تعديل الطلبات المحولة للمناديب')) {
                        $status = 'hidden';
                    }

                    $data = '';

                    if ($row->status == 'converted_to_delivery') {
                        $data = 'محول الي مندوب';
                    }

                    if ($row->status == 'total_delivery_to_customer') {
                        $data = 'التسليم';
                    }

                    if ($row->status == 'partial_delivery_to_customer') {
                        $data = 'تسليم جزئي';
                    }

                    if ($row->status == 'not_delivery') {
                        $data = 'عدم استلام';
                    }

                    if ($row->status == 'total_delivery_to_customer') {
                        $data = 'تم الدفع';
                    }

                    if ($row->status == 'collection') {
                        $data = 'تحصيل';
                    }

                    if ($row->status == 'delaying') {
                        $data = 'ماجل';
                    }

                    if ($row->status == 'cancel') {
                        $data = 'لاغي';
                    }

                    if ($row->status == 'under_implementation') {
                        $data = 'تحت التنفيذ';
                    }

                    return "<button $status  data-id='$row->id' class='btn btn-success changeStatusData'>  $data

</button>";

                    return $status;
                })

                ->editColumn('trader_id', function ($row) {
                    return $row->trader->name ?? '';
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->with(['rowsCount' => $rowsCount, 'total' => $total])
                ->make(true);
        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الطلبات المحولة للمناديب");
        }
        $delivieries = DB::table('deliveries')->whereNull('deleted_at')->get();

        return view('Admin.CRUDS.Orders.deliveryConvertedOrders.index', ['delivieries' => $delivieries, 'rowsCount' => isset($rowsCount) ? $rowsCount : 0, 'total' => isset($total) ? $total : 0]);
    }

    public function create(Request $request)
    {
        $status = $request->status;
        $order = Order::findOrFail($request->id);

        return view('Admin.CRUDS.Orders.deliveryConvertedOrders.parts.reason', compact('order', 'status'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required',
            'notes' => 'required',

        ]);

        $order = Order::findOrFail($request->order_id);
        $old = $order;

        $order->update([
            'status' => $request->status,
            'refused_reason' => $request->refused_reason,
        ]);

        $this->add_log_activity($old, auth('admin')->user(), "  تم تعديل حالة طلب برقم $order->id ");

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

    public function changeStatusForOrder($id)
    {
        $order = Order::with('delivery')->findOrFail($id);
        $deliveries = Delivery::all();
        return view('Admin.CRUDS.Orders.deliveryConvertedOrders.parts.status', compact('order', 'deliveries'));
    }

    public function changeStatusForOrder_store(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $data = $request->validate([
            'partial_value' => 'required_if:status,partial_delivery_to_customer',
            'delivery_value' => 'required_if:status,not_delivery',
            'status' => 'required',
            'notes' => 'nullable',
        ]);
        $data['converted_date'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['converted_date_s'] = strtotime($data['converted_date']);

        // dd($data);


        $data['delivery_id'] = $request->delivery_id;
        //================

        $arr = array(
            'converted_to_delivery' => 'محول الي مندوب',

            'total_delivery_to_customer' => 'التسليم',
            'partial_delivery_to_customer' => 'تسليم جزئي',
            'not_delivery' => 'عدم استلام',
            'total_delivery_to_customer' => 'تم التسليم ',
            'collection' => 'تحصيل',
            'delaying' => 'مؤجل',
            'cancel' => 'ملغي',
            'under_implementation' => 'تحت  التنفيذ',
            'new' => 'جديد',
            'paid' => 'تم الدفع',
            'shipping_on_messanger' => 'الشحن علي الراسل',
        );

        $history['order_id'] = $id;
        $history['previous_status'] = $order->status;
        $history['next_status'] = $request->status;
        $history['reason'] = 'change_status';
        $history['from_mandoub'] = $order->delivery_id;
        $history['to_mandoub'] = $order->delivery_id;
        $history['publisher'] = auth()->id();
        $history['date'] = strtotime(date('Y-m-d'));
        $history['time'] = date('h:i a');
        $history['before_edit'] = $arr[$order->status];
        $history['after_edit'] = $arr[$request->status];
        $history['notes'] = "تغيير في الحاله";
        save_history($history);
        //========================================================

        $before_edit = DB::table('deliveries')->where('id', $order->delivery_id)->first();
        $after_edit = DB::table('deliveries')->where('id', $request->delivery_id)->first();

        $history2['order_id'] = $request->id;
        $history2['previous_status'] = $order->status;
        $history2['next_status'] = $request->status;
        $history2['reason'] = '';
        $history2['from_mandoub'] = $order->delivery_id;
        $history2['to_mandoub'] = $request->delivery_id;
        $history2['publisher'] = auth()->id();
        $history2['date'] = strtotime(date('Y-m-d'));
        $history2['time'] = date('h:i a');
        $history2['before_edit'] = $order->delivery_id . '->' . !empty($before_edit) ? $before_edit->name ?? '' : '';
        $history2['after_edit'] = $request->delivery_id . '->' . !empty($after_edit) ? $after_edit->name : '';
        $history2['notes'] = "تغيير في المندوب";
        if ($order->delivery_id != $request->delivery_id) {
            save_history($history2);
        }

        //========================================

        // DB::table('order_history')->insert($history);
        //===================
        //if()
        if ($request->delivery_id != null && $request->delivery_id != 0) {
            $delivery_id = $request->delivery_id;
            $delivery = Delivery::where('id', $delivery_id)->first();
            if ($delivery && $delivery->type == 'agent') {
                if ($agentPrice = AgentPrice::where(['agent_id' => $delivery->id, 'govern_id' => $order->province_id])->first()) {
                    $data['agent_shipping'] = $agentPrice->value;
                    $data['total_value'] = (int) $agentPrice->value + (int) $order->shipment_value;
                } else {
                    return response()->json([
                        'code' => 404,
                        'message' => ' من فضلك أدخل أسعار شحن الوكيل ' . $delivery->name,
                    ]);
                }
            }
        }

        $order->update($data);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function convert_order(Request $request)
    {
        $orders_ids = $request->orders_ids;
        if (isset($orders_ids) && !empty($orders_ids)) {
            for ($x = 0; $x < Count($orders_ids); $x++) {
                $data['converted_date'] = Carbon::now()->format('Y-m-d H:i:s');
                $data['converted_date_s'] = strtotime($data['converted_date']);
                $data['delivery_id'] = $request->delivery_id;
                $order = Order::findOrFail($orders_ids[$x]);
                $before_edit = DB::table('deliveries')->where('id', $order->delivery_id)->first();
                $after_edit = DB::table('deliveries')->where('id', $request->delivery_id)->first();

                $history2['order_id'] = $orders_ids[$x];
                $history2['previous_status'] = $order->status;
                $history2['next_status'] = $order->status;
                $history2['reason'] = '';
                $history2['from_mandoub'] = $order->delivery_id;
                $history2['to_mandoub'] = $request->delivery_id;
                $history2['publisher'] = auth()->id();
                $history2['date'] = strtotime(date('Y-m-d'));
                $history2['time'] = date('h:i a');
                $history2['before_edit'] = $order->delivery_id . '->' . !empty($before_edit) ? $before_edit->name ?? '' : '';
                $history2['after_edit'] = $request->delivery_id . '->' . !empty($after_edit) ? $after_edit->name ?? '' : '';
                $history2['notes'] = "تغيير في المندوب";
                if ($order->delivery_id != $request->delivery_id) {
                    save_history($history2);
                }
                if ($request->delivery_id != null && $request->delivery_id != 0) {
                    $delivery_id = $request->delivery_id;
                    $delivery = Delivery::where('id', $delivery_id)->first();
                    if ($delivery && $delivery->type == 'agent') {
                        if ($agentPrice = AgentPrice::where(['agent_id' => $delivery->id, 'govern_id' => $order->province_id])->first()) {
                            $data['agent_shipping'] = $agentPrice->value;
                            $data['total_value'] = (int) $agentPrice->value + (int) $order->shipment_value;
                        } else {
                            return response()->json([
                                'code' => 404,
                                'message' => ' من فضلك أدخل أسعار شحن الوكيل ' . $delivery->name,
                            ]);
                        }
                    }
                }

                $order->update($data);
            }
            return response()->json(
                [
                    'code' => 200,
                    'message' => 'تمت العملية بنجاح!',
                ]
            );
        }
    }

    public function printOrderDetails(Request $request)
    {
        $orders = Order::whereIn('id', $request->order_id)->with('province.country')->get();
        $view = view('Admin.CRUDS.Orders.print', compact('orders'))->render();

        return response()->json(['html' => $view]);
    }
}
