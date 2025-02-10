@extends('Admin.layouts.inc.app')
@section('title')
    المدفوع كمرتجع
@endsection
@section('css')
    <style>
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
            background-color: #fff;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
            text-align: right;
            white-space: nowrap;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #f8f9fa;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 1;
            color: #000;
            /* Changed to black */
        }

        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table tfoot {
            background-color: rgb(223, 235, 242);
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {

            .table th,
            .table td {
                padding: 0.5rem;
                font-size: 14px;
            }
        }

        /* Custom scrollbar */
        .table-container::-webkit-scrollbar {
            height: 6px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Focus styles for better accessibility */
        .table tbody tr:focus {
            outline: none;
            background-color: rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('admin.get_hadback') }}">

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
                        @isset($request['status']) @if ($request['status'] == 'partial_delivery_to_customer') selected @endif   @endisset
                        value="partial_delivery_to_customer">مسلم جزئيا</option>
                    <option
                        @isset($request['status']) @if ($request['status'] == 'not_delivery') selected @endif   @endisset
                        value="not_delivery">لم يسلم</option>

                    <option
                        @isset($request['status']) @if ($request['status'] == 'cancel') selected @endif   @endisset
                        value="cancel">لاغي </optiيذon>


                </select>


            </div>
            <div class="col-md-2">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>

    </form>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> عرض المدفوع كمرتجع</h5>


        </div>

        <div class="card-body">
            <div class="table-container">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الحالة</th>
                            <th>اسم العميل</th>
                            <th>المحافظة</th>
                            <th>رقم تليفون العميل</th>
                            <th>وقت التسليم</th>
                            <th>التاجر</th>
                            <th>عدد القطع داخل الشحنة</th>
                            <th>قيمة الشحنة</th>
                            <th>قيمة التوصيل</th>
                            <th>الملاحظات</th>
                            <th>قيمة التوصيل</th>
                            <th>تاريخ التحويل</th>
                            <th>تاريخ الانشاء</th>
                            <th>تفاصيل الطلب</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="2">عدد الأوردرات</td>
                            <td id="orders_count"></td>
                            <td>المجموع</td>
                            <td id="ahmed"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <!-- Table content will go here -->
                    </tbody>
                </table>
            </div>
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
                data: 'status',
                name: 'status'
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'province',
                name: 'province'
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
                data: 'notes',
                name: 'notes'
            },
            {
                data: 'delivery_ratio',
                name: 'delivery_ratio'
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
    @include('Admin.layouts.inc.ajax', ['url' => 'hadback'])

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
