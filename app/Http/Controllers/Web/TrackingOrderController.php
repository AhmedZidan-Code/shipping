<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackingOrderController extends Controller
{
    public function trace(Request $request)
    {
        if ($request->order) {
            $order = Order::where('id', $request->order)->first();
            if ($order) {
                $status = $this->status($order->status);
                return view('Web.tracking', compact('order', 'status'));
            }
        }
        return view('Web.tracking');
    }

    public function status($case)
    {

        $status = [
            'new' => 'جديد',
            'converted_to_delivery' => 'خارج للتوصيل',
                        'total_delivery_to_customer' => 'تم التسليم',
            'partial_delivery_to_customer' => 'تم التسليم جزئياً',
            'not_delivery' => 'عدم استلام',
            'under_implementation' => 'تحت التنفيذ',
            'cancel' => 'ملغي',
            'delaying' => 'مؤجل',
            'collection' => 'تحصيل',
            'paid' => 'تم الدفع',
            'shipping_on_messanger' => 'الشحن علي الراسل',
        ];
        return $status[$case];
    }
}
