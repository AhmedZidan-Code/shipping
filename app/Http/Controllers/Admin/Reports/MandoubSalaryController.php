<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MandoubSalaryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $salaries = Salary::query()->with('delivery')->orderBy('delivery_id');

            if ($request->month) {
                $salaries->where('month', $request->month);
            }
            
            if ($request->delivery_id) {
                $salaries->where('delivery_id', $request->delivery_id);

            }

            return DataTables::of($salaries)
                ->editColumn('created_at', function ($row) {
                    return date('Y/m/d', strtotime($row->created_at));
                })
                ->escapeColumns([])
                ->make(true);

        }
        return view('Admin.reports.salaries.index');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'delivery_id' => 'required|exists:deliveries,id',
            'month' => 'required|integer|min:1|max:12',
            'base_salary' => 'required|numeric|min:0',
            'total_salary' => 'required|numeric|min:0',
            'orders_count' => 'required|integer|min:0',
            'company_profit' => 'required|numeric|min:0',
            'delivery_shipping' => 'required|numeric|min:0',
            'shipping_after_fees' => 'required|numeric|min:0',
            'delivery_fees' => 'required|numeric|min:0',
            'solar' => 'required|numeric|min:0',
            'expenses' => 'required|numeric|min:0',
        ]);

        $validatedData['year'] = date('Y');
        Salary::updateOrCreate([
            'delivery_id' => $validatedData['delivery_id'],
            'month' => $validatedData['month'],
            'year' => $validatedData['year'],
        ], $validatedData);

        // Return a JSON response indicating success
        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الراتب بنجاح.',
        ], 201);
    }
}
