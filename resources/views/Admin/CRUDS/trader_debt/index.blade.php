@extends('Admin.layouts.inc.app')
@section('title')
     مديونية التجار
@endsection
@section('css')
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">  مديونية التجار</h5>

        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>اسم التاجر</th>
                    <th>رقم تليفون التاجر</th>
                    <th>المديونية السابقة</th>
                    <th>إجمالي الاوردرات</th>
                    <th>المدفوع كمقدم</th>
                    <th>المدفوع كمرتجع</th>
                    <th>المدفوع كتحصيل</th>
                    <th> المتبقى</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('js')
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'debt', name: 'debt', searchable:false},
            {data: 'total_shipment_value', name: 'total_shipment_value', searchable:false},
            {data: 'deposit_sum', name: 'deposit_sum', searchable:false},
            {data: 'hadback_sum', name: 'hadback_sum', searchable:false},
            {data: 'tahseel_sum', name: 'tahseel_sum', searchable:false},
            {data: 'remainder', name: 'remainder', searchable:false},
        ];
    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'traders-debt'])


@endsection
