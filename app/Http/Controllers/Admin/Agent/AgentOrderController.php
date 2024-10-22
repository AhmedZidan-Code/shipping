<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Exports\AgentOrderFormExport;
use App\Http\Controllers\Controller;
use App\Imports\AgentOrderImport;
use Illuminate\Http\Request;
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
            'trader_id' => 'required',
            'agent_id' => 'required',
        ]);
        try {
            Excel::import(new AgentOrderImport, $request->file('file'));

            return response()->json(
                [
                    'code' => 200,
                    'message' => 'تمت العملية بنجاح!',
                ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'code' => 400,
                    'message' => $e->getMessage(),
                ]);
        }

    }
}
