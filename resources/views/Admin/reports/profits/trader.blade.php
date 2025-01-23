@extends('Admin.layouts.inc.app')
@section('title')
    تقرير أرباح التجار
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('trader-profits.index') }}">
        <div class="row mb-3">

            <div class="d-flex flex-column mb-7  col-sm-3">
                <!--begin::Label-->
                <label for="trader_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> التاجر</span>
                </label>
                <select id='trader_id' name="trader_id">
                    <option selected disabled>- ابحث عن تاجر</option>
                    @if (request('trader_id'))
                        <option value="{{ request('trader_id') }}" selected>
                            {{ App\Models\Trader::where('id', request('trader_id'))->first()->name }}</option>
                    @endif
                </select>
            </div>

            <div class="col-md-3 ">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> من تاريخ </span>

                </label>
                <input type="date" id="from_date" value="{{ request('fromDate') ?? date('Y-m-d') }}" name="fromDate"
                    class="showBonds form-control">

            </div>

            <div class="col-md-3 ">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> الي تاريخ </span>

                </label>
                <input type="date" value="{{ request('toDate') ?? date('Y-m-d') }}" id="to_date" name="toDate"
                    class="showBonds form-control">

            </div>

            <div class="col-md-3">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تقرير أرباح التجار</h5>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>عدد الاوردرات</th>
                        <th>  اجمالي قيمة الاوردرات بالشحن</th>
                        <th>  اجمالي قيمة المندوب</th>
                        <th> اجمالي قيمة الشحنة</th>
                        {{-- <th>قيمة شحن المندوب</th> --}}
                        <th> المتبقي</th>
                    </tr>
                </thead>
                <tfoot style="background-color: rgb(223, 235, 242)">
                    <tr>
                        <td colspan="2">المجموع</td>
                        <td colspan="2" id="total_orders_count"></td>
                        <td id="total_orders_value"></td>
                        <td id="total_orders_shipment"></td>
                        {{-- <td id="total_delivery_value"></td> --}}
                        <td id="total_sum"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets_new/datatable/feather.min.js') }}"></script>
    <script src="{{ URL::asset('assets_new/datatable/datatables.min.js') }}"></script>
    <script>
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'order_date',
                name: 'order_date'
            },
            {
                data: 'orders_count',
                name: 'orders_count'
            },
            {
                data: 'total_value',
                name: 'total_value'
            },
            {
                data: 'delivery_value',
                name: 'delivery_value'
            },
            {
                data: 'shipment_value',
                name: 'shipment_value'
            },
            {
                data: 'company_commission',
                name: 'company_commission'
            },
        ];
        var newUrl = "{{ route('trader-profits.index') }}";
        let fromDate = "{{ request('fromDate') }}";
        let toDate = "{{ request('toDate') }}";
        let trader_id = "{{ request('trader_id') }}";
        $(function() {

            var test = $("#table").DataTable({
                processing: true,
                // pageLength: 50,
                paging: true,
                dom: 'Bfrltip',
                bLengthChange: true,
                serverSide: true,
                ajax: {
                    url: newUrl,
                    data: {
                        fromDate: fromDate,
                        toDate: toDate,
                        trader_id: trader_id
                    }
                },
                columns: columns,
                "language": <?php echo json_encode(datatable_lang()); ?>,

                "drawCallback": function(response) {
                    if (response.json) {
                        // let profit = parseFloat(response.json.total_orders_value) - parseFloat(response.json.total_orders_shipment);                        
                        $('#total_orders_count').html(response.json.total_orders_count);
                        $('#total_orders_shipment').html(response.json.total_orders_shipment);
                        $('#total_orders_value').html(response.json.total_orders_value);
                        // $('#net_profit').html(profit);
                        // $('#total_delivery_value').html(response.json.total_delivery_value);
                        $('#total_sum').html(response.json.total_sum);
                    }
                },
                searching: true,
                destroy: true,
                info: false,


            });


        });
    </script>


    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

    <script>
        (function() {

            $("#trader_id").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.getTraders') }}',
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
