<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Models\AgentPayment;
use Illuminate\Http\Request;
use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\AgentPaymentRequest;

class AgentPaymentController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض تسديدات الوكلاء')->only('index');
        $this->middleware('permission:تعديل تسديدات الوكلاء')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء تسديدات الوكلاء')->only(['create', 'store']);
        $this->middleware('permission:حذف تسديدات الوكلاء')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = AgentPayment::query()->with('agent');
            if ($request->fromDate) {
                $rows->where('date', '>=', $request->fromDate);

                $condition['date >='] = $request->fromDate;
            }
            if ($request->toDate) {
                $rows->where('date', '<=', $request->toDate);

                $condition['date <='] = $request->toDate;

            }
            if ($request->agent_id) {
                $rows->where('agent_id', $request->agent_id);
                $condition['agent_id'] = $request->agent_id;
            }

            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    // <a href="' . route('agent-payment-details.index', ['paid_id' => $row->id]) . '" class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>

                    return '<button  ' . $edit . '   class="editBtn btn rounded-pill btn-primary waves-effect waves-light"
                                    data-id="' . $row->id . '"
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </span>
                            </button>
                       ';
                    //    ' <button  ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                    //             data-id="' . $row->id . '">
                    //     <span class="svg-icon svg-icon-3">
                    //         <span class="svg-icon svg-icon-3">
                    //             <i class="fa fa-trash"></i>
                    //         </span>
                    //     </span>
                    //     </button>';
                })
                ->editColumn('type', function ($row) {
                    return TransactionType::nameInAr($row->type);
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  تسديدات الوكلاء");

        }
        return view('Admin.CRUDS.agent_payment.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.agent_payment.parts.create');
    }

    public function store(AgentPaymentRequest $request)
    {
        $data = $request->validated();
        $data['total'] = $data['cash'] + $data['cheque'];
        $row = AgentPayment::create($data);
        $row->load('agent');
        $this->add_log_activity($row, auth('admin')->user(), " تم اضافة تسديد للوكيل  {$row->agent->name}");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {

        $row = AgentPayment::with('agent')->findOrFail($id);

        return view('Admin.CRUDS.agent_payment.parts.edit', compact('row'));

    }

    public function update(AgentPaymentRequest $request, $id)
    {
        $row = AgentPayment::findOrFail($id);
        $row->load('agent');

        $old = $row;
        $data = $request->validated();
        $data['total'] = $data['cash'] + $data['cheque'];
        // $data['type'] = TransactionType::DEPOSIT;
        $row->update($data);

        $this->add_log_activity($old, auth('admin')->user(), " تم تعديل  تسديد للوكيل {$row->agent->name}");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy($id)
    {
        $row = AgentPayment::findOrFail($id);
        $row->load('agent');

        $old = $row;

        $row->delete();

        $this->add_log_activity($old, auth('admin')->user(), " تم حذف  تسديد للوكيل {$row->agent->name} ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    } //end fun
}
