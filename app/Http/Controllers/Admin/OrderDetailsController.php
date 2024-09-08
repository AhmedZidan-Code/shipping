<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('paid_id') && $request->paid_id != null) {
            $rows = Order::where('paid_id', $request->paid_id)
                ->with(['province', 'trader', 'delivery'])
                ->orderByDesc('converted_date')->get();
        }
        return view('Admin.CRUDS.trader_payment.details', ['rows' => $rows]);
    }

    // private function renderStatusButton($status)
    // {
    //     $statusClasses = [
    //         'new' => ['طلب جديد', 'btn btn-info'],
    //         'converted_to_delivery' => ['طلب محول الي المندوب', 'btn btn-info'],
    //         'total_delivery_to_customer' => ['طلب مسلم كليا', 'btn btn-success'],
    //         'partial_delivery_to_customer' => ['طلب مسلم جزئيا', 'btn btn-warning'],
    //         'not_delivery' => ['طلب لم يسلم', 'btn btn-warning'],
    //         'under_implementation' => ['تحت التنفيذ', 'btn btn-warning'],
    //         'cancel' => ['طلب ملغي', 'btn btn-danger'],
    //         'delaying' => ['طلب مؤجل', 'btn btn-danger'],
    //         'collection' => ['طلب محصل', 'btn btn-success'],
    //         'paid' => ['مدفوع', 'btn btn-success'],
    //     ];

    //     [$statusText, $class] = $statusClasses[$status] ?? ['لم يحدد', ''];

    //     return "<button class='{$class}'> {$statusText} </button>";
    // }

    // private function renderMapLink($latitude, $longitude)
    // {
    //     $link = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}";
    //     return "<a target='_blank' class='btn btn-pill btn-info' href='{$link}'> عرض <i class='fa fa-map-marker-alt text-white'></i> </a>";
    // }

    // private function calculateShipmentValue($row)
    // {
    //     return $row->status === 'partial_delivery_to_customer'
    //     ? $row->partial_value - $row->delivery_value
    //     : $row->shipment_value;
    // }

}
