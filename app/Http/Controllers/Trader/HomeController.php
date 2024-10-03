<?php

namespace App\Http\Controllers\Trader;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use LogActivityTrait;
    public function index()
    {
        $deliveredTotalyAndPartiay= Order::whereIn('status',['cancel', 'not_delivery', 'partial_delivery_to_customer', 'shipping_on_messanger'])->where('trader_id',trader()->user()->id)->count();
        $hadback= Order::whereIn('status',['cancel', 'not_delivery'])->where('trader_id',trader()->user()->id)->count();
        $totalOrders=Order::where('trader_id',trader()->user()->id)->count();
        $converted=Order::where('status','converted_to_delivery')->where('trader_id',trader()->user()->id)->count();
        $total=Order::where('status','total_delivery_to_customer')->where('trader_id',trader()->user()->id)->count();
        $partial=Order::where('status','partial_delivery_to_customer')->where('trader_id',trader()->user()->id)->count();
        $notDelivery=Order::where('status','not_delivery')->where('trader_id',trader()->user()->id)->count();

        return view('Trader.home.index',compact('converted','total','partial','notDelivery', 'totalOrders', 'deliveredTotalyAndPartiay', 'hadback'));
    }//end fun



    public function calender(Request $request)
    {
        $arrResult =[];
        $orders = Order::where('trader_id',trader()->user()->id)->get();
        //get count of newOrders by days
        foreach ($orders as $row) {
            $date = date('Y-m-d', strtotime($row->created_at));
            if (isset($arrResult[$date])) {
                $arrResult[$date]["counter"] += 1;
                $arrResult[$date]["id"][]  = $row->id;
            } else {
                $arrResult[$date]["counter"] = 1;
                $arrResult[$date]["id"][]  = $row->id;

            }
        }
        //  dd($arrResult);
        //make format of calender
        $Events = [];
        if (count($arrResult)>0) {
            $i = 0;
            foreach ($arrResult as $item => $value) {
                $title= $value['counter'];
                $Events[$i] = array(
                    'id' => $i,
                    'title' => $title,
                    'start' => $item,
                    'ids' => $value['id'],
                );
                $i++;
            }
        }
        //return to calender
        return $Events ;
    }//end fun




}//end clas
