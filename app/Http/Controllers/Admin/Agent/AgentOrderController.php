<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Exports\AgentOrderFormExport;
use App\Http\Controllers\Controller;
use App\Imports\AgentOrderImport;
use App\Models\Order;
use App\Models\Temporary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AgentOrderController extends Controller
{
    public function exportExcel()
    {
        return view('Admin.CRUDS.Orders.newOrders.parts.agent.import');
    }
    public function exportForm()
    {
        return Excel::download(new AgentOrderFormExport, 'orders-form.xlsx');
    }
    public function importOrders(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
            'agent_id' => 'required',
        ]);
        try {
            $orders = Excel::toArray(new AgentOrderImport, $request->file('file'));
            $ordersAfterTransform = $this->transformArrayKeys($orders[0]);
            $this->addDataToTemporary($ordersAfterTransform);
            $convertedOrders = Temporary::with('order')
                ->with(['order.province', 'order.trader', 'order.delivery'])
                ->get();

            $view = view('Admin.CRUDS.Orders.newOrders.parts.agent.table', ['convertedOrders' => $convertedOrders])->render();

            return response()->json(
                [
                    'view' => $view,
                    'code' => 200,
                    'message' => 'تم سحب البيانات بنجاح!',
                ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'code' => 400,
                    'message' => $e->getMessage(),
                    'error' => $e,
                ]);
        }

    }

    public function transformArrayKeys($inputArray)
    {
        $keyMap = [
            'hal_altlb' => 'status',
            'rkm_almdyn' => 'province_id',
            'asm_alaamyl' => 'customer_name',
            'aanoan_alaamyl' => 'customer_address',
            'hatf_alaamyl' => 'customer_phone',
            'kym_almndob' => 'delivery_ratio',
            'kym_altosyl' => 'delivery_value',
            'aadd_alktaa_dakhl_alshhn' => 'shipment_pieces_number',
            'kym_alaordr' => 'shipment_value',
            'mlahthat' => 'notes',
            'alagmaly' => 'total',
        ];

        return array_map(function ($item) use ($keyMap) {
            $transformed = [];
            foreach ($item as $key => $value) {
                $newKey = array_key_exists($key, $keyMap) ? $keyMap[$key] : $key;
                $transformed[$newKey] = $value;
            }
            return $transformed;
        }, $inputArray);
    }

    public function addAgentOrders(Request $request)
    {
        $validateData = $request->validate([
            'agent_id' => 'required',
            'all_orders' => 'required',
            'mandoub_orders' => 'required',
            'total_shipping' => 'required',
            'total_orders' => 'required|numeric',
            'cash' => 'required|numeric',
            'cheque' => 'required|numeric',
            'month' => 'required',
            'ids' => 'required|array',
            'ids.*' => 'required|exists:orders,id',
            // 'total_value' => 'required|array',
            // 'total_value.*' => 'required|numeric',
        ]);

        foreach ($validateData['ids'] as $index => $id) {
            Order::where('id', $id)->update([
                // 'total_value' => $validateData['total_value'][$index],
                'status' => 'total_delivery_to_customer',
            ]);
        }

        // try {
            DB::beginTransaction();

            $row = DB::table('deliveries')->where('id', $request->agent_id)->first();
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
                'delivery_id' => $request->agent_id,
                'num_all_orders' => $request->all_orders,
                'num_mandoub_orders' => $request->mandoub_orders,
                'total_shipping' => $request->total_shipping,
                'setting_mandoub_commission' => $setting_mandoub_commission,
                'type_paid' => $type_paid,
                'mandoub_commission' => $commission,
                'company_commission' => $request->total_shipping - $commission,
                'commission_after_fees' => $commission - $request->fees,
                'fees' => 0,
                'solar' => 0,
                'total_orders' => $request->total_orders,
                'cash' => $request->cash,
                'cheque' => $request->cheque,
                'orders_id' => json_encode($request->ids),
                // 'status_id' => json_encode($request->status),
                'year' => date('Y'),
                'month' => $request->month,
                'date_time' => Carbon::now()->addHours(1)->format('Y-m-d H:i:s'),
                'date' => date('Y-m-d'),
                'publisher' => auth()->id(),
            ]);
            $sql = [];
            if ($request->ids) {
                for ($i = 0; $i < count($request->ids); $i++) {
                    $row = [
                        'main_table_id' => $lastInsertedId,
                        'delivery_id' => $request->agent_id,
                        // 'status' => $request->status[$i],
                        'order_id' => $request->ids[$i],
                        'month' => $request->month,
                        'date_time' => Carbon::now()->addHours(1)->format('Y-m-d H:i:s'),
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

    public function addDataToTemporary(array $ordersAfterTransform)
    {
        Temporary::truncate();
        foreach ($ordersAfterTransform as $key => $row) {
            ++$key;
            abort_if(!$row['customer_phone'], 421, ' لايوجد بيانات هاتف عميل للصف رقم' . $key);
            $customer = Order::where('customer_phone', 'like', '%' . $row['customer_phone'] . '%')
            // ->where('customer_name', 'like', '%' . $row['customer_name'] . '%')
            // ->where('status', 'converted_to_delivery')
                ->latest()->first();

            if (!$customer) {
                Temporary::create([
                    'customer_name' => $row['customer_name'],
                    'customer_phone' => $row['customer_phone'],
                    'agent_value' => $row['delivery_value'],
                    'total' => $row['total'],
                ]);
            } else {
                Temporary::create([
                    'customer_name' => $customer->customer_name,
                    'customer_phone' => $customer->customer_phone,
                    'agent_value' => $row['delivery_value'],
                    'total' => $row['total'],
                ]);
            }
        }
    }

    // public function add_delivery_orders(Request $request)
    // {

    //     try {
    //         $validated = $request->validate([
    //             'agent_id' => 'required',
    //             'all_orders' => 'required',
    //             'mandoub_orders' => 'required',
    //             'total_shipping' => 'required',
    //             'total_orders' => 'required',
    //             'selectedValues' => 'required|array',
    //             'status' => 'required|array',
    //             'month' => 'required', // Ensure month is validated
    //             'fees' => 'required',
    //             'solar' => 'required',
    //         ]);

    //         DB::beginTransaction();

    //         $row = DB::table('deliveries')->where('id', $request->agent_id)->first();
    //         $setting_mandoub_commission = $row->commission;
    //         $commission = 0;

    //         if ($row->type_paid > 0) {
    //             $type_paid = $row->type_paid;
    //             if ($type_paid == 1) {
    //                 $setting_mandoub_commission = 0;
    //                 $commission = 0;
    //             } elseif ($type_paid == 2) {
    //                 $setting_mandoub_commission = $row->commission;
    //                 $commission = $row->commission * $request->mandoub_orders;
    //             } elseif ($type_paid == 3) {
    //                 $setting_mandoub_commission = $row->commission;
    //                 $commission = $row->commission * $request->mandoub_orders;
    //             }
    //         } else {
    //             return response()->json([
    //                 'code' => 500,
    //                 'message' => "قم بادخال اعدادات الراتب للمندوب",
    //             ], 500);

    //         }

    //         // Insert into delivery_orders and get the last inserted ID
    //         $lastInsertedId = DB::table('delivery_orders')->insertGetId([
    //             'delivery_id' => $request->agent_id,
    //             'num_all_orders' => $request->all_orders,
    //             'num_mandoub_orders' => $request->mandoub_orders,
    //             'total_shipping' => $request->total_shipping,
    //             'setting_mandoub_commission' => $setting_mandoub_commission,
    //             'type_paid' => $type_paid,
    //             'mandoub_commission' => $commission,
    //             'company_commission' => $request->total_shipping - ($commission + $request->solar),
    //             'commission_after_fees' => $commission - $request->fees,
    //             'fees' => $request->fees,
    //             'solar' => $request->solar,
    //             'total_orders' => $request->total_orders,
    //             'orders_id' => json_encode($request->selectedValues),
    //             'status_id' => json_encode($request->status),
    //             'year' => date('Y'),
    //             'month' => $request->month,
    //             'date_time' => Carbon::now()->addHours(1)->format('Y-m-d H:i:s'),
    //             'date' => date('Y-m-d'),
    //             'publisher' => auth()->id(),
    //         ]);

    //         $sql = [];
    //         if ($request->selectedValues) {
    //             for ($i = 0; $i < count($request->selectedValues); $i++) {
    //                 $row = [
    //                     'main_table_id' => $lastInsertedId,
    //                     'delivery_id' => $request->agent_id,
    //                     'status' => $request->status[$i],
    //                     'order_id' => $request->selectedValues[$i],
    //                     'month' => $request->month,
    //                     'date_time' => Carbon::now()->addHours(1)->format('Y-m-d H:i:s'),
    //                     'date' => date('Y-m-d'),
    //                     'publisher' => auth()->id(),
    //                 ];
    //                 array_push($sql, $row);
    //             }
    //         }

    //         DB::table('delivery_orders_details')->insert($sql);

    //         DB::commit();

    //         return response()->json([
    //             'code' => 200,
    //             'message' => 'تمت العملية بنجاح!',
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'code' => 500,
    //             'message' => 'حدث خطأ ما: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }
}
