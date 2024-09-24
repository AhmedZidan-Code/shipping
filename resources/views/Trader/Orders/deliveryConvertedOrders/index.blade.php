@extends('Trader.layouts.inc.app')
@section('title')
    الطلبات المحولة الي المناديب
@endsection
@section('css')
@endsection
@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> الطلبات المحولة الي المناديب</h5>



        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>رقم الاوردر</th>
                        <th>اسم العميل</th>
                        <th>الحالة</th>
                        <th>المدينة</th>
                        <th> رقم التليفون</th>
                        <th> العنوان </th>
                        <th>اجمالي الاوردر</th>
                        <th> المندوب</th>
                        <th>قيمة المندوب</th>
                        <th>الملاحظات</th>
                        <th>المتبقي</th>
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
                data: 'total_value',
                name: 'total_value'
            },
            {
                data: 'delivery.name',
                name: 'delivery.name'
            },
            {
                data: 'delivery_ratio',
                name: 'delivery_ratio'
            },
            {
                data: 'notes',
                name: 'notes'
            },
            {
                data: 'residual',
                name: 'residual'
            },
            {
                data: 'converted_date',
                name: 'converted_date'
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'deliveryConvertedOrders'])

    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

    <script>
        (function() {

            $("#province_id").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.getGovernorates') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
        })();
    </script>

    <script>

    </script>
@endsection
