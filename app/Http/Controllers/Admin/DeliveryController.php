<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DeliveryController extends Controller
{
    use Upload_Files, LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض بيانات المناديب')->only(['index', 'getDeliveries']);
        $this->middleware('permission:تعديل بيانات المناديب')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء بيانات المناديب')->only(['create', 'store']);
        $this->middleware('permission:حذف بيانات المناديب')->only('destroy');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = Delivery::query()->latest();
            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل بيانات المناديب')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف بيانات المناديب')) {
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

                ->editColumn('image', function ($row) {
                    return ' <img height="60px" src="' . get_file($row->image) . '" class=" w-60 rounded"
                             onclick="window.open(this.src)">';
                })

                ->editColumn('email', function ($row) {
                    return '<a href="mailto:' . $row->email . '">' . $row->email . '</a>';
                })

                ->editColumn('phone1', function ($row) {
                    return '<a href="tel:' . $row->phone1 . '">' . $row->phone1 . '</a>';
                })

                ->editColumn('phone2', function ($row) {
                    return '<a href="tel:' . $row->phone2 . '">' . $row->phone2 . '</a>';
                })

                ->editColumn('whatsapp', function ($row) {
                    return '<a href="https://wa.me/' . $row->whatsapp . '">' . $row->whatsapp . '</a>';
                })

                ->editColumn('created_at', function ($row) {
                    return date('Y/m/d', strtotime($row->created_at));
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  المناديب");

        }
        return view('Admin.CRUDS.delivers.index');
    }

    public function create()
    {

        return view('Admin.CRUDS.delivers.parts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email|unique:deliveries,email',
            'phone1' => 'required|unique:deliveries,phone1',
            'phone2' => 'nullable|unique:deliveries,phone2',
            'whatsapp' => 'nullable|unique:deliveries,whatsapp',
            'address' => 'nullable',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif',
            'user_name' => 'required|unique:deliveries,user_name',
            'password' => 'required',
            'type_paid' => 'required',
            'salary' => 'required',
            'commission' => 'required',

        ]);

        $data['password'] = bcrypt($request->password);

        if ($request->image) {
            $data["image"] = $this->uploadFiles('delivers', $request->file('image'), null);
        }

        $delivery = Delivery::create($data);

        $this->add_log_activity($delivery, auth('admin')->user(), " تم اضافة مندوب  باسم $delivery->name ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {
        $row = Delivery::findOrFail($id);

        return view('Admin.CRUDS.delivers.parts.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email|unique:deliveries,email,' . $id,
            'phone1' => 'required|unique:deliveries,phone1,' . $id,
            'phone2' => 'nullable|unique:deliveries,phone2,' . $id,
            'whatsapp' => 'nullable|unique:deliveries,whatsapp,' . $id,
            'address' => 'nullable',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif',
            'user_name' => 'required|unique:deliveries,user_name,' . $id,
            'password' => 'nullable',
            'type_paid' => 'required',
            'salary' => 'required',
            'commission' => 'required',

        ]);
        $row = Delivery::findOrFail($id);

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $row->password;
        }
        if ($request->image) {
            $data["image"] = $this->uploadFiles('delivers', $request->file('image'), null);
        }

        $old = $row;

        $row->update($data);

        $this->add_log_activity($old, auth('admin')->user(), " تم تعديل مندوب  باسم $row->name ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy($id)
    {
        $row = Delivery::findOrFail($id);

        $old = $row;

        $row->delete();

        $this->add_log_activity($old, auth('admin')->user(), " تم حذف مندوب  باسم $old->name ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    } //end fun

    public function getDeliveries(Request $request)
    {

        if ($request->ajax()) {

            $term = trim($request->term);
            $posts = DB::table('deliveries')->whereNull('deleted_at')->select('id', 'name as text')
                ->where('name', 'LIKE', '%' . $term . '%')
                ->orderBy('name', 'asc')->simplePaginate(3);

            $morePages = true;
            $pagination_obj = json_encode($posts);
            if (empty($posts->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $posts->items(),
                "pagination" => array(
                    "more" => $morePages,
                ),
            );

            return \Response::json($results);

        }

    }

}