@extends('Admin.layouts.inc.app')

@section('title')
    تفاصيل الخزنة
@endsection
@section('css')
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col-md-4 ">
            <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> من تاريخ </span>

            </label>
            <input type="date" id="fromDate" name="fromDate" class="showBonds form-control">

        </div>
        <div class="col-md-4">
            <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> إلي تاريخ </span>

            </label>
            <input type="date" id="toDate" name="toDate" class="showBonds form-control">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary my-4" id="filterButton">بحث</button>
        </div>
    </div>


    <div class="card">

        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>إجمالي الوارد</th>
                        <th> نقدي الوارد</th>
                        <th>غير نقدي الوارد</th>
                        <th>مدفوعات التجار</th>
                        <th>نقدي التجار</th>
                        <th>غير نقدي التجار</th>
                        <th>مصروفات إدارية</th>
                        <th>مصروفات المناديب</th>
                        <th>بنزين</th>
                        <th>الصافي </th>
                        <th> الصافي نقدي</th>
                        <th>الصافي غير نقدي</th>
                        <th> التفاصيل</th>
                    </tr>
                </thead>
                <tfoot style="text-align: center;">
                    <tr style="background-color: rgb(223, 235, 242)">
                        <td>المحصلة</td>
                        <td id="total_daily_orders"></td>
                        <td id="total_cash_orders"> </td>
                        <td id="total_cheque_orders"></td>
                        <td id="total_trader_payments"></td>
                        <td id="total_trader_cash"> </td>
                        <td id="total_trader_cheque"> </td>
                        <td id="total_expenses"></td>
                        <td id="total_fees"></td>
                        <td id="total_solar"></td>
                        <td id="total_daily_net"></td>
                        <td id="total_daily_cash_net"></td>
                        <td id="total_daily_cheque_net"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color: rgb(169, 216, 243)">الرصيـــــــــــد الســـابق</td>
                        <td colspan="2" id="previous_balance" style="background-color: rgb(169, 216, 243)"></td>
                        <td id="cash_previous_balance" style="background-color: rgb(169, 216, 243)"></td>
                        <td id="chequeprevious_balance" style="background-color: rgb(169, 216, 243)"></td>
                        <td colspan="2" style="background-color: rgb(159, 159, 235)">إجمــــالي الرصيد النهائي للخزنه</td>
                        <td colspan="2" id="finish_balance" style="background-color: rgb(159, 159, 235)"></td>
                        <td colspan="2" id="finish_cash" style="background-color: rgb(159, 159, 235)"></td>
                        <td colspan="2" id="finish_cheque" style="background-color: rgb(159, 159, 235)"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
        <div class="modal fade" id="Modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2><span id="operationType"></span>  </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <button class="btn btn-sm btn-icon btn-active-color-primary" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                    <!--end::Close-->
                </div>
                <!--begin::Modal body-->
                <div class="modal-body py-4" id="form-load">

                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light me-2">
                            الغاء
                        </button>

                    </div>
                </div>
            </div>

            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

@endsection
@section('js')
    <script src="{{ URL::asset('assets_new/datatable/feather.min.js') }}"></script>
    <script src="{{ URL::asset('assets_new/datatable/datatables.min.js') }}"></script>
    <script>
        var columns = [{
                data: 'date',
                name: 'date'
            },
            {
                data: 'daily_orders',
                name: 'daily_orders'
            },
            {
                data: 'cash_orders',
                name: 'cash_orders'
            },
            {
                data: 'cheque_orders',
                name: 'cheque_orders'
            },
            {
                data: 'trader_payments',
                name: 'trader_payments'
            },
            {
                data: 'trader_cash',
                name: 'trader_cash'
            },

            {
                data: 'trader_cheque',
                name: 'trader_cheque'
            },
            {
                data: 'expenses',
                name: 'expenses'
            },
            {
                data: 'fees',
                name: 'fees'
            },
            {
                data: 'solar',
                name: 'solar'
            },
            {
                data: 'daily_net',
                name: 'daily_net'
            },
            {
                data: 'daily_cash_net',
                name: 'daily_cash_net'
            },
            {
                data: 'daily_cheque_net',
                name: 'daily_cheque_net'
            },
            {
                data: 'details',
                name: 'details'
            },
        ];

        var newUrl = '{{ route('detailed.data') }}';
        // var newUrl = location.href;
        $(document).ready(function() {
            let table = $("#table").DataTable({
                processing: true,
                // pageLength: 50,
                paging: true,
                dom: 'Bfrltip',

                bLengthChange: true,
                serverSide: true,
                ajax: {
                    url: newUrl,
                    data: function(d) {
                        d.fromDate = $('#fromDate').val();
                        d.toDate = $('#toDate').val();
                    }
                },
                columns: columns,
                "order": [],
                "language": <?php echo json_encode(datatable_lang()); ?>,

                "drawCallback": function(response) {
                    $('#total_daily_orders').html(response.json.total_daily_orders);
                    $('#total_cash_orders').html(response.json.total_cash_orders);
                    $('#total_cheque_orders').html(response.json.total_cheque_orders);
                    $('#total_trader_payments').html(response.json.total_trader_payments);
                    $('#total_trader_cash').html(response.json.total_trader_cash);
                    $('#total_trader_cheque').html(response.json.total_trader_cheque);
                    $('#total_expenses').html(response.json.total_expenses);
                    $('#total_fees').html(response.json.total_fees);
                    $('#total_solar').html(response.json.total_solar);
                    $('#total_daily_net').html(response.json.total_daily_net);
                    $('#total_daily_cash_net').html(response.json.total_daily_cash_net);
                    $('#total_daily_cheque_net').html(response.json.total_daily_cheque_net);
                    $('#previous_balance').html(response.json.previous_balance.total_previous);
                    $('#cash_previous_balance').html('نقدي : ' + response.json.previous_balance
                        .previous_cash);
                    $('#chequeprevious_balance').html('غير نقدي : ' + response.json.previous_balance
                        .previous_cheque);
                    let finishBalance = parseFloat(response.json.previous_balance.total_previous) +
                        parseFloat(response.json.total_daily_net);
                    let finishCash = parseFloat(response.json.previous_balance.previous_cash) +
                        parseFloat(response.json.total_daily_cash_net);
                    let finishCheque = parseFloat(response.json.previous_balance.previous_cheque) +
                        parseFloat(response.json.total_daily_cheque_net);
                    $('#finish_balance').html(finishBalance);
                    $('#finish_cash').html('نقدي : ' + finishCash);
                    $('#finish_cheque').html('غير نقدي : ' + finishCheque);

                },
                searching: true,
                destroy: true,
                info: false,
            });
            $('#filterButton').on('click', function() {
                console.log('omar pero');
                table.ajax.reload();
            });
        });
    </script>
    <script>
        $(document).on('click', '.treasur_details', function() {
            var date = $(this).data('date');             
            $('#operationType').text('تفاصيل ' + date);

            var url = "{{ route("treasury-details.day", ':date') }}";
            url = url.replace(':date', date)

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#Modal').modal('show')
                    $('#form-load').html(data.view); // Load form if request is successful
                },
                error: function(xhr) {
                    if (xhr.status === 403) {
                        toastr.error('You are not authorized to perform this action.',
                            'Unauthorized');
                    } else {
                        toastr.error(
                            'An error occurred while loading the form. Please try again.',
                            'Error');
                    }
                }
            });
        });
    </script>
@endsection
