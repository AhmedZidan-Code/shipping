<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TraderPaymentRequest;
use App\Http\Traits\LogActivityTrait;
use App\Models\Trader;
use App\Models\TraderPayments;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TraderPaymentController extends Controller
{
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware('permission:عرض تسديدات التجار')->only('index');
        $this->middleware('permission:تعديل تسديدات التجار')->only(['edit', 'update']);
        $this->middleware('permission:إنشاء تسديدات التجار')->only(['create', 'store']);
        $this->middleware('permission:حذف تسديدات التجار')->only('destroy');
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = TraderPayments::query()->with('trader')->orderBy('date', 'DESC');
            if ($request->fromDate) {
                $rows->where('created_at', '>=', $request->fromDate . ' ' . '00:00:00');

                $condition['created_at >='] = $request->fromDate . ' ' . '00:00:00';
            }
            if ($request->toDate) {
                $rows->where('created_at', '<=', $request->toDate . ' ' . '23:59:59');

                $condition['created_at <='] = $request->toDate . ' ' . '23:59:59';

            }
            if ($request->trader_id) {
                $rows->where('trader_id', $request->trader_id);
                $condition['trader_id'] = $request->trader_id;
            }

            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';

                    return '<a href="' . route('trader-payment-details.index', ['paid_id' => $row->id]) . '" class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <button  ' . $edit . '   class="editBtn btn rounded-pill btn-primary waves-effect waves-light"
                                    data-id="' . $row->id . '"
                            <span class="svg-icon svg-icon-3">
                                <span class="svg-icon svg-icon-3">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </span>
                            </button>
                       ';
                    // <button  ' . $delete . '  class="btn rounded-pill btn-danger waves-effect waves-light delete"
                    //         data-id="' . $row->id . '">
                    // <span class="svg-icon svg-icon-3">
                    //     <span class="svg-icon svg-icon-3">
                    //         <i class="fa fa-trash"></i>
                    //     </span>
                    // </span>
                    // </button>
                })
                ->editColumn('type', function($row){
                    return TransactionType::nameInAr($row->type);
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  تسديدات التجار");

        }
        return view('Admin.CRUDS.trader_payment.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.trader_payment.parts.create');
    }

    public function store(TraderPaymentRequest $request)
    {
        $data = $request->validated();
        $trader = Trader::where('id', $data['trader_id'])->first();
        if ($trader->is_collectible == false) {
            $data['in_safe'] = false;
        }
        $data['amount'] = $data['cash'] + $data['cheque'];
        $data['total_balance'] = $data['amount'];
        $row = TraderPayments::create($data);
        $this->add_log_activity($row, auth('admin')->user(), " تم اضافة تسديد للتاجر  {$trader->name}");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function edit($id)
    {

        $row = TraderPayments::findOrFail($id);

        return view('Admin.CRUDS.trader_payment.parts.edit', compact('row'));

    }

    public function update(TraderPaymentRequest $request, $id)
    {
        $row = TraderPayments::findOrFail($id);
        $row->load('trader');

        $old = $row;
        $data = $request->validated();
        $trader = Trader::where('id', $row->trader_id)->first();
        if ($trader->is_collectible == false) {
            $data['in_safe'] = false;
        }
        $data['amount'] = $data['cash'] + $data['cheque'];
        $data['total_balance'] = $data['amount'];
        // $data['type'] = TransactionType::DEPOSIT;
        $row->update($data);

        $this->add_log_activity($old, auth('admin')->user(), " تم تعديل  تسديد للتاجر {$row->trader->name}");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    }

    public function destroy($id)
    {
        $row = TraderPayments::findOrFail($id);
        $row->load('trader');

        $old = $row;

        $row->delete();

        $this->add_log_activity($old, auth('admin')->user(), " تم حذف  تسديد للتاجر {$row->trader->name} ");

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
            ]);
    } //end fun
}
