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
            <div class="d-flex flex-column mb-7  col-sm-3">
                <!--begin::Label-->
                <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> المندوب</span>
                </label>
                <select id='delivery_id' name="delivery_id">
                    <option selected disabled>- ابحث عن مندوب</option>
                    @if (request('delivery_id'))
                        <option value="{{ request('delivery_id') }}" selected>
                            {{ App\Models\Delivery::where('id', request('delivery_id'))->first()->name }}</option>
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
                <tfoot style="background-color: rgb(223, 235, 242)">
                    <tr>
                        <td colspan="2" style="text-align: center;">الاجمالي</td>
                        <td colspan="2"  id="total"></td>
                    </tr>
                </tfoot>

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
    
 

<!-- Initialize Select2 -->

    @include('Admin.layouts.inc.ajax', ['url' => 'todayOrdersReports'])

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
