<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SettingType;
use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\AdministrativeSetting;
use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Optional;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض المصروفات')->only(['index']);
        $this->middleware('permission:تعديل المصروفات')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء المصروفات')->only(['create', 'store']);
        $this->middleware('permission:حذف المصروفات')->only('destroy');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = Expenses::query()->with(['setting', 'admin', 'delivery'])->orderBy('updated_at', 'desc');;
            if ($request->expense_id) {
                $rows->where('setting_id', $request->expense_id);
            }
            if ($request->delivery_id) {
                $rows->where('delivery_id', $request->delivery_id);
            }
            if ($request->fromDate) {
                $rows->where('date', '>=', $request->fromDate);
            }
            if ($request->toDate) {
                $rows->where('date', '<=', $request->toDate);
            }
            $total = $rows->sum('value');
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل المصروفات')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف المصروفات')) {
                        $delete = 'hidden';
                    }

                    return '
                            <button ' . $edit . '  class="editBtn btn rounded-pill btn-primary waves-effect waves-light"
                                    data-id="' . $row->id . '"
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </span>
                            </button>
                            <button ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </span>
                            </button>
                       ';
                })
                ->addColumn('name', function ($row) {
                    return $row->admin->name;
                })
                ->addColumn('expense_category', function ($row) {
                    return $row->setting->title;
                })
                ->addColumn('delivery', function ($row) {
                    return Optional($row->delivery)->name;
                })
                ->with('total', $total)
                ->escapeColumns([])
                ->make(true);
        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  المصروفات");
        }
        $expensesTypes = AdministrativeSetting::where('type', SettingType::EXPENSES)->get();

        return view('Admin.CRUDS.administrative-setting.expenses.index', compact('expensesTypes'));
    }

    public function create()
    {

        return view('Admin.CRUDS.administrative-setting.expenses.parts.create', ['settings' => AdministrativeSetting::where('type', SettingType::EXPENSES)->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'delivery_id' => 'nullable|exists:deliveries,id',
            'value' => 'required|numeric',
            'setting_id' => 'required|exists:administrative_settings,id',
            'date' => 'required|date_format:Y-m-d',

        ]);

        $data['expense_by'] = $request->user()->id;

        $expense = Expenses::create($data);

        $this->add_log_activity($expense, auth('admin')->user(), " تم اضافة المصروفات ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function edit($id)
    {

        $row = Expenses::with('delivery')->findOrFail($id);

        return view('Admin.CRUDS.administrative-setting.expenses.parts.edit', ['row' => $row, 'settings' => AdministrativeSetting::where('type', SettingType::EXPENSES)->get()]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'delivery_id' => 'nullable|exists:deliveries,id',
            'value' => 'required|numeric',
            'setting_id' => 'required|exists:administrative_settings,id',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $row = Expenses::findOrFail($id);

        $old = $row;
        $data['expense_by'] = $request->user()->id;

        $row->update($data);

        $this->add_log_activity($old, auth('admin')->user(), "تم  تعديل بيانات المصروفات ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function destroy($id)
    {
        $row = Expenses::findOrFail($id);
        $old = $row;
        $this->add_log_activity($old, auth('admin')->user(), "تم  حذف بيانات المصروفات ");

        $row->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    } //end fun

}
