<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Video;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    use LogActivityTrait, ImageHandler;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Video::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل الفيديوهات')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف الفيديوهات')) {
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
                ->editColumn('video', function ($row) {
                    return '<video width="50" height="50" >
                            <source src="' . asset('/storage/' . $row->video) . '"type="video/mp4">

                            </video>';
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض الفيديوهات");

        }
        return view('Admin.web.videos.index');

    }

    public function create()
    {
        $pages = config('pages');
        $data = array_keys($pages);
        $created = Video::pluck('page_id');
        return view('Admin.web.videos.parts.create', compact('pages', 'created'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'video' => 'required|max:20000',
        ]);

        $imagePath = $this->uploadImage($request->file('image'), 'videos');
        $videoPath = $this->uploadImage($request->file('video'), 'videos');

        Video::create([
            'page_name' => config("pages.{$request->page}"),
            'page_id' => $request->page,
            'image' => $imagePath,
            'video' => $videoPath,
        ]);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {
        $row = Video::findOrFail($id);

        return view('Admin.web.videos.parts.edit', ['row' => $row]);

    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video' => 'nullable|max:20000',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            $this->deleteImage($video->image);

            // Upload the new image
            $imagePath = $this->uploadImage($request->file('image'), 'videos');
            $video->update(['image' => $imagePath]);
        }
        if ($request->hasFile('video')) {
            // Delete the old image
            $this->deleteImage($video->video);

            // Upload the new image
            $videoPath = $this->uploadImage($request->file('video'), 'videos');
            $video->update(['video' => $videoPath]);
        }

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy($id)
    {
        $video = Video::where('id', $id)->first();
        // Delete the image associated with the feature
        $this->deleteImage($video->image);
        $this->deleteImage($video->video);

        $video->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }
}
