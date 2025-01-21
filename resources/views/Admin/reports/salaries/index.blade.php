@extends('Admin.layouts.inc.app')
@section('title')
    تقارير المرتبات
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('mandoub-salary.index') }}">
        <div class="row mb-3">


            <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                <!--begin::Label-->
                <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> المندوب</span>
                </label>
                <select id='delivery_id' name="delivery_id" style='width: 200px;'>
                    <option selected value="0">- ابحث عن مندوب</option>
                    @if (request('delivery_id'))
                        <option value="{{ request('delivery_id') }}" selected>
                            {{ App\Models\Delivery::where('id', request('delivery_id'))->first()->name }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> الشهر </span>

                </label>
                <select class="form-control" id="month" name="month">
                    <option value=""> اختر الشهر </option>
                    <option value="1" {{ request('month') == 1 ? 'selected' : '' }}> يناير </option>
                    <option value="2" {{ request('month') == 2 ? 'selected' : '' }}> فبراير </option>
                    <option value="3" {{ request('month') == 3 ? 'selected' : '' }}> مارس </option>
                    <option value="4" {{ request('month') == 4 ? 'selected' : '' }}> ابريل </option>
                    <option value="5" < {{ request('month') == 5 ? 'selected' : '' }}> مايو </option>
                    <option value="6" {{ request('month') == 6 ? 'selected' : '' }}> يونيو </option>
                    <option value="7" {{ request('month') == 7 ? 'selected' : '' }}> يوليو </option>
                    <option value="8" {{ request('month') == 8 ? 'selected' : '' }}> اغسطس </option>
                    <option value="9" {{ request('month') == 9 ? 'selected' : '' }}> سبتمبر </option>
                    <option value="10" {{ request('month') == 10 ? 'selected' : '' }}> اكتوبر </option>
                    <option value="11" {{ request('month') == 11 ? 'selected' : '' }}> نوفمبر </option>
                    <option value="12" {{ request('month') == 12 ? 'selected' : '' }}> ديسمبر </option>
                </select>

            </div>


            <div class="col-md-4">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تقارير المناديب</h5>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المندوب</th>
                        <th>الشهر</th>
                        <th>السنة</th>
                        <th> الشحن</th>
                        <th>الشحن بعد المصاريف</th>
                        <th> عدد التنفيذات</th>
                        <th> المصاريف</th>
                        <th> الراتب الاساسي</th>
                        <th> مصاريف البنزين </th>
                        <th> المصاريف الادارية </th>
                        <th> أرباح الشركة</th>
                        <th>صافي الراتب</th>
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
                data: 'delivery.name',
                name: 'delivery.name'
            },
            {
                data: 'month',
                name: 'month'
            },
            {
                data: 'year',
                name: 'year'
            },
            {
                data: 'delivery_shipping',
                name: 'delivery_shipping'
            },
            {
                data: 'shipping_after_fees',
                name: 'shipping_after_fees'
            },
            {
                data: 'orders_count',
                name: 'orders_count'
            },
            {
                data: 'delivery_fees',
                name: 'delivery_fees'
            },
            {
                data: 'base_salary',
                name: 'base_salary'
            },
            {
                data: 'solar',
                name: 'solar'
            },
            {
                data: 'expenses',
                name: 'expenses'
            },
            {
                data: 'company_profit',
                name: 'company_profit'
            },
            {
                data: 'total_salary',
                name: 'total_salary'
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'mandoub-salary'])

    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>



    <script>
        (function() {

            $("#delivery_id").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.getDeliveries') }}',
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
@endsection
