<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Exports\AgentOrderFormExport;
use App\Http\Controllers\Controller;
use App\Imports\AgentOrderImport;
use App\Models\AgentPrice;
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
            $this->addDataToTemporary($ordersAfterTransform, $request->agent_id);
            $convertedOrders = Temporary::with('order')
                ->with(['order.province', 'order.trader', 'order.delivery'])
                ->get();

            $view = view('Admin.CRUDS.Orders.newOrders.parts.agent.table', ['convertedOrders' => $convertedOrders])->render();

            return response()->json(
                [
                    'view' => $view,
                    'code' => 200,
                    'message' => 'تم سحب البيانات بنجاح!',
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'code' => 400,
                    'message' => $e->getMessage(),
                    'error' => $e,
                ]
            );
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
            'total_shipping' => 'required|numeric',
            'agent_value' => 'required|numeric',
            'total_orders' => 'required|numeric',
            'total_from_agent' => 'required|numeric',
            'commission' => 'required|numeric',
            'cash' => 'required|numeric|lte:total_from_agent',
            'cheque' => 'required|numeric|lte:total_from_agent',
            'month' => 'required',
            'ids' => 'required|array',
            'ids.*' => 'required|exists:orders,id',
            'delivery_value'=> 'required|array',
            'agent_details'=> 'required|array',
            'total_value'=> 'required|array',
        ]);
        $sum = $request->cash + $request->cheque;
        if ($sum > $request->total_from_agent) {
            return response()->json([
                'code' => 422,
                'message' => 'لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ',
                'errors' => [
                    'sum' => ['لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ'],
                ],
            ], 422);
        }

        $status = [];
        foreach ($validateData['ids'] as $index => $id) {
            Order::where('id', $id)->update([
                'delivery_value' => $validateData['delivery_value'][$index],
                'agent_shipping' => $validateData['delivery_value'][$index],
                'agent_details' => $validateData['agent_details'][$index],
                'total_value' => $validateData['total_value'][$index],
                'status' => 'total_delivery_to_customer',
            ]);

            $status[] = "total_delivery_to_customer";
        }
        try {
            DB::beginTransaction();

            $row = DB::table('deliveries')->where('id', $request->agent_id)->first();
            $setting_mandoub_commission = $row->commission;

            // Insert into delivery_orders and get the last inserted ID
            $lastInsertedId = DB::table('delivery_orders')->insertGetId([
                'delivery_id' => $request->agent_id,
                'delivery_type' => 'agent',
                'num_all_orders' => $request->all_orders,
                'num_mandoub_orders' => $request->mandoub_orders,
                'total_shipping' => $request->total_shipping,
                'setting_mandoub_commission' => $setting_mandoub_commission,
                'type_paid' => 3,
                'mandoub_commission' => $request->agent_value,
                'company_commission' => $request->commission,
                'commission_after_fees' => $request->commission,
                'fees' => $request->agent_value,
                'solar' => 0,
                'total_orders' => $request->total_orders,
                'cash' => $request->cash,
                'cheque' => $request->cheque,
                'orders_id' => json_encode($request->ids),
                'status_id' => json_encode($status),
                'year' => date('Y'),
                'month' => $request->month,
                'date_time' => Carbon::now()->format('Y-m-d H:i:s'),
                'date' => date('Y-m-d'),
                'publisher' => auth()->id(),
            ]);
            $sql = [];
            if ($request->ids) {
                for ($i = 0; $i < count($request->ids); $i++) {
                    $row = [
                        'main_table_id' => $lastInsertedId,
                        'delivery_id' => $request->agent_id,
                        'status' => "total_delivery_to_customer",
                        'order_id' => $request->ids[$i],
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
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'code' => 500,
                'message' => 'حدث خطأ ما: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function addDataToTemporary(array $ordersAfterTransform, $agent_id = null)
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
                    'agent_value' => $customer->delivery_value,
                    'total' => $customer->total_value,
                ]);
            }
        }
    }
}
