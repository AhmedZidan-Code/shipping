<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Area;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض المحافظات')->only(['index']);
        $this->middleware('permission:تعديل المحافظات')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء المحافظات')->only(['create', 'store']);
        $this->middleware('permission:حذف المحافظات')->only('destroy');
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Area::query()->latest()->where('from_id',null);
            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit='';
                    $delete='';

                    if(!auth()->user()->can('تعديل المحافظات'))
                        $edit='hidden';
                    if(!auth()->user()->can('حذف المحافظات'))
                        $delete='hidden';


                    return '
                            <button '.$edit.'  class="editBtn btn rounded-pill btn-primary waves-effect waves-light"
                                    data-id="' . $row->id . '"
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </span>
                            </button>
                            <button '.$delete.'  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </span>
                            </button>
                       ';



                })






                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        else{
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الدول");

        }
        return view('Admin.CRUDS.areas.countries.index');
    }


    public function create()
    {

        return view('Admin.CRUDS.areas.countries.parts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',

        ]);


     $country=   Area::create($data);

        $this->add_log_activity($country,auth('admin')->user()," تم اضافة دولة باسم $country->title ");


        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);
    }



    public function edit($id)
    {



        $row=Area::findOrFail($id);

        return view('Admin.CRUDS.areas.countries.parts.edit', compact('row'));

    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',

        ]);

        $row=Area::findOrFail($id);

        $old=$row;

        $row->update($data);

        $this->add_log_activity($old,auth('admin')->user(),"تم  تعديل بيانات الدولة  $row->title ");


        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }


    public function destroy( $id)
    {
        $row=Area::findOrFail($id);
        $old=$row;
        $this->add_log_activity($old,auth('admin')->user(),"تم  حذف بيانات الدولة  $row->title ");


        $row->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);
    }//end fun

}
