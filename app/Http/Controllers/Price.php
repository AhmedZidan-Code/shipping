<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PriceController extends Controller
{
    use LogActivityTrait;

    function __construct()
    {
        $this->middleware('permission:عرض اعدادات المناطق', ['only' => ['index']]);
        $this->middleware('permission:الاضافة في اعدادات مناطق', ['only' => ['create', 'store']]);
        $this->middleware('permission:التعديل في اعدادات مناطق', ['only' => ['edit', 'update']]);
        $this->middleware('permission:الحذف في اعدادات المناطق', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = Area::query()->latest()->where('from_id', '!=', null);
            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';


                    if (!auth()->user()->can('التعديل في اعدادات مناطق'))
                        $edit = 'hidden';
                    if (!auth()->user()->can('الحذف في اعدادات المناطق'))
                        $delete = 'hidden';


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
                ->editColumn('from_id', function ($row) {
                    return $row->country->title ?? '';
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  المحافظات");

        }
        return view('Admin.CRUDS.areas.provinces.index');
    }


    public function create()
    {
        $countries = Area::where('from_id', null)->get();

        return view('Admin.CRUDS.areas.provinces.parts.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'from_id' => 'required|exists:areas,id',

        ]);


        $row = Area::create($data);

        $this->add_log_activity($row, auth('admin')->user(), " تم اضافة محافظة  باسم $row->title ");


        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);
    }


    public function edit($id)
    {

        $row = Area::findOrFail($id);

        $countries = Area::where('from_id', null)->get();


        return view('Admin.CRUDS.areas.provinces.parts.edit', compact('row', 'countries'));

    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'from_id' => 'required|exists:areas,id',

        ]);

        $row = Area::findOrFail($id);

        $old = $row;

        $row->update($data);

        $this->add_log_activity($old, auth('admin')->user(), " تم تعديل محافظة  باسم $row->title ");


        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }


    public function destroy($id)
    {

        $row = Area::findOrFail($id);

        $old = $row;

        $row->delete();
        $this->add_log_activity($old, auth('admin')->user(), "تم  حذف بيانات المحافظة   $old->title ");


        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!'
            ]);
    }//end fun


    public function getGovernorates(Request $request)
    {

        if ($request->ajax()) {

            $term = trim($request->term);
            $posts = DB::table('areas')->whereNull('deleted_at')->where('from_id', '!=', null)->select('id', 'title as text')
                ->where('title', 'LIKE', '%' . $term . '%')
                ->orderBy('title', 'asc')->simplePaginate(3);

            $morePages = true;
            $pagination_obj = json_encode($posts);
            if (empty($posts->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $posts->items(),
                "pagination" => array(
                    "more" => $morePages
                )
            );

            return \Response::json($results);

        }


    }
}
