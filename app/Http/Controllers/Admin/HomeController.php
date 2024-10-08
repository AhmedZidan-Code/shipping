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
        $newOrders=Order::where('status','new')->count();
        $convertedOrders=Order::where('status','converted_to_delivery')->count();
        $totalDeliveryOrders=Order::where('status','total_delivery_to_customer')->count();
        $partialDeliveryOrders=Order::where('status','total_delivery_to_customer')->count();

        return view('Admin.home.index',compact('newOrders','convertedOrders','totalDeliveryOrders','partialDeliveryOrders'));
    }//end fun



    public function calender(Request $request)
    {
        $arrResult =[];
        $orders = Order::where('status','new')->get();
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
