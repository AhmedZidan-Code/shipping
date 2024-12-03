<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Process;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProcessController extends Controller
{
    use LogActivityTrait, ImageHandler;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Process::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل العمليات')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف العمليات')) {
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
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  العمليات");

        }
        return view('Admin.web.processes.index');

    }
    public function create()
    {

        return view('Admin.web.processes.parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $this->uploadImage($request->file('image'), 'processes');

        Process::create([
            'title' => $request->title,
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

        $row = Process::findOrFail($id);

        return view('Admin.web.processes.parts.edit', ['row' => $row]);

    }

    public function update(Request $request, Process $process)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            $this->deleteImage($process->image);

            // Upload the new image
            $imagePath = $this->uploadImage($request->file('image'), 'processes');
            $process->update(['image' => $imagePath]);
        }

        $process->update($request->only('title'));

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy(Process $process)
    {
        // Delete the image associated with the feature
        $this->deleteImage($process->image);

        $process->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }
}
