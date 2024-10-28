@extends('Admin.layouts.inc.app')
@section('title')
    تقارير يومية الطلبات
@endsection
@section('css')
@endsection
@section('content')

    <form action="{{ route('todayOrdersReports.index') }}">

        <div class="row mb-3">
            <div class="col-md-4 ">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ البداية </span>

                </label>
                <input type="date" id="fromDate" value="{{ request('fromDate') }}" name="fromDate"
                    class="showBonds form-control">

            </div>
            <div class="col-md-4">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ النهاية </span>

                </label>
                <input type="date" id="toDate" value="{{ request('toDate') }}"
                    name="toDate" class="showBonds form-control">
            </div>
            <div class="col-md-4">
                <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> المندوب </span>
                </label>
                <select id="delivery_id" class="form-control showBonds" name="delivery_id">
                    <option value="">اختر</option>
                    @if (!empty($delivieries))
                        @foreach ($delivieries as $delivery)
                            <option value="{{ $delivery->id }}">{{ $delivery->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>

    </form>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تقارير يومية الطلبات</h5>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المندوب</th>
                        <th>الاجمالي</th>
                        <th>الطلبات</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>


@endsection
@section('js')
    <script>
        var columns = [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'total_orders_count',
                name: 'total_orders_count'
            },
            {
                data: 'orderDetails',
                name: 'orderDetails'
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'todayOrdersReports'])
@endsection
