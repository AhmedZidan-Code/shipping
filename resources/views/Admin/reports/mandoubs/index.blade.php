        @extends('Admin.layouts.inc.app')
        @section('title')
            تقارير المناديب
        @endsection
        @section('css')
        @endsection
        @section('content')
            <div class="row mb-3">
                <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                    <!--begin::Label-->
                    <label for="delivery_data" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> المندوب</span>
                    </label>
                    <select id='delivery_data' name="delivery_id" style='width: 200px;'>
                        <option selected value="0">- ابحث عن مندوب</option>
                        @if (request('delivery_id'))
                            <option value="{{ request('delivery_id') }}" selected>
                                {{ App\Models\Delivery::where('id', request('delivery_id'))->first()->name }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-4 ">
                    <label for="from_date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> من تاريخ </span>

                    </label>
                    <input type="date" id="from_date" value="{{ request('fromDate') ?? date('Y-m-d') }}" name="fromDate"
                        class="showBonds form-control">

                </div>

                <div class="col-md-4 ">
                    <label for="to_date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> الي تاريخ </span>

                    </label>
                    <input type="date" value="{{ request('toDate') ?? date('Y-m-d') }}" id="to_date" name="toDate"
                        class="showBonds form-control">

                </div>





                <div class="col-md-4">
                    <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> الحالة </span>

                    </label>

                    <select id="order_status" class="form-control showBonds" name="status">
                        <option selected disabled> جميع الحالات</option>
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

                <div class="col-md-4">
                    <button type="button" onclick="get_result();" class="btn btn-primary my-4">بحث</button>
                </div>
                <div id="result"></div>

            </div>
        @endsection
        @section('js')
            <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
            <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>



            <script>
                (function() {

                    $("#delivery_data").select2({
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


            <script>
                function get_result() {

                    var delivery_id = $('#delivery_data').val();
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var order_status = $('#order_status').val();

                    if (from_date == '' || to_date == '') {
                        alert(" من فضلك قم باختيار التواريخ");
                        return;
                    }


                    $.ajax({
                        url: '{{ route('admin.get_delivery_orders') }}',
                        type: 'POST',
                        data: {
                            delivery_id: delivery_id,
                            from_date: from_date,
                            to_date: to_date,
                            order_status: order_status
                        },
                        beforeSend: function() {

                        },
                        complete: function() {},
                        success: function(data) {
                            $('#result').html(data);

                            //$('.delivery_value'+valu).val(data);
                            // get_order_value(valu);
                        },

                        error: function(data) {


                        }, //end error method


                    });
                }
            </script>
            <script>
                $(document).on('click', '.myCheckboxClass', function() {
                    let ORDERS_COUNT = parseInt($('#all_orders').val(), 10) || 0;
                    let MANDOUB_ORDERS = parseInt($('#mandoub_orders').val(), 10) || 0;
                    let TOTAL_SHIPPING = parseInt($('#total_shipping').val(), 10) || 0;
                    let TOTAL_ORDERS = parseInt($('#total_orders').val(), 10) || 0;

                    let CASES = [
                        'total_delivery_to_customer',
                        'paid',
                        'not_delivery',
                        'partial_delivery_to_customer'
                    ];

                    const status = $(this).data('status');

                    let TOTAL_VALUE = {
                        'total_delivery_to_customer': parseInt($(this).data('total')) || 0,
                        'paid': parseInt($(this).data('total')) || 0,
                        'not_delivery': parseInt($(this).data('shipping')) || 0,
                        'partial_delivery_to_customer': parseInt($(this).data('partial')) || 0
                    };

                    if ($(this).is(':checked')) {
                        $('#all_orders').val(ORDERS_COUNT + 1);
                        if (CASES.includes(status)) {
                            $('#mandoub_orders').val(MANDOUB_ORDERS + 1);
                            $('#total_shipping').val(TOTAL_SHIPPING + (parseInt($(this).data('shipping')) || 0));

                            const valueToAdd = parseInt(TOTAL_VALUE[status]) || 0;
                            $('#total_orders').val(TOTAL_ORDERS + valueToAdd);
                        }
                    } else {
                        $('#all_orders').val(ORDERS_COUNT - 1);
                        if (CASES.includes(status)) {
                            $('#mandoub_orders').val(MANDOUB_ORDERS - 1);
                            $('#total_shipping').val(TOTAL_SHIPPING - (parseInt($(this).data('shipping')) || 0));

                            const valueToSubtract = parseInt(TOTAL_VALUE[status]) || 0;
                            $('#total_orders').val(TOTAL_ORDERS - valueToSubtract);
                        }
                    }
                    calculate_remainder();
                });
            </script>
            {{-- new scripts fro get_reports --}}
            <script>
                $(document).on('click', '.StatusTotalDelivery', function() {
                    var id = $(this).attr('data-id');


                    $('#form-load').html(loader_form)


                    $('#Modal').modal('show')

                    var url = "{{ route('admin.changeStatusForOrder', ':id') }}";
                    url = url.replace(':id', id);
                    setTimeout(function() {
                        $('#form-load').load(url)
                    }, 1000)

                })
            </script>
            <script>
                $(document).ready(function() {
                    if (!$.fn.DataTable.isDataTable('#table2')) {
                        $('#table2').DataTable({
                            scrollx: true
                        });
                    } else {
                        $('#table2').DataTable().destroy();
                        $('#table2').DataTable({
                            scrollx: true
                        });
                    }
                });
            </script>
            @include('Admin.layouts.inc.ajax', ['url' => 'orders'])
            <script>
                $('#Modal').on('shown.bs.modal', function(event) {
                    $(document).ready(function() {

                        setTimeout(function() {
                            $(".delivery_id").select2({
                                placeholder: 'Channel...',
                                allowClear: true,
                                dropdownParent: $('#Modal'), // Attach the dropdown to the modal
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
                        }, 1500); //// 2000 milliseconds = 2 seconds

                    });
                });
            </script>
            <script>
                $(document).on('click', '.insertDelivery', function() {


                    var id = $(this).attr('data-id');

                    var route = "{{ route('admin.getDeliveryForOrder', ':id') }}";

                    route = route.replace(':id', id);



                    $('#form-load-delivery').html(loader_form)

                    $('#Modal-delivery').modal('show');



                    setTimeout(function() {
                        $('#form-load-delivery').load(route)
                    }, 1000)
                })
            </script>
            <script>
                $(document).on('submit', "#form-delivery", function(e) {
                    e.preventDefault();

                    var id = $('#order_id_delivery').val();

                    var route = "{{ route('admin.insertingDeliveryForOrder', ':id') }}";
                    route = route.replace(':id', id);

                    var formData = new FormData(this);

                    var url = $('#form-delivery > form').attr('action');
                    $.ajax({
                        url: route,
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {


                            $('#submit-delivery').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                                ' ></span> <span style="margin-left: 4px;">{{ trans('admin.working') }}</span>'
                            ).attr('disabled', true);
                            $('#form-load-delivery').append(loader_form)
                            $('#form-load-delivery > form').hide()
                        },
                        complete: function() {},
                        success: function(data) {

                            window.setTimeout(function() {
                                $('#submit-delivery').html('{{ trans('admin.submit') }}').attr(
                                    'disabled', false);

                                if (data.code == 200) {
                                    toastr.success(data.message)
                                    $('#Modal-delivery').modal('hide')
                                    $('#form-load-delivery > form').remove()
                                    $('#table').DataTable().ajax.reload(null, false);
                                } else {
                                    $('#form-load-delivery > .linear-background').hide(loader_form)
                                    $('#form-load-delivery > form').show()
                                    toastr.error(data.message)
                                }
                            }, 1000);
                        },
                        error: function(data) {
                            $('#form-load-delivery > .linear-background').hide(loader_form)
                            $('#submit-delivery').html('{{ trans('admin.submit') }}').attr('disabled', false);
                            $('#form-load-delivery > form').show()
                            if (data.status === 500) {
                                toastr.error('{{ trans('admin.error') }}')
                            }
                            if (data.status === 422) {
                                var errors = $.parseJSON(data.responseText);

                                $.each(errors, function(key, value) {
                                    if ($.isPlainObject(value)) {
                                        $.each(value, function(key, value) {
                                            toastr.error(value)
                                        });

                                    } else {

                                    }
                                });
                            }
                            if (data.status == 421) {
                                toastr.error(data.message)
                            }

                        }, //end error method

                        cache: false,
                        contentType: false,
                        processData: false
                    });
                });
            </script>

            <script>
                $(document).on('click', '.changeStatusData', function() {

                    var id = $(this).attr('data-id');

                    $('#row_id').val(id);


                    $('#form-load').html(loader_form)

                    $('#Modal').modal('show')

                    var url = "{{ route('admin.changeStatusForOrder', ':id') }}";
                    url = url.replace(':id', id);
                    setTimeout(function() {
                        $('#form-load').load(url)
                    }, 1000)


                })
            </script>



            <script>
                $(document).on('click', '.active2', function() {

                    var status = $('#status-convert').val();

                    var row_id = $('#row_id').val();
                    $.ajax({
                        url: '{{ route('admin.change_button') }}',
                        type: 'POST',
                        data: {
                            row_id: row_id,
                            status: status
                        },
                        beforeSend: function() {

                        },
                        complete: function() {},
                        success: function(data) {
                            // alert(data);
                            $('#td' + row_id).html(data);
                            //$('.delivery_value'+valu).val(data);
                            // get_order_value(valu);

                            // location.reload();
                        },

                        error: function(data) {


                        }, //end error method


                    });


                })
            </script>

            <script>
                $(document).on('click', '.StatusNotDelivery', function() {

                    var id = $(this).attr('data-id');




                    $('#form-load').html(loader_form)

                    $('#Modal').modal('show')

                    var url = "{{ route('admin.changeStatusForOrder', ':id') }}";
                    url = url.replace(':id', id);
                    setTimeout(function() {
                        $('#form-load').load(url)
                    }, 1000)


                })
            </script>


            <script>
                $(document).on('click', '.StatusCancel', function() {

                    var id = $(this).attr('data-id');




                    $('#form-load').html(loader_form)

                    $('#Modal').modal('show')

                    var url = "{{ route('admin.changeStatusForOrder', ':id') }}";
                    url = url.replace(':id', id);
                    setTimeout(function() {
                        $('#form-load').load(url)
                    }, 1000)


                })
            </script>

            <script>
                $(document).on('click', '.StatusDelaying', function() {

                    var id = $(this).attr('data-id');

                    $('#form-load').html(loader_form)

                    $('#Modal').modal('show')

                    var url = "{{ route('admin.changeStatusForOrder', ':id') }}";
                    url = url.replace(':id', id);
                    setTimeout(function() {
                        $('#form-load').load(url)
                    }, 1000)


                })
            </script>

            <script>
                $(document).on('click', '.StatusPartialDelivery', function() {

                    var id = $(this).attr('data-id');

                    $('#form-load').html(loader_form)

                    $('#Modal').modal('show')

                    var url = "{{ route('admin.changeStatusForOrder', ':id') }}";
                    url = url.replace(':id', id);
                    setTimeout(function() {
                        $('#form-load').load(url)
                    }, 1000)


                })
            </script>

            <!----------------------------------------------------------------------------------------------------------------------------------------------->
            <!------------------------------------------------------------------------------------------------------------------------------------------------>
            <script>
                function save_result(button) {
                    if ($('#remainder').val() < 0) {
                        alert('قيمة المتبقي أصغر من الصفر');
                        return;
                    }
                    var delivery_id = $('.delivery_id').val();
                    var all_orders = $('#all_orders').val();
                    var mandoub_orders = $('#mandoub_orders').val();
                    var total_shipping = $('#total_shipping').val();
                    var total_orders = $('#total_orders').val();
                    var cash = $('#cash').val();
                    var cheque = $('#cheque').val();
                    var month = $('#month').val();
                    var fees = $('#fees').val();
                    var solar = $('#solar').val();
                    var day_date = $('#day_date').val();
                    var selectedValues = [];
                    var status = [];
                    $('.myCheckboxClass:checked').each(function() {
                        selectedValues.push($(this).val());
                        status.push($(this).attr('data-status'));
                    });

                    if (selectedValues.length === 0) {
                        alert("من فضلك قم بادخال الاوردرات");
                        return;
                    }

                    if (delivery_id === '' || all_orders === '') {
                        alert("من فضلك قم باختيار المندوب");
                        return;
                    }
                    // Disable the button
                    let $btn = $(button);
                    $btn.prop('disabled', true).text('جاري المعالجة...');

                    $.ajax({
                        url: '{{ route('admin.add_delivery_orders') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            delivery_id: delivery_id,
                            all_orders: all_orders,
                            mandoub_orders: mandoub_orders,
                            total_shipping: total_shipping,
                            total_orders: total_orders,
                            cash: cash,
                            cheque: cheque,
                            selectedValues: selectedValues,
                            status: status,
                            month: month,
                            fees: fees,
                            solar: solar,
                            day_date: day_date
                        },
                        beforeSend: function() {
                            // Optional: Add loading spinner or disable submit button
                        },
                        complete: function() {
                            // Optional: Remove loading spinner or enable submit button
                        },
                        success: function(data) {
                            toastr.success(data.message);
                            setTimeout(function() {
                                location.reload();
                                $btn.prop('disabled', false).text('حفظ');

                            }, 1000);
                        },
                        error: function(data) {

                            $('#submit').html('{{ trans('admin.submit') }}').attr('disabled', false);

                            if (data.status === 500) {
                                toastr.error(data.responseJSON.message);
                                console.log(data.message);
                            } else if (data.status === 422) {
                                var errors = $.parseJSON(data.responseText);
                                $.each(errors, function(key, value) {
                                    if ($.isPlainObject(value)) {
                                        $.each(value, function(key, value) {
                                            toastr.error(value);
                                        });
                                    }
                                });
                                $btn.prop('disabled', false).text('حفظ');
                            } else if (data.status === 421) {
                                toastr.error(data.message);
                                $btn.prop('disabled', false).text('حفظ');

                            }
                        },

                    });
                }
            </script>
            <script>
                $(document).ready(function() {
                    $('#cheque').on('keyup', function() {
                        var totalValue = parseFloat($('#total_orders').val()) || 0;
                        var chequeValue = parseFloat($(this).val()) || 0;
                        var cashValue = parseFloat($('#cash').val()) || 0;

                        if (chequeValue + cashValue > totalValue) {
                            alert('لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ')
                        }

                    });
                });
                $(document).ready(function() {
                    $('#cash').on('keyup', function() {
                        var totalValue = parseFloat($('#total_orders').val()) || 0;
                        var cashValue = parseFloat($(this).val()) || 0;
                        var chequeValue = parseFloat($('#cheque').val()) || 0;

                        if (chequeValue + cashValue > totalValue) {
                            alert('لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ')
                        }

                    });
                });

                function calculate_remainder() {
                    let remainder = 0;
                    let total = parseFloat($('#total_orders').val()) || 0;
                    let cash = parseFloat($('#cash').val()) || 0;
                    let cheque = parseFloat($('#cheque').val()) || 0;
                    let solar = parseFloat($('#solar').val()) || 0;
                    let fees = parseFloat($('#fees').val()) || 0;
                    $('#remainder').val(total - cash - cheque - solar - fees);
                }
            </script>
        @endsection
