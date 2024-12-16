<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\Trader;
use App\Models\AgentPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use Yajra\DataTables\Facades\DataTables;

class AgentPriceController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض أسعار شحن الوكلاء')->only(['index']);
        $this->middleware('permission:تعديل أسعار شحن الوكلاء')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء أسعار شحن الوكلاء')->only(['create', 'store']);
        $this->middleware('permission:حذف أسعار شحن الوكلاء')->only('destroy');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = AgentPrice::query()->with(['agent', 'govern'])->latest();
            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل أسعار شحن الوكلاء')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف أسعار شحن الوكلاء')) {
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
                ->editColumn('agent', function ($row) {
                    return $row->agent->name ?? '';
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
        return view('Admin.CRUDS.agent_prices.index');
    }

    public function create()
    {
        $countries = Area::where('from_id', '=', null)->get();
        $traders = Trader::get();

        return view('Admin.CRUDS.agent_prices.parts.create', compact('countries', 'traders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:deliveries,id',
            'govern_id' => 'required|exists:areas,id|array',
            'value' => 'required|array',
            'value.*' => 'required',

        ]);
        $count = count($request->govern_id);

        for ($x = 0; $x < $count; $x++) {
            if ($request->value[$x] > 0) {
                $price['agent_id'] = $request->agent_id;
                $price['govern_id'] = $request->govern_id[$x];
                $price['value'] = $request->value[$x];
                $row = AgentPrice::create($price);
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

        $row = AgentPrice::findOrFail($id);

        $countries = Area::where('from_id', '=', null)->get();
        $traders = Trader::get();

        return view('Admin.CRUDS.agent_prices.parts.edit', compact('row', 'countries', 'traders'));

    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:deliveries,id',
            'govern_id' => 'required|exists:areas,id',
            'value' => 'required',

        ]);

        $row = AgentPrice::findOrFail($id);

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

        $row = AgentPrice::findOrFail($id);

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
            $posts = DB::table('areas')->where('from_id', '!=', null)->select('id', 'title as text')
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
