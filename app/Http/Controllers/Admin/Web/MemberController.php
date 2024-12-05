<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Member;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    use LogActivityTrait, ImageHandler;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Member::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    if (!auth()->user()->can('تعديل أعضاء الفريق')) {
                        $edit = 'hidden';
                    }

                    if (!auth()->user()->can('حذف أعضاء الفريق')) {
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
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  أعضاء الفريق");

        }
        return view('Admin.web.members.index');

    }
    public function create()
    {

        return view('Admin.web.members.parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'facebook_profile' => 'required|url|max:600',
            'twitter_profile' => 'required|url|max:600',
            'linkedin_profile' => 'required|url|max:600',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $this->uploadImage($request->file('image'), 'sliders');

        Member::create([
            'name' => $request->name,
            'job_title' => $request->job_title,
            'image' => $imagePath,
            'facebook_profile' => $request->facebook_profile,
            'twitter_profile' => $request->twitter_profile,
            'linkedin_profile' => $request->linkedin_profile,
        ]);

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {

        $row = Member::findOrFail($id);

        return view('Admin.web.members.parts.edit', ['row' => $row]);

    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'facebook_profile' => 'required|url|max:600',
            'twitter_profile' => 'required|url|max:600',
            'linkedin_profile' => 'required|url|max:600',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            $this->deleteImage($member->image);

            // Upload the new image
            $imagePath = $this->uploadImage($request->file('image'), 'members');
            $member->update(['image' => $imagePath]);
        }

        $member->update(
            $request->only(
                'name',
                'job_title',
                'facebook_profile',
                'twitter_profile',
                'linkedin_profile')
        );

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy(Member $member)
    {
        // Delete the image associated with the feature
        $this->deleteImage($member->image);

        $member->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }
}
