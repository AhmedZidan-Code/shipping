<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\OpeningBalance;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OpeningBalanceController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض الرصيد الافتتاحي')->only(['index']);
        $this->middleware('permission:تعديل الرصيد الافتتاحي')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء الرصيد الافتتاحي')->only(['create', 'store']);
        $this->middleware('permission:حذف الرصيد الافتتاحي')->only('destroy');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = OpeningBalance::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل الرصيد الافتتاحي')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف الرصيد الافتتاحي')) {
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
                ->escapeColumns([])
                ->make(true);
        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الرصيد الافتتاحي للخزنة");
        }
        return view('Admin.CRUDS.opening_balance.index', ['count' => OpeningBalance::count()]);
    }

    public function create()
    {
        abort_if(OpeningBalance::count() >= 1, 404);
        return view('Admin.CRUDS.opening_balance.parts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cash' => 'required|numeric',
            'cheque' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d',

        ]);
        $data['balance'] = $data['cash'] + $data['cheque'];
        $balance = OpeningBalance::create($data);

        $this->add_log_activity($balance, auth('admin')->user(), " تم اضافة الرصيد الافتتاحي ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function edit($id)
    {

        $row = OpeningBalance::findOrFail($id);

        return view('Admin.CRUDS.opening_balance.parts.edit', ['row' => $row]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cash' => 'required|numeric',
            'cheque' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $row = OpeningBalance::findOrFail($id);

        $data['balance'] = $data['cash'] + $data['cheque'];
        $row->update($data);

        $this->add_log_activity($row, auth('admin')->user(), " تم تعديل الرصيد الافتتاحي ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    }

    public function destroy($id)
    {
        $row = OpeningBalance::findOrFail($id);
        $old = $row;
        $this->add_log_activity($old, auth('admin')->user(), "تم  حذف بيانات الرصيد الافتتاحي للخزنة ");

        $row->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]
        );
    } //end fun
}
