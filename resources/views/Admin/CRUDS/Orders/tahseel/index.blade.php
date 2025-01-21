@extends('Admin.layouts.inc.app')
@section('title')
    المرتجعات
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('Tahseel.index') }}">

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
                        @isset($request['status']) @if ($request['status'] == 'total_delivery_to_customer') selected @endif   @endisset
                        value="not_delivery">مسلم كليا</option>



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
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th> <input type="checkbox" id="checkAll"></th>
                        <th>#</th>
                        <th>الحالة</th>

                        <th>اسم العميل</th>
                        <th>المحافظة</th>

                        <th>رقم تليفون العميل</th>

                        <th>التاجر</th>

                        <th> الاجمالي</th>
                        <th> قيمه التوصيل</th>

                        <th>قيمة الشحنة</th>
                        <th> الملاحظات</th>
                        <th>تاريخ التحويل</th>
                        <th> تاريخ الانشاء</th>

                        <th> تفاصيل الطلب</th>
                    </tr>
                <tfoot>
                    <tr style="background: whitesmoke;">
                        <td> </td>


                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> المجموع </td>
                        <td id="ahmed"> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                    </tr>


                </tfoot>

            </table>
            @if (request('trader_id'))
                <div class="row">
                    <div class="col-md-2 ">
                        <label for="number" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> المبلغ </span>
                        </label>
                        <input type="number" name="total" id="total_value" class="showBonds form-control" disabled>
                    </div>
                    <div class="col-md-2 ">
                        <label for="cash" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> نقدي </span>
                        </label>
                        <input type="number" id="cash" name="cashe" class="showBonds form-control">
                    </div>
                    <div class="col-md-2 ">
                        <label for="cheque" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> غير نقدي</span>
                        </label>
                        <input type="number" id="cheque" name="cheque" class="showBonds form-control">
                    </div>
                    <div class="col-md-3 ">
                        <label for="date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> التاريخ </span>
                        </label>
                        <input type="date" id="date" name="date" class="showBonds form-control">
                    </div>
                    <div class="col-md-3 ">
                        <label for="notes" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> الملاحظات </span>
                        </label>
                        <textarea id="notes" name="notes" class="showBonds form-control"></textarea>
                    </div>
                    <div class="col-md-3 ">
                        <button class="btn btn-success" onclick="change_status();" style="margin-right: 80%; width: 200px;">
                            تم
                            الدفع</button>
                    </div>

                </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
    <script>
        var columns = [

            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false
            },
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
                data: 'province_id',
                name: 'province_id'
            },

            {
                data: 'customer_phone',
                name: 'customer_phone'
            },

            {
                data: 'trader.name',
                name: 'trader.name'
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
                data: 'notes',
                name: 'notes'
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
    @include('Admin.layouts.inc.ajax', ['url' => 'Tahseel'])

    <script>
        $(document).ready(function() {
            let totalValue = 0;

            // Function to update total value
            function updateTotalValue() {
                totalValue = 0;
                $('.myCheckboxClass:checked').each(function() {
                    totalValue += parseFloat($(this).attr('data_base')) || 0;
                });
                $('#total_value').val(totalValue.toFixed(2));
                console.log('Total Value:', totalValue);
            }

            // Individual checkbox change event
            $(document).on('change', '.myCheckboxClass', function() {
                updateTotalValue();
                updateCheckAllState();
            });

            // Check All checkbox
            $('#checkAll').on('change', function() {
                let isChecked = $(this).prop('checked');
                $('.myCheckboxClass').prop('checked', isChecked);
                updateTotalValue();
            });

            // Function to update Check All state
            function updateCheckAllState() {
                let totalCheckboxes = $('.myCheckboxClass').length;
                let checkedCheckboxes = $('.myCheckboxClass:checked').length;
                $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            }

            // Initial setup
            updateTotalValue();
            if (checkedCheckboxes) {
                updateCheckAllState();
            }
        });

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
        });
    </script>

    <script>
        // let totalValue = 0;

        // $(document).on('change', '.myCheckboxClass', function() {
        //     let dataBaseValue = parseFloat($(this).attr('data_base')) || 0;

        //     if ($(this).is(':checked')) {
        //         totalValue += dataBaseValue;
        //     } else {
        //         totalValue -= dataBaseValue;
        //     }
        //     $('#total_value').val(totalValue);
        //     console.log(totalValue);

        // });


        function change_status(button) {
            var selectedValues = [];
            let tota_balance = $('#total_value').val();
            let date = $('#date').val();
            let cash = $('#cash').val();
            let cheque = $('#cheque').val();
            let notes = $('#notes').val();
            let trader_id = '{{ request('trader_id') }}';

            $('.myCheckboxClass:checked').each(function() {
                selectedValues.push($(this).val());
            });

            if (selectedValues.length === 0) {
                alert("من فضلك قم بادخال الاوردرات");
                return;
            }

            // Disable the button
            $(button).prop('disabled', true);

            $.ajax({
                url: '{{ route('Tahseel.store') }}',
                type: 'POST',
                data: {
                    trader_id: trader_id,
                    tota_balance: tota_balance,
                    date: date,
                    cash: cash,
                    cheque: cheque,
                    notes: notes,
                    selectedValues: selectedValues,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    // Optionally show a loader
                },
                success: function(data) {
                    if (data.code === 200) {
                        toastr.success(data.message);
                        $('#table').DataTable().ajax.reload(null,
                        false); // Reload the table without resetting pagination
                        setTimeout(function() {
                            location.reload(); // Refresh the page after a delay
                        }, 1000); // 1-second delay
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(jqXHR) {
                    if (jqXHR.status === 422) { // Laravel validation error
                        var errors = jqXHR.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('حدث خطأ غير متوقع، حاول مرة أخرى.');
                    }
                },
                complete: function() {
                    // Enable the button after the AJAX call is complete, regardless of success or error
                    $(button).prop('disabled', false);
                }
            });
        }
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
        $(document).ready(function() {
            $('#cheque').on('keyup', function() {
                var totalValue = parseFloat($('#total_value').val()) || 0;
                var chequeValue = parseFloat($(this).val()) || 0;
                var cashValue = parseFloat($('#cash').val()) || 0;

                if (chequeValue + cashValue > totalValue) {
                    alert('لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ')
                }

            });
        });
        $(document).ready(function() {
            $('#cash').on('keyup', function() {
                var totalValue = parseFloat($('#total_value').val()) || 0;
                var cashValue = parseFloat($(this).val()) || 0;
                var chequeValue = parseFloat($('#cheque').val()) || 0;

                if (chequeValue + cashValue > totalValue) {
                    alert('لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ')
                }

            });
        });
    </script>
@endsection
