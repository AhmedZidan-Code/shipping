<?php

namespace App\Http\Controllers\Admin;

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

        $this->add_log_activity(null, auth('admin')->user(), "تم عرض  الرئيسية");
        $newOrders = Order::where('status', 'new')->count();
        $daynewOrders = Order::whereDate('created_at', date('Y-m-d'))->count();
        $convertedOrders = Order::where('status', 'converted_to_delivery')->count();
        $totalDeliveryOrders = Order::where('paid_as_money', 1)->count();
        $mohsala = Order::query()
            ->whereIn('status', array('total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger'))
            ->where('paid_as_money', 1)
            ->count();
        $tahseel = Order::query()->whereIn('status', ['total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger'])
            ->where('paid_as_money', 0)
            ->count();
        $asTahseel = Order::query()
            ->whereIn('status', ['total_delivery_to_customer', 'partial_delivery_to_customer', 'shipping_on_messanger'])
            ->where('paid_as_money', 1)
            ->count();
        $asHadback = Order::query()->latest()->with(['province', 'trader', 'delivery'])
            ->whereIn('status',  ['cancel', 'not_delivery', 'partial_delivery_to_customer', 'shipping_on_messanger'])
            ->where('paid_as_mortag3', 1)
            ->count();

        $hadback = Order::whereIn('status', ['cancel', 'not_delivery'])->count();
        $canceled = Order::whereIn('status', ['cancel'])->count();
        $totalOrders = Order::count();
        $partial = Order::where('status', 'partial_delivery_to_customer')->where('paid_as_money', 0)->count();
        $notDelivery = Order::query()->whereIn('status', array('cancel', 'not_delivery', 'partial_delivery_to_customer', 'shipping_on_messanger'))->where('paid_as_mortag3', 0)->count();

        return view('Admin.home.index', compact('newOrders','canceled', 'daynewOrders','convertedOrders', 'totalDeliveryOrders', 'partial', 'notDelivery', 'hadback', 'totalOrders',  'tahseel', 'mohsala', 'asTahseel', 'asHadback'));
    } //end fun



    public function calender(Request $request)
    {
        $arrResult = [];
        $orders = Order::where('status', 'new')->get();
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





}//end clas
