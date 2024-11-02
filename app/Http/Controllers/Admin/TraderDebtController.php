<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Trader;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TraderDebtController extends Controller
{
    use LogActivityTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Trader::query()
                ->withSum('orders as total_shipment_value', 'shipment_value')
                ->withSum(['payments as deposit_sum' => function ($query) {$query->where('type', TransactionType::DEPOSIT);}], 'amount')
                ->withSum(['payments as tahseel_sum' => function ($query) {$query->where('type', TransactionType::TAHSEEL);}], 'amount')
                ->withSum(['payments as hadback_sum' => function ($query) {$query->where('type', TransactionType::HADBACK);}], 'amount');

            return DataTables::of($rows)
                ->editColumn('remainder', function ($row) {
                    return ($row->total_shipment_value + $row->debt)-($row->deposit_sum + $row->tahseel_sum +$row->hadback_sum );
                })
                ->editColumn('deposit_sum', function ($row) {
                    return $row->deposit_sum ?? 0;
                })
                ->editColumn('tahseel_sum', function ($row) {
                    return $row->tahseel_sum ?? 0;
                })
                ->editColumn('hadback_sum', function ($row) {
                    return $row->hadback_sum ?? 0;
                })
                ->escapeColumns([])
                ->make(true);

        } else {
            $this->add_log_activity(null, auth('admin')->user(), "تم عرض  مديونية التجار");

        }
        return view('Admin.CRUDS.trader_debt.index');
    }
}
