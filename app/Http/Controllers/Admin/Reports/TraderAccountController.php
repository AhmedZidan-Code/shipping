<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Trader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TraderAccountController extends Controller
{
    use LogActivityTrait;
    protected $total;
    public function __construct()
    {
        //  $this->middleware('permission:عرض حسابات التجار', ['only' => ['index']]);
    }
    public function index(Request $request)
    {
        if ($request->trader_id) {
            $trader = Trader::findOrFail($request->trader_id);
        }

        $startDate = $request->input('fromDate') ? Carbon::parse($request->input('fromDate'))->format('Y-m-d') : null;
        $endDate = $request->input('toDate') ? Carbon::parse($request->input('toDate'))->format('Y-m-d') : null;
        if ($request->ajax() && $trader) {
            $subQuery = DB::query()->fromSub(function ($query) use ($request, $startDate, $endDate) {
                $query->from('orders')
                    ->select([
                        DB::raw('SUM(orders.shipment_value) AS total_shipment_value'),
                        DB::raw('COUNT(*) AS order_count'),
                        DB::raw('0 AS amount'),
                        DB::raw("0 AS type"),
                        DB::raw('0 AS debt'),
                        DB::raw('DATE(created_at) AS date'),
                    ])
                    ->where('trader_id', $request->trader_id)
                    ->when($startDate, function ($query) use ($startDate) {
                        return $query->whereDate('created_at', '>=', $startDate);
                    })
                    ->when($endDate, function ($query) use ($endDate) {
                        return $query->whereDate('created_at', '<=', $endDate);
                    })
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->unionAll(
                        DB::table('trader_payments')
                            ->select([
                                DB::raw('0 AS total_shipment_value'),
                                DB::raw('0 AS order_count'),
                                DB::raw('SUM(amount) as amount'),
                                'type',
                                DB::raw('0 AS debt'),
                                DB::raw('DATE(date) as date'),
                            ])
                            ->where('trader_id', $request->trader_id)
                            ->when($startDate, function ($query) use ($startDate) {
                                return $query->whereDate('date', '>=', $startDate);
                            })
                            ->when($endDate, function ($query) use ($endDate) {
                                return $query->whereDate('date', '<=', $endDate);
                            })
                            ->groupBy([DB::raw('DATE(date)'), 'type'])
                    )
                    ->union(
                        DB::table('traders')
                            ->select([
                                DB::raw('0 AS total_shipment_value'),
                                DB::raw('0 AS order_count'),
                                DB::raw('0 as amount'),
                                DB::raw('4 as type'),
                                'debt',
                                DB::raw('DATE(created_at) as date'),
                            ])
                            ->where('id', $request->trader_id)
                            ->when($startDate, function ($query) use ($startDate) {
                                return $query->whereDate('date', '>=', $startDate);
                            })
                            ->when($endDate, function ($query) use ($endDate) {
                                return $query->whereDate('date', '<=', $endDate);
                            })
                    );
            }, 'union_subquery');

            $results = $subQuery
                ->select([
                    'date',
                    'type',
                    'total_shipment_value',
                    'order_count',
                    'amount',
                    'debt',
                ])
                ->orderBy('date', 'asc')
                ->orderBy('type');
           
            return DataTables::of($results)
                ->addColumn('type', function ($row) {
                    return TransactionType::nameInAr($row->type);
                })
                ->addColumn('remainder', function ($row) {
                    return $this->total += $row->total_shipment_value + $row->debt - $row->amount;
                })
                ->escapeColumns([])
                ->make(true);

        }
        $this->add_log_activity(null, auth('admin')->user(), "تم عرض  كشف حساب التاجر");

        return view('Admin.reports.traders.account');
    }
}
