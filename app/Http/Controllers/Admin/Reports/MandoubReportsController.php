<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Delivery;
use App\Models\Expenses;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MandoubReportsController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        //  $this->middleware('permission:عرض التقارير', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $deliveries = Delivery::get();
        return view('Admin.reports.mandoubs.index', compact('deliveries'));
    }

    public function get_delivery_orders(Request $request)
    {
        $rows = Order::query()->latest()->with(['province', 'trader', 'delivery']);

        if ($request->from_date) {
            $rows->where('converted_date', '>=', $request->from_date . ' ' . '00:00:00');
        }
        if ($request->to_date) {
            $rows->where('converted_date', '<=', $request->to_date . ' ' . '23:59:59');
        }

        if ($request->delivery_id) {
            $rows->where('delivery_id', $request->delivery_id);
        }
        if ($request->order_status != null) {
            $rows->where('status', $request->order_status);
        }

        $records = $rows->get();
        $delivery_id = $request->delivery_id;

        return view('Admin.reports.mandoubs.get_report', compact('records', 'delivery_id'));
    }

    public function add_delivery_orders(Request $request)
    {
        $validated = $request->validate([
            'delivery_id' => 'required',
            'all_orders' => 'required',
            'mandoub_orders' => 'required',
            'total_shipping' => 'required',
            'total_orders' => 'required',
            'cash' => 'required|numeric|lte:total_orders',
            'cheque' => 'required|numeric|lte:total_orders',
            'selectedValues' => 'required|array',
            'status' => 'required|array',
            'month' => 'required', // Ensure month is validated
            'fees' => 'required',
            'solar' => 'required',
            'day_date' => 'required|date',
        ]);

        // try {

        $sum = $request->cash + $request->cheque;
        if ($sum > $request->total_orders) {
            return response()->json([
                'code' => 422,
                'message' => 'لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ',
                'errors' => [
                    'sum' => ['لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ'],
                ],
            ], 422);
        }

        DB::beginTransaction();

        $row = DB::table('deliveries')->where('id', $request->delivery_id)->first();
        $setting_mandoub_commission = $row->commission;
        $commission = 0;

        if ($row->type_paid > 0) {
            $type_paid = $row->type_paid;
            if ($type_paid == 1) {
                $setting_mandoub_commission = 0;
                $commission = 0;
            } elseif ($type_paid == 2) {
                $setting_mandoub_commission = $row->commission;
                $commission = $row->commission * $request->mandoub_orders;
            } elseif ($type_paid == 3) {
                $setting_mandoub_commission = $row->commission;
                $commission = $row->commission * $request->mandoub_orders;
            }
        } else {
            return response()->json([
                'code' => 500,
                'message' => "قم بادخال اعدادات الراتب للمندوب",
            ], 500);
        }

        // Insert into delivery_orders and get the last inserted ID
        $lastInsertedId = DB::table('delivery_orders')->insertGetId([
            'delivery_id' => $request->delivery_id,
            'num_all_orders' => $request->all_orders,
            'num_mandoub_orders' => $request->mandoub_orders,
            'total_shipping' => $request->total_shipping,
            'setting_mandoub_commission' => $setting_mandoub_commission,
            'type_paid' => $type_paid,
            'mandoub_commission' => $commission,
            'company_commission' => $request->total_shipping - ($commission + $request->solar),
            'commission_after_fees' => $commission - $request->fees,
            'fees' => $request->fees,
            'solar' => $request->solar,
            'total_orders' => $request->total_orders,
            'cash' => $request->cash,
            'cheque' => $request->cheque,
            'orders_id' => json_encode($request->selectedValues),
            'status_id' => json_encode($request->status),
            'year' => date('Y'),
            'month' => $request->month,
            'date_time' => Carbon::now()->format('Y-m-d H:i:s'),
            'day_date' => $request->day_date,
            'date' => date('Y-m-d'),
            'publisher' => auth()->id(),
        ]);

        $sql = [];
        if ($request->selectedValues) {
            for ($i = 0; $i < count($request->selectedValues); $i++) {
                $row = [
                    'main_table_id' => $lastInsertedId,
                    'delivery_id' => $request->delivery_id,
                    'status' => $request->status[$i],
                    'order_id' => $request->selectedValues[$i],
                    'month' => $request->month,
                    'date_time' => Carbon::now()->format('Y-m-d H:i:s'),
                    'date' => date('Y-m-d'),
                    'publisher' => auth()->id(),
                ];
                array_push($sql, $row);
            }
        }

        DB::table('delivery_orders_details')->insert($sql);

        DB::commit();

        return response()->json([
            'code' => 200,
            'message' => 'تمت العملية بنجاح!',
        ]);
        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     return response()->json([
        //         'code' => 500,
        //         'message' => 'حدث خطأ ما: ' . $e->getMessage(),
        //     ], 500);
        // }
    }

    //====================================================================================================================

    public function mandoub_orders(Request $request)
    {
        $deliveries = DB::table('deliveries')->whereNull('deleted_at')->get();

        if ($request->delivery_id) {
            $salary = DB::table('deliveries')->where('id', $request->delivery_id)->first()->salary;
        } else {
            $salary = 0;
        }
        if ($request->ajax()) {
            $rows = DB::table('delivery_orders');

            $condition = [];
            if ($request->delivery_id) {
                $rows->where('delivery_id', $request->delivery_id);
            }
            if ($request->month) {
                $rows->where('month', $request->month)->where('delivery_orders.year', '!=', 2023);
            }
            $rows->join('deliveries', 'deliveries.id', '=', 'delivery_orders.delivery_id')
                ->select('delivery_orders.*', 'deliveries.name')
                ->orderBy('delivery_orders.id', 'desc');

            $fees = $rows->get()->sum(function ($row) {
                return $row->fees;
            });
            $expenses = Expenses::query()
                ->whereNotNull('delivery_id')
                ->when($request->delivery_id, function ($query) use ($request) {
                    $query->where('delivery_id', $request->delivery_id);
                })
                ->when($request->month, function ($query) use ($request) {
                    $query->whereRaw('MONTH(date) = ?', [$request->month]);
                })
                ->sum('value');

            $mandoub_commission = $rows->get()->sum(function ($row) {
                return $row->mandoub_commission;
            });
            $ordersCount = $rows->get()->sum(function ($row) {
                return $row->num_mandoub_orders;
            });

            $solar = $rows->get()->sum(function ($row) {
                return $row->solar;
            });

            $commission_after_fees = $rows->get()->sum(function ($row) {
                return $row->commission_after_fees;
            });
            $company_commission = $rows->get()->sum(function ($row) {
                return $row->company_commission;
            });
            $profit = $company_commission -  ($salary);

            $dataTable = DataTables::of($rows)
                ->editColumn('orderDetails', function ($row) {
                    $url = route('admin.get_order_mandoub_details', $row->id);
                    return '<a href=' . $url . ' target="_blank" class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                })

                ->with('fees', function () use ($fees) {
                    return $fees;
                })
                ->with('mandoub_commission', function () use ($mandoub_commission) {
                    return $mandoub_commission;
                })
                ->with('commission_after_fees', function () use ($commission_after_fees) {
                    return $commission_after_fees;
                })

                ->with('salary', function () use ($salary) {
                    return $salary;
                })
                ->with('orders_count', function () use ($ordersCount) {
                    return $ordersCount;
                })
                ->with('solar', function () use ($solar) {
                    return $solar;
                })
                ->with('profit', function () use ($profit) {
                    return $profit;
                })
                ->with('solar', function () use ($solar) {
                    return $solar;
                })
                ->with('company_commission', function () use ($company_commission) {
                    return $company_commission;
                })
                ->with('expenses', $expenses)
                ->escapeColumns([])
                ->make(true);

            return $dataTable;
        }

        return view('Admin.reports.mandoubs.mandoub_orders', compact('request', 'deliveries'));
    }

    public function get_order_mandoub_details($order_id)
    {
        $records = DB::table('delivery_orders_details')
            ->join('orders', 'orders.id', '=', 'delivery_orders_details.order_id')
            ->join('traders', 'orders.trader_id', '=', 'traders.id')
            ->where('delivery_orders_details.main_table_id', $order_id)
            ->select('delivery_orders_details.*', 'orders.customer_name', 'orders.customer_address', 'orders.customer_phone', 'traders.name', 'orders.total_value', 'orders.partial_value') // Select all columns from both tables, or specify the columns you need
            ->get();
        return view('Admin.reports.mandoubs.get_order_mandoub_details', compact('records'));
    }

    public function change_button(Request $request)
    {
        $row = Order::find($request->row_id);

        $arr = array(
            'converted_to_delivery' => 'محول الي مندوب',
            'partial_delivery_to_customer' => 'تسليم جزئي',
            'not_delivery' => 'عدم استلام',
            'total_delivery_to_customer' => 'تم التسليم',
            'collection' => 'تحصيل',
            'delaying' => 'مؤجل',
            'cancel' => 'ملغي',
            'under_implementation' => 'تحت  التنفيذ',
            'new' => 'جديد',
            'paid' => 'تم الدفع',
        );
        if ($row) {

            if ($request->status == 'new') {
                echo ' <button class="btn btn-info insertDelivery" data-id= "' . $row->id . '">' . $arr[$request->status] . '</button>';
            } elseif ($request->status == 'converted_to_delivery') {
                echo '<button class="btn btn-primary changeStatusData" data-id= "' . $row->id . '">' . $arr[$request->status] . '</button>';
            } elseif ($request->status == 'total_delivery_to_customer') {
                echo '<button class="btn btn-success StatusTotalDelivery" data-id= "' . $row->id . '">' . $arr[$request->status] . '</button>';
            } elseif ($request->status == 'not_delivery') {
                echo '<td id="td' . $row->id . '"> <button class="btn btn-danger StatusNotDelivery" data-id= "' . $row->id . '">' . $arr[$request->status] . '</button> </td>';
            } elseif ($request->status == 'cancel') {
                echo '<td id="td' . $row->id . '"> <button class="btn btn-danger StatusCancel" data-id= "' . $row->id . '">' . $arr[$request->status] . '</button> </td>';
            } elseif ($request->status == 'delaying') {
                echo '<td id="td' . $row->id . '"> <button class="btn btn-warning StatusDelaying" data-id= "' . $row->id . '">' . $arr[$request->status] . '</button> </td>';
            } elseif ($request->status == 'partial_delivery_to_customer') {
                echo '<td id="td' . $row->id . '"> <button class="btn btn-warning StatusPartialDelivery" data-id= "' . $row->id . '">' . $arr[$request->status] . '</button> </td>';
            } else {
                echo '<td id="td' . $row->id . '"> <button class="btn btn-info info" data-id= "' . $row->id . '">' . $arr[$request->status] . '</button> </td>';
            }
        } else {
            return response()->json(['error' => 'Order not found'], 404);
        }
    }
}
