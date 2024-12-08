<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    use LogActivityTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Contacts::query();
            return DataTables::of($rows)

                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    // if (!auth()->user()->can('تعديل السلايدر')) {
                    //     $edit = 'hidden';
                    // }

                    // if (!auth()->user()->can('حذف السلايدر')) {
                    //     $delete = 'hidden';
                    // }

                    return '
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

                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  رسائل التواصل");

        }
        return view('Admin.web.contacts.index');

    }

    public function destroy(Contacts $contact)
    {

        $contact->delete();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }
}
