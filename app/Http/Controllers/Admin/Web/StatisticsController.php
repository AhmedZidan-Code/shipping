<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Statistics;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StatisticsController extends Controller
{
    use LogActivityTrait, ImageHandler;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Statistics::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل الاحصائيات')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف الاحصائيات')) {
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
                ->addColumn('date', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
            // ->editColumn('image', function ($row) {
            //     return '<img src="' . asset('/storage/' . $row->image) . '" alt="Image" width="50" height="50">';
            // })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الاحصائيات");

        }
        return view('Admin.web.statistics.index');

    }
    public function create()
    {
        $pages = config('pages');
        return view('Admin.web.statistics.parts.create', compact('pages'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'page' => 'required',
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        Statistics::create([
            'page_name' => config("pages.{$request->page}"),
            'page_id' => $request->page,
            'title' => $request->title,
            'value' => $request->value,
        ]);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {

        $row = Statistics::findOrFail($id);

        return view('Admin.web.statistics.parts.edit', ['row' => $row]);

    }

    public function update(Request $request, Statistics $statistic)
    {
        $request->validate([
            'title' => 'required|required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        $statistic->update($request->only('title', 'value'));

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy(Statistics $statistic)
    {
        // Delete the image associated with the feature

        $statistic->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }
}
