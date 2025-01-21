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
                    ->where('trader_id', $request->trader_id)
                    ->when($startDate, function ($query) use ($startDate) {
                        return $query->whereDate('created_at', '>=', $startDate);
                    })
                    ->when($endDate, function ($query) use ($endDate) {
                        return $query->whereDate('created_at', '<=', $endDate);
                    })
                    ->select([
                        DB::raw('COUNT(*) AS order_count'),
                        DB::raw('SUM(orders.shipment_value) AS amount'),
                        DB::raw("0 AS type"),
                        DB::raw('DATE(created_at) AS date'),
                    ])
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->unionAll(
                        DB::table('trader_payments')
                            ->where('trader_id', $request->trader_id)
                            ->when($request->trader_id, function ($query) use ($request) {
                                return $query->whereIn('type', function ($subQuery) use ($request) {
                                    $subQuery->select('type')
                                        ->from('trader_payments')
                                        ->where('trader_id', $request->trader_id);
                                })
                                    ->when(DB::table('traders')->where('id', $request->trader_id)->value('is_collectible') == false, function ($query) {
                                        return $query->whereIn('type', [2, 3]);
                                    });
                            })
                            ->when($startDate, function ($query) use ($startDate) {
                                return $query->whereDate('date', '>=', $startDate);
                            })
                            ->when($endDate, function ($query) use ($endDate) {
                                return $query->whereDate('date', '<=', $endDate);
                            })
                            ->join('traders', 'trader_payments.trader_id', '=', 'traders.id')
                            ->select([
                                DB::raw('0 AS order_count'),
                                DB::raw('SUM(amount) as amount'),
                                'type',
                                DB::raw('DATE(date) as date'),
                            ])

                            ->groupBy([DB::raw('DATE(date)'), 'type'])
                    )
                    ->union(
                        DB::table('traders')
                            ->where('id', $request->trader_id)
                            ->select([
                                DB::raw('0 AS order_count'),
                                DB::raw('debt as amount'),
                                DB::raw('4 as type'),
                                DB::raw('DATE(updated_at) as date'),
                            ])

                    );
            }, 'union_subquery');

            $results = $subQuery
                ->select([
                    'date',
                    'type',
                    'order_count',
                    'amount',
                ])
                ->orderByRaw("CASE WHEN type = 4 THEN 0 ELSE 1 END")
                ->orderBy('date', 'asc')
                ->orderBy('type');

            // $sum = $results->whereIn('type', [0, 4])->sum('amount'); 
            // $subtract = $results->whereNotIn('type', [0, 4])->sum('amount');

            // dd($sum  - $subtract );
            return DataTables::of($results)
                ->addColumn('type', function ($row) {
                    return TransactionType::nameInAr($row->type);
                })
                ->addColumn('remainder', function ($row) {
                    if ($row->type == 0 || $row->type == 4) {
                        return $this->total = $this->total + $row->amount;
                    } else {
                        return $this->total = $this->total - $row->amount;
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
        $this->add_log_activity(null, auth('admin')->user(), "تم عرض  كشف حساب التاجر");

        return view('Admin.reports.traders.account');
    }
}
