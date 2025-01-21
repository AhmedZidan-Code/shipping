<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Area;
use App\Models\Price;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PriceController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض أسعار الشحن')->only(['index']);
        $this->middleware('permission:تعديل أسعار الشحن')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء أسعار الشحن')->only(['create', 'store']);
        $this->middleware('permission:حذف أسعار الشحن')->only('destroy');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = Price::query()->with(['trader', 'govern'])->latest();
            return DataTables::of($rows)
                ->filterColumn('govern', function ($query, $keyword) {
                    $query->whereHas('govern', function ($q) use ($keyword) {
                        $q->where('title', 'like', '%' . $keyword . '%');
                    });
                })
                ->filterColumn('trader', function ($query, $keyword) {
                    $query->whereHas('trader', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    });
                })
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل أسعار الشحن')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف أسعار الشحن')) {
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
                ->editColumn('trader', function ($row) {
                    return $row->trader->name ?? '';
                })

                ->editColumn('govern', function ($row) {
                    return $row->govern->title ?? '';
                })
                ->editColumn('value', function ($row) {
                    return $row->value ?? '';
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  المحافظات");

        }
        return view('Admin.CRUDS.prices.index');
    }

    public function create()
    {
        $countries = Area::where('from_id', '=', null)->get();
        $traders = Trader::get();

        return view('Admin.CRUDS.prices.parts.create', compact('countries', 'traders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'govern_id' => 'required|exists:areas,id|array',
            'value' => 'required|array',
            'value.*' => 'required',

        ]);

        $count = count($request->govern_id);
        for ($x = 0; $x < $count; $x++) {
            if ($request->value[$x] > 0) {
                $price['trader_id'] = $request->trader_id;
                $price['govern_id'] = $request->govern_id[$x];
                $price['value'] = $request->value[$x];
                $row = Price::create($price);
                $this->add_log_activity($row, auth('admin')->user(), " تمت اضافه سعر توصيل جديد ");
            }
        }
        //$row = Price::create($data);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {

        $row = Price::findOrFail($id);

        $countries = Area::where('from_id', '=', null)->get();
        $traders = Trader::get();

        return view('Admin.CRUDS.prices.parts.edit', compact('row', 'countries', 'traders'));

    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'trader_id' => 'required|exists:traders,id',
            'govern_id' => 'required|exists:areas,id',
            'value' => 'required',

        ]);

        $row = Price::findOrFail($id);

        $old = $row;

        $row->update($data);

        $this->add_log_activity($row, auth('admin')->user(), " تم تعديل سعر جديد ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy($id)
    {

        $row = Price::findOrFail($id);

        $old = $row;

        $row->delete();
        $this->add_log_activity($old, auth('admin')->user(), "تم حذف سعر توصيل جديد");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    } //end fun

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
                    "more" => $morePages,
                ),
            );

            return \Response::json($results);

        }

    }
}
