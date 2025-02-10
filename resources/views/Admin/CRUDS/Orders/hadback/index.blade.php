@extends('Admin.layouts.inc.app')
@section('title')
    المرتجعات
@endsection
@section('css')
    <style>
        .row {
            flex-wrap: nowrap !important;
        }

        .form-control {
            width: 150px;
            height: 38px;
        }

        textarea.form-control {
            resize: none;
            height: 38px;
        }

        .btn-success {
            height: 38px;
            width: 120px;
            white-space: nowrap;
        }

        .required::after {
            content: "*";
            color: red;
            margin-right: 4px;
        }

        .col-auto {
            padding: 0 8px;
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('hadback.index') }}">

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

                    <option
                        @isset($request['status']) @if ($request['status'] == 'shipping_on_messanger') selected @endif   @endisset
                        value="shipping_on_messanger"> الشحن علي الراسل </optiيذon>

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

                <tfoot style="background-color: rgb(223, 235, 242)">
                    <tr>
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
                <div dir="rtl">
                    <div class="row d-flex align-items-end justify-content-between g-3 mx-2">
                        <div class="col-auto">
                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required">عدد الاوردرات</span>
                            </label>
                            <input type="number" name="orders_count" id="orders_count" class="showBonds form-control"
                                disabled>
                        </div>

                        <div class="col-auto">
                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required">المبلغ</span>
                            </label>
                            <input type="number" name="total" id="total_value" class="showBonds form-control" disabled>
                        </div>

                        <div class="col-auto">
                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required">التاريخ</span>
                            </label>
                            <input type="date" id="date" name="date" class="showBonds form-control">
                        </div>

                        <div class="col-auto">
                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required">الملاحظات</span>
                            </label>
                            <textarea id="notes" name="notes" class="showBonds form-control"></textarea>
                        </div>

                        <div class="col-auto">
                            <button class="btn btn-success" onclick="change_status(this);">
                                تم الدفع
                            </button>
                        </div>
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
    @include('Admin.layouts.inc.ajax', ['url' => 'hadback'])
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
                countCheckedCheckboxes();
            });

            // Check All checkbox
            $('#checkAll').on('change', function() {
                let isChecked = $(this).prop('checked');
                $('.myCheckboxClass').prop('checked', isChecked);
                updateTotalValue();
                countCheckedCheckboxes();
            });
            // Function to update Check All state
            function updateCheckAllState() {
                let totalCheckboxes = $('.myCheckboxClass').length;
                let checkedCheckboxes = $('.myCheckboxClass:checked').length;
                $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            }

            function countCheckedCheckboxes() {
                let checkedCount = $('.myCheckboxClass:checked').length;
                console.log("Checked checkboxes: " + checkedCount);
                $('#orders_count').val(checkedCount); // If you want to display count in HTML
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
        })
    </script>

    <script>
        function change_status(button) {
            var selectedValues = [];
            let amount = $('#total_value').val();
            let orders_count = $('#orders_count').val();
            let date = $('#date').val();
            let notes = $('#notes').val();
            let trader_id = {{ request('trader_id') }};

            // Collect selected values only once
            $('.myCheckboxClass:checked').each(function() {
                selectedValues.push($(this).val());
            });

            if (selectedValues.length === 0) {
                alert("من فضلك قم بادخال الاوردرات");
                return;
            }

            // Disable the button
            let $btn = $(button);
            $btn.prop('disabled', true).text('جاري المعالجة...');

            $.ajax({
                url: '{{ route('hadback.store') }}',
                type: 'POST',
                data: {
                    amount: amount,
                    orders_count: orders_count,
                    date: date,
                    notes: notes,
                    trader_id: trader_id,
                    selectedValues: selectedValues,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    // Optionally show a loader
                },
                success: function(data) {
                    if (data.code === 200) {
                        toastr.success(data.message);
                        $('#table').DataTable().ajax.reload(null, false); // Reload table data
                        setTimeout(function() {
                            location.reload(); // Refresh page after 1 second
                        }, 1000);
                    } else {
                        toastr.error(data.message);
                    }
                    $btn.prop('disabled', false).text('تم الدفع');
                },
                error: function(jqXHR) {
                    if (jqXHR.status === 422) { // Laravel validation error
                        var errors = jqXHR.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]); // Show validation error
                        });
                    } else {
                        toastr.error('حدث خطأ غير متوقع، حاول مرة أخرى.');
                    }
                    $btn.prop('disabled', false).text('تم الدفع');
                },
                complete: function() {
                    // Enable the button after the AJAX call
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
    </script>
@endsection
