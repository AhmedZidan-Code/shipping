<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Slider;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    use LogActivityTrait, ImageHandler;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Slider::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل السلايدر')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف السلايدر')) {
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
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  السلايدر");

        }
        return view('Admin.web.sliders.index');

    }
    public function create()
    {

        return view('Admin.web.sliders.parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png',
            'cover' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        $imagePath = $this->uploadImage($request->file('image'), 'sliders');
        $coverPath = $this->uploadImage($request->file('cover'), 'sliders');

        $slider = Slider::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'cover' => $coverPath,
        ]);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {

        $row = Slider::findOrFail($id);

        return view('Admin.web.sliders.parts.edit', ['row' => $row]);

    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            $this->deleteImage($slider->image);

            // Upload the new image
            $imagePath = $this->uploadImage($request->file('image'), 'sliders');
            $slider->update(['image' => $imagePath]);
        }
        if ($request->hasFile('cover')) {
            // Delete the old image
            $this->deleteImage($slider->cover);

            // Upload the new image
            $imagePath = $this->uploadImage($request->file('cover'), 'sliders');
            $slider->update(['cover' => $imagePath]);
        }

        $slider->update($request->only('title', 'description'));

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy(Slider $slider)
    {
        // Delete the image associated with the slider
        $this->deleteImage($slider->image);

        $slider->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }
}
