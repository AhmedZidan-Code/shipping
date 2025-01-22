<h2>تنفيذات المناديب</h2>
<table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <td>#</td>
            <td>اجمالي الاوردرات</td>
            <td>نقدي الاوردرات</td>
            <td>غير نقدي الاوردرات</td>
            <td>مصروفات المناديب</td>
            <td>بنزين</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($dliveryOrders as $key => $order)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $order->total_orders }}</td>
                <td>{{ $order->cash }}</td>
                <td>{{ $order->cheque }}</td>
                <td>{{ $order->fees }}</td>
                <td>{{ $order->solar }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2> المصروفات الادارية</h2>
<table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <td>#</td>
            <td>القيمة</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($expenses as $key => $expense)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $expense->value }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<h2> مدفوعات التجار</h2>
<table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
    <thead>
        <tr>
            <td>#</td>
            <td>الاجمالي</td>
            <td>نقدي</td>
            <td>غير نقدي</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($traderPayments as $key => $payment)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->cash }}</td>
                <td>{{ $payment->cheque }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
