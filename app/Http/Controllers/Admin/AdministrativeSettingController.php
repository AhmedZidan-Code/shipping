<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SettingType;
use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\AdministrativeSetting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdministrativeSettingController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض الاعدادات الإدارية')->only(['index']);
        $this->middleware('permission:تعديل الاعدادات الإدارية')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء الاعدادات الإدارية')->only(['create', 'store']);
        $this->middleware('permission:حذف الاعدادات الإدارية')->only('destroy');
    }



    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = AdministrativeSetting::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    

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
                ->editColumn('type', function ($row) {
                    return SettingType::getName($row->type);
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الاعدادات الادارية");

        }
        return view('Admin.CRUDS.administrative-setting.setting.index');
    }

    public function create()
    {

        return view('Admin.CRUDS.administrative-setting.setting.parts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'type' => 'required|in:' . implode(',', SettingType::getValues()),

        ]);
        
        $setting = AdministrativeSetting::create($data);

        $this->add_log_activity($setting, auth('admin')->user(), " تم اضافة اعدادات ادارية باسم $setting->title ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {

        $row = AdministrativeSetting::findOrFail($id);

        return view('Admin.CRUDS.administrative-setting.setting.parts.edit', compact('row'));

    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',

        ]);

        $row = AdministrativeSetting::findOrFail($id);

        $old = $row;

        $row->update($data);

        $this->add_log_activity($old, auth('admin')->user(), "تم  تعديل بيانات الاعدادات الادارية  $row->title ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy($id)
    {
        $row = AdministrativeSetting::findOrFail($id);
        $old = $row;
        $this->add_log_activity($old, auth('admin')->user(), "تم  حذف بيانات الاعدادات الادارية  $row->title ");

        $row->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    } //end fun

}
