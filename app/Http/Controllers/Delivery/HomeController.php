<?php

namespace App\Http\Controllers\Delivery;

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

        $currant= Order::where('delivery_id',delivery()->user()->id)->where('status','converted_to_delivery')->count();
        $total= Order::where('delivery_id',delivery()->user()->id)->where('status','total_delivery_to_customer')->count();
        $partial= Order::where('delivery_id',delivery()->user()->id)->where('status','partial_delivery_to_customer')->count();
        $notDelivery= Order::where('delivery_id',delivery()->user()->id)->where('status','not_delivery')->count();

        return view('Delivery.home.index', compact('currant','total','partial','notDelivery'));
    }//end fun

    public function calender(Request $request)
    {
        $arrResult =[];
        $orders = Order::where('status','converted_to_delivery')->where('delivery_id',delivery()->user()->id)->get();
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
