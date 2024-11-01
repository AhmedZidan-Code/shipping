<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Exports\AgentOrderFormExport;
use App\Http\Controllers\Controller;
use App\Imports\AgentOrderImport;
use App\Models\Order;
use App\Models\Temporary;
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

            Temporary::truncate();
            foreach ($ordersAfterTransform as $key => $row) {
                abort_if(!$row['customer_phone'], 421, ' لايوجد بيانات هاتف عميل للصف رقم' . $key + 1);
                Temporary::create([
                    'customer_name' => $row['customer_name'],
                    'customer_phone' => $row['customer_phone'],
                    'total' => $row['total'],
                ]);
            }

            $convertedOrders = Order::select('orders.*', 'temporaries.customer_name as excel_name', 'temporaries.customer_phone as excel_phone', 'temporaries.total as excel_total')
                ->join('temporaries', 'orders.customer_phone', '=', 'temporaries.customer_phone')
                ->where('orders.status', 'converted_to_delivery')
                ->where('orders.delivery_id', $request->agent_id)
                ->whereIn('orders.id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('orders')
                        ->where('status', 'converted_to_delivery')
                        ->groupBy('customer_phone');
                })
                ->with(['province', 'trader', 'delivery'])
                ->orderBy('orders.created_at', 'desc')
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

    public function updateOrders(Request $request)
    {
        $validateData = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|exists:orders,id',
            'total_value' => 'required|array',
            'total_value.*' => 'required|numeric',
        ]);

        foreach ($validateData['ids'] as $index => $id) {
            Order::where('id', $id)->update([
                'total_value' => $validateData['total_value'][$index],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث القيم بنجاح',
        ]);

    }
}
