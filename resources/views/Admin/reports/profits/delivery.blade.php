@extends('Admin.layouts.inc.app')
@section('title')
    تقارير أرباح المناديب
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('delivery-profits.index') }}">
        <div class="row mb-3">

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

            <div class="d-flex flex-column mb-7  col-sm-3">
                <label for="month-select" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">اختر الشهر:</label>
                <select id="month-select" class="select2" name="month">
                    <!-- Options will be dynamically added -->
                    <option value="">الشهر </option>
                    @php
                        $months = [
                            1 => 'يناير',
                            2 => 'فبراير',
                            3 => 'مارس',
                            4 => 'ابريل',
                            5 => 'مايو',
                            6 => 'يونيو',
                            7 => 'يوليو',
                            8 => 'أغسطس',
                            9 => 'سبتمبر',
                            10 => 'أكتوبر',
                            11 => 'نوفمبر',
                            12 => 'ديسمبر',
                        ];
                    @endphp
                    @foreach ($months as $key => $month)
                        <option value="{{ $key }}" {{ request('month') == $key ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex flex-column mb-7  col-sm-3">
                <label for="year-select" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">اختر السنة:</label>
                <select id="year-select" class="select2" name="year">
                    @php
                        $currentYear = date('Y');
                        $startYear = 2015;
                    @endphp
                    @for ($year = $currentYear; $year >= $startYear; $year--)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>

            </div>
            <div class="col-md-3">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تقارير أرباح المناديب</h5>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>عدد الاوردرات</th>
                        <th>عمولة الشركة</th>
                        {{-- <th>قيمة المندوب</th> --}}
                        <th>المصروفات الادارية</th>
                        {{-- <th>البنزين</th> --}}
                        <th>المتبقي</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="2">المجموع</td>
                        <td id="orders_sum"></td>
                        <td id="commission_sum"></td>
                        <td id="expenses_sum"></td>
                        <td id="total_remainder"></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td>اجمالي الرواتب</td>
                        <td id="total_salary"></td>
                        <td colspan="2">صـــــافي الربح</td>
                        <td colspan="2" id="net_profit"></td>
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
                data: 'date',
                name: 'date'
            },
            {
                data: 'num_mandoub_orders',
                name: 'num_mandoub_orders'
            },
            {
                data: 'company_commission',
                name: 'company_commission'
            },
            // {
            //     data: 'mandoub_commission',
            //     name: 'mandoub_commission'
            // },
            {
                data: 'expenses',
                name: 'expenses'
            },
            // {
            //     data: 'solar',
            //     name: 'solar'
            // },
            {
                data: 'remainder',
                name: 'remainder'
            },
        ];
        var newUrl = "{{ route('delivery-profits.index') }}";
        let month = "{{ request('month') }}";
        let year = "{{ request('year') }}";
        let delivery_id = "{{ request('delivery_id') }}";
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
                        month: month,
                        year: year,
                        delivery_id: delivery_id
                    }
                },
                columns: columns,
                "language": <?php echo json_encode(datatable_lang()); ?>,

                "drawCallback": function(response) {

                    if (response.json) {
                        $('#total_salary').html(response.json.total_salary);
                        $('#total_remainder').html(response.json.total_remainder);
                        $('#net_profit').html(response.json.net_profit);
                        $('#orders_sum').html(response.json.orders_sum);
                        $('#commission_sum').html(response.json.commission_sum);
                        $('#expenses_sum').html(response.json.expenses_sum);
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
        $(".select2").select2({});
    </script>


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
