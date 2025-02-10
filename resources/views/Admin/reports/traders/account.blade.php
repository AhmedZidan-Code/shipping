@extends('Admin.layouts.inc.app')
@section('title')
    تقارير التجار
@endsection
@section('css')
    <style>
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin: 20px 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .responsive-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .responsive-table th,
        .responsive-table td {
            padding: 12px 15px;
            text-align: right;
            border: 1px solid #ddd;
            white-space: nowrap;
        }

        .responsive-table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .responsive-table tfoot {
            background-color: rgb(223, 235, 242);
        }

        .responsive-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .responsive-table tbody tr:hover {
            background-color: #f5f5f5;
        }

        @media screen and (max-width: 768px) {
            .table-container {
                margin: 10px 0;
            }

            .responsive-table th,
            .responsive-table td {
                padding: 8px 10px;
                font-size: 14px;
            }
        }

        /* Custom scrollbar for better UX */
        .table-container::-webkit-scrollbar {
            height: 6px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('trader-accounts.index', ['trader_id' => request('trader_id')]) }}" method="GET">
        @csrf
        <div class="row mb-3">
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
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>عدد الاوردرات</th>
                            <th>العملية</th>
                            <th>المبلغ</th>
                            <th>المتبقي</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>الاجمالي</th>
                            <th id="total"></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets_new/datatable/feather.min.js') }}"></script>
    <script src="{{ URL::asset('assets_new/datatable/datatables.min.js') }}"></script>

    @if (request('trader_id'))
        <script>
            var columns = [{
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'order_count',
                    name: 'order_count'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'remainder',
                    name: 'remainder'
                },
            ];
            var newUrl = "{{ route('trader-accounts.index', ['trader_id' => request('trader_id')]) }}";
            $(function() {

                var table = $("#table").DataTable({
                    processing: true,
                    // pageLength: 50,
                    paging: false,
                    dom: 'Bfrltip',
                    bLengthChange: true,
                    serverSide: true,
                    ajax: {
                        url: newUrl,
                        data: {
                            fromDate: "{{ request('fromDate') }}",
                            toDate: "{{ request('toDate') }}",
                            trader_id: "{{ request('trader_id') }}",
                        }
                    },
                    columns: columns,
                    // order: [
                    //     [0, "asc"]
                    // ],
                    "language": <?php echo json_encode(datatable_lang()); ?>,

                    "drawCallback": function(settings) {
                        if (settings.json && settings.json.rowsCount) {
                            $('#rows-count').val(settings.json.rowsCount);
                            $('#total').val(settings.json.total);

                        }

                        if (settings.json && settings.json.total_sum) {
                            console.log(settings.json.total_sum);

                            $('#total_sum').html(settings.json.total_sum); // Update total sum
                        }
                        if (settings.json && settings.json.total) {

                            $('#total').html(settings.json.total); // Update total sum
                        }

                        $('#ahmed').html(settings.json.total2);
                        updateLatestValue();

                    },
                    searching: true,
                    destroy: true,
                    info: false,


                });

                function updateLatestValue() {
                    let columnData = table.column(4).data().toArray();
                    let lastValue = columnData[columnData.length - 1];
                    $("#total").text(lastValue ? lastValue : 0);
                }
            });
        </script>
    @endif


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
