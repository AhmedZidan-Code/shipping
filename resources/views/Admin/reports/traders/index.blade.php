@extends('Admin.layouts.inc.app')
@section('title')
    تقارير التجار
@endsection
@section('css')
    <style>
        .table-container {
            max-width: 100%;
            margin: 1rem 0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .responsive-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            background-color: #fff;
        }

        .responsive-table th,
        .responsive-table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            white-space: nowrap;
            text-align: right;
        }

        .responsive-table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .responsive-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .responsive-table tbody tr:hover {
            background-color: #f2f2f2;
        }

        .responsive-table tfoot {
            background-color: #dfebf2;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            .table-container {
                margin: 0.5rem -15px;
                padding: 0 15px;
            }

            .responsive-table th,
            .responsive-table td {
                padding: 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('tradersReports.index') }}">

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
                <input type="date" id="toDate" value="{{ request('toDate') }}" name="toDate"
                    class="showBonds form-control">
            </div>

            <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                <!--begin::Label-->
                <label for="trader_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> التاجر</span>
                </label>
                <select id='trader_id' name="trader_id" style='width: 200px;'>
                    <option selected value="0">- ابحث عن التاجر</option>
                    @if (request('trader_id'))
                        <option value="{{ request('trader_id') }}" selected>
                            {{ App\Models\Trader::where('id', request('trader_id'))->first()->name }}</option>
                    @endif
                </select>
            </div>

            <div class="col-md-4">
                <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> الحالة </span>

                </label>

                <select id="order_status" class="form-control showBonds" name="status">
                    <option selected disabled>اختر</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'new') selected @endif   @endisset
                        value="new">جديد</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'converted_to_delivery') selected @endif   @endisset
                        value="converted_to_delivery">محول الي مندوب</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'total_delivery_to_customer') selected @endif   @endisset
                        value="total_delivery_to_customer">مسلم كليا</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'partial_delivery_to_customer') selected @endif   @endisset
                        value="partial_delivery_to_customer">مسلم جزئيا</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'not_delivery') selected @endif   @endisset
                        value="not_delivery">لم يسلم</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'under_implementation') selected @endif   @endisset
                        value="under_implementation">تحت التنفيذ</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'delaying') selected @endif   @endisset
                        value="delaying">مؤجل </optiيذon>

                    <option
                        @isset($request['status']) @if ($request['status'] == 'cancel') selected @endif   @endisset
                        value="cancel">لاغي </optiيذon>


                    <option
                        @isset($request['status']) @if ($request['status'] == 'collection') selected @endif   @endisset
                        value="collection">التحصيل</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'paid') selected @endif   @endisset
                        value="paid">الدفع</option>

                </select>


            </div>
            <div class="col-md-2">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>

    </form>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تقارير التجار</h5>


        </div>

        <div class="card-body">
            <div class="table-container">
                <table id="table" class="responsive-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الحالة</th>
                            <th>المندوب</th>
                            <th>اسم العميل</th>
                            <th>المحافظة</th>
                            <th>عنوان العميل</th>
                            <th>رقم تليفون العميل</th>
                            <th>وقت التسليم</th>
                            <th>التاجر</th>
                            <th>عدد القطع داخل الشحنة</th>
                            <th>قيمة الشحنة</th>
                            <th>قيمة التوصيل</th>
                            <th>قيمة المندوب</th>
                            <th>الاجمالي</th>
                            <th>تاريخ التحويل</th>
                            <th>تاريخ الانشاء</th>
                            <th>تفاصيل الطلب</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="2">عدد الاوردرات</th>
                            <th id="orders_count"></th>
                            <th></th>
                            <th>الاجمالي</th>
                            <th id="ahmed"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <!-- Table body content will be dynamically added -->
                    </tbody>
                </table>
            </div>
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
                data: 'status',
                name: 'status'
            },
            {
                data: 'delivery_id',
                name: 'delivery_id'
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'province.title',
                name: 'province.title'
            },
            {
                data: 'customer_address',
                name: 'customer_address'
            },
            {
                data: 'customer_phone',
                name: 'customer_phone'
            },
            {
                data: 'delivery_time',
                name: 'delivery_time'
            },
            {
                data: 'trader.name',
                name: 'trader.name'
            },
            {
                data: 'shipment_pieces_number',
                name: 'shipment_pieces_number'
            },
            {
                data: 'shipment_value',
                name: 'shipment_value'
            },
            {
                data: 'delivery_value',
                name: 'delivery_value'
            },
            {
                data: 'delivery_ratio',
                name: 'delivery_ratio'
            },
            {
                data: 'total_value',
                name: 'total_value'
            },
            {
                data: 'converted_date',
                name: 'converted_date'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'orderDetails',
                name: 'orderDetails'
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'tradersReports'])

    <script>
        $(document).on('change', '.showBonds', function() {
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var trader_id = $('#trader_id').val();
            var status = $('#order_status').val();

            var url = "{{ route('tradersReports.index') }}";
            url = url + "?-=-";
            if (fromDate != null) {
                url = url + "&&fromDate=" + fromDate;
            }
            if (toDate != null) {
                url = url + "&&toDate=" + toDate;
            }
            if (trader_id != null) {
                url = url + "&&trader_id=" + trader_id;
            }
            if (status != null) {
                url = url + "&&status=" + status;
            }
            // window.location.href = url;
        })
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
