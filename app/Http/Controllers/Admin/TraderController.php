<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Area;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TraderController extends Controller
{
    use Upload_Files, LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض بيانات التجار')->only('index', 'getTraders');
        $this->middleware('permission:تعديل بيانات التجار')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء بيانات التجار')->only(['create', 'store', 'addOrderToTrader']);
        $this->middleware('permission:حذف بيانات التجار')->only('destroy');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = Trader::query()->latest()->with(['category']);
            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل بيانات التجار')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف بيانات التجار')) {
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
                ->editColumn('logo', function ($row) {
                    return ' <img height="60px" src="' . get_file($row->logo) . '" class=" w-60 rounded"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('phone', function ($row) {
                    return '<a href="tel:' . $row->phone . '">' . $row->phone . '</a>';
                })
                ->editColumn('competent_phone', function ($row) {
                    return '<a href="tel:' . $row->competent_phone . '">' . $row->competent_phone . '</a>';
                })
                ->editColumn('fax', function ($row) {
                    return '<a href="fax' . $row->fax . '">' . $row->fax . '</a>';
                })
                ->addcolumn('addOrder', function ($row) {
                    $url = route('admin.addOrderToTrader', $row->id);
                    return "<a href='$url' class='btn btn-outline-dark' >اضافة طلب</a>";
                })
                ->editColumn('category_id', function ($row) {
                    return $row->category->title ?? '';
                })
                ->editColumn('created_at', function ($row) {
                    return date('Y/m/d', strtotime($row->created_at));
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  التجار");

        }
        return view('Admin.CRUDS.traders.index');
    }

    public function create()
    {

        $categories = Category::get();
        return view('Admin.CRUDS.traders.parts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'user_name' => 'required|unique:traders,user_name',
            'password' => 'required',
            'debt' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'fax' => 'nullable|unique:traders,fax',
            'address' => 'nullable',
            'competent_phone' => 'nullable',
            'competent_name' => 'nullable',
            'phone' => 'required|unique:traders,phone',
            'logo' => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif',
            'is_collectible'=>'required|in:0,1'

        ]);
        if ($request->logo) {
            $data["logo"] = $this->uploadFiles('traders', $request->file('logo'), null);
        }

        $data['password'] = bcrypt($request->password);

        $trader = Trader::create($data);

        $this->add_log_activity($trader, auth('admin')->user(), " تم اضافة تاجر  باسم $trader->name ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {

        $row = Trader::findOrFail($id);
        $categories = Category::get();

        return view('Admin.CRUDS.traders.parts.edit', compact('row', 'categories'));

    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'user_name' => 'required|unique:traders,user_name,' . $id,
            'password' => 'nullable',
            'debt' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'fax' => 'nullable|unique:traders,fax,' . $id,
            'address' => 'nullable',
            'competent_phone' => 'nullable',
            'competent_name' => 'nullable',
            'phone' => 'required|unique:traders,phone,' . $id,
            'logo' => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif',
            'is_collectible'=>'required|in:0,1'

        ]);
        $row = Trader::findOrFail($id);

        if ($request->logo) {
            $data["logo"] = $this->uploadFiles('traders', $request->file('logo'), null);
        }

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $row->password;
        }

        $old = $row;

        $row->update($data);

        $this->add_log_activity($old, auth('admin')->user(), " تم تعديل بيانات   التاجر $row->name ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy($id)
    {
        $row = Trader::findOrFail($id);

        $old = $row;

        $row->delete();

        $this->add_log_activity($old, auth('admin')->user(), " تم حذف تاجر  باسم $old->name ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    } //end fun

    public function addOrderToTrader($id)
    {
        $trader = Trader::findOrFail($id);
        $provinces = Area::where('from_id', '!=', null)->get();
        $delivers = Delivery::get();

        return view('Admin.CRUDS.traders.order.create', compact('trader', 'provinces', 'delivers'));

    }

    public function storeOrderToTrader($id, Request $request)
    {

        $trader = Trader::findOrFail($id);
        $trans = $this->validate($request, [
//            'delivery_id' => 'nullable|array',
//            'delivery_id.*' => 'nullable',
            'customer_address' => 'required|array',
            'customer_address.*' => 'required',
            'customer_name' => 'required|array',
            'customer_name.*' => 'required',
            'customer_phone' => 'required|array',
            'customer_phone.*' => 'required',
            'delivery_ratio' => 'nullable|array',
            'delivery_ratio.*' => 'nullable',
//            'delivery_time' => 'required|array',
//            'delivery_time.*' => 'required',
            'delivery_value' => 'required|array',
            'delivery_value.*' => 'nullable',
            'province_id' => 'nullable|array',
            'province_id.*' => 'required',
            'shipment_pieces_number' => 'nullable|array',
            'shipment_pieces_number.*' => 'nullable',
            'shipment_value' => 'nullable|array',
            'shipment_value.*' => 'nullable',
            'notes' => 'required',
            'trader_collection' => 'required',
        ]);
        $sql = [];
        if ($request->customer_name) {
            for ($i = 0; $i < count($request->customer_name); $i++) {
                $status = 'new';

                $total_value = 0;

                $delivery_id = null;

                $total_value = $total_value + (int) $request->delivery_value[$i] + (int) $request->shipment_value[$i];

                if ($request->delivery_id[$i] != null) {
                    if ($request->delivery_id[$i] != 0) {
                        $status = 'converted_to_delivery';
                        $delivery_id = $request->delivery_id[$i];

                    }
                }

                $row = [];

                $row = [
                    'trader_id' => $id,
                    'status' => $status,
                    'shipment_value' => $request->shipment_value[$i],
                    'shipment_pieces_number' => $request->shipment_pieces_number[$i],
                    'province_id' => $request->province_id[$i],
                    'delivery_value' => $request->delivery_value[$i],
//                    'delivery_time' => $request->delivery_time[$i],
                    'delivery_ratio' => $request->delivery_ratio[$i],
                    'customer_phone' => $request->customer_phone[$i],
                    'customer_name' => $request->customer_name[$i],
                    'customer_address' => $request->customer_address[$i],
                    'delivery_id' => $delivery_id,
                    'notes' => $request->notes[$i],
                    'trader_collection' => $request->trader_collection[$i],

                    'total_value' => $total_value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),

                ];

                array_push($sql, $row);

            }
        }

        DB::table('orders')->insert($sql);

        $this->add_log_activity(null, auth('admin')->user(), "  تم اضافة طلبات   ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function getTraders(Request $request)
    {

        if ($request->ajax()) {

            $term = trim($request->term);
            $posts = DB::table('traders')->whereNull('deleted_at')->select('id', 'name as text')
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
