@extends('Trader.layouts.inc.app')
@section('title')
    الطلبات تحت التنفيذ
@endsection
@section('css')
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> الطلبات الشحن علي الراسل</h5>



        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>الحالة</th>
                        <th>المدينة</th>
                        <th> رقم التليفون</th>
                        <th> عنوان العميل</th>
                        <th>قيمه الاوردر</th>
                        <th>الملاحظات</th>
                        <th> تاريخ التحويل</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('js')
    <script>
        var columns = [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'province_id',
                name: 'province_id'
            },
            {
                data: 'customer_phone',
                name: 'customer_phone'
            },
            {
                data: 'customer_address',
                name: 'customer_address'
            },
            {
                data: 'shipment_value',
                name: 'shipment_value'
            },
            {
                data: 'refused_reason',
                name: 'refused_reason'
            },
            {
                data: 'converted_date',
                name: 'converted_date'
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'under_implementation_orders'])
@endsection
