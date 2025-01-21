<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\StaticPage;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StaticPageController extends Controller
{
    use LogActivityTrait, ImageHandler;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = StaticPage::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل الصفحات الثابتة')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف الصفحات الثابتة')) {
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
                ->editColumn('image', function ($row) {
                    return '<img src="' . asset('/storage/' . $row->image) . '" alt="Image" width="50" height="50">';
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الصفحات الثابتة");

        }
        return view('Admin.web.static_pages.index');

    }

    public function create()
    {
        $pages = config('pages');
        $data = array_keys($pages);
        $created = StaticPage::pluck('page_id');
        return view('Admin.web.static_pages.parts.create', compact('pages', 'created'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $this->uploadImage($request->file('image'), 'pages');

        StaticPage::create([
            'page_name' => config("pages.{$request->page}"),
            'page_id' => $request->page,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {
        $row = StaticPage::findOrFail($id);

        return view('Admin.web.static_pages.parts.edit', ['row' => $row]);

    }

    public function update(Request $request, $id)
    {
        $page = StaticPage::findOrFail($id);
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            $this->deleteImage($page->image);

            // Upload the new image
            $imagePath = $this->uploadImage($request->file('image'), 'pages');
            $page->update(['image' => $imagePath]);
        }

        $page->update($request->only('title', 'description'));

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy($id)
    {
        $page = StaticPage::where('id', $id)->first();
        // Delete the image associated with the feature
        $this->deleteImage($page->image);

        $page->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }
}
