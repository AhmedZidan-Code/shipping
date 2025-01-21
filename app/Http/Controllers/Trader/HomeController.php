<?php

namespace App\Http\Controllers\Trader;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use LogActivityTrait;
    public function index()
    {
        $trader = trader()->user();
        $mohsala = Order::query()
            ->where('trader_id', $trader->id)
            ->whereIn('status', array('total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger'))
            ->where('paid_as_money', 1)
            ->count();
        $hadback = Order::whereIn('status', ['cancel', 'not_delivery'])->where('trader_id', $trader->id)->count();
        $totalOrders = Order::where('trader_id', $trader->id)->count();
        $converted = Order::where('status', 'converted_to_delivery')->where('trader_id', $trader->id)->count();
        $total = Order::where('status', 'total_delivery_to_customer')->where('paid_as_money', 0)->where('trader_id', $trader->id)->count();
        $partial = Order::where('status', 'partial_delivery_to_customer')->where('paid_as_money', 0)->where('trader_id', $trader->id)->count();
        $notDelivery = Order::query()->where('trader_id', $trader->id)->with(['province', 'trader', 'delivery'])->whereIn('status', array('cancel', 'not_delivery', 'partial_delivery_to_customer', 'shipping_on_messanger'))->where('paid_as_mortag3', 0)->count();

        return view('Trader.home.index', compact('converted', 'total', 'partial', 'notDelivery', 'totalOrders', 'mohsala', 'hadback'));
    } //end fun

    public function calender(Request $request)
    {
        $arrResult = [];
        $trader = trader()->user();
        $orders = Order::where('trader_id', $trader->id)->get();
        //get count of newOrders by days
        foreach ($orders as $row) {
            $date = date('Y-m-d', strtotime($row->created_at));
            if (isset($arrResult[$date])) {
                $arrResult[$date]["counter"] += 1;
                $arrResult[$date]["id"][] = $row->id;
            } else {
                $arrResult[$date]["counter"] = 1;
                $arrResult[$date]["id"][] = $row->id;

            }
        }
        //  dd($arrResult);
        //make format of calender
        $Events = [];
        if (count($arrResult) > 0) {
            $i = 0;
            foreach ($arrResult as $item => $value) {
                $title = $value['counter'];
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
        return $Events;
    } //end fun

} //end clas
