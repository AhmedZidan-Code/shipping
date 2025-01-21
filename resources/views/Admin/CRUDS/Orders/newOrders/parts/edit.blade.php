@extends('Admin.layouts.inc.app')
@section('title')
    اضافة طلب
@endsection
@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />
    <style>
        .my-div {
            position: relative;
        }

        .my-div i {
            position: absolute;
            top: 10px;
            /* adjust as needed */
            right: 10px;
            /* adjust as needed */
        }
    </style>
@endsection

@section('page-title')
    تعديل طلب
@endsection



@section('content')
    <div class="card">
        <div class="card-header ">





            <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('orders.update', $order->id) }}">
                @csrf
                @method('PUT')
                <div id="container-data">

                    <div class="card-body">
                        <div class="row  g-4">


                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="customer_name-1" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1">اسم العميل</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="customer_name-1" name="customer_name" class="form-control"
                                    value="{{ $order->customer_name }}">
                            </div>


                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="province_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> المدن</span>
                                </label>
                                <select id='province_id' onchange="get_delivery_value(1)" class="province_id1"
                                    name="province_id" style='width: 200px;'>
                                    <option selected value="{{ $order->province->id ?? null }}">
                                        {{ $order->province->title ?? '' }}</option>
                                </select>
                            </div>


                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="customer_address-1"
                                    class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> عنوان العميل</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="customer_address-1" name="customer_address" class="form-control"
                                    value="{{ $order->customer_address }}">
                            </div>


                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="customer_phone-1"
                                    class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1">هاتف العميل</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="customer_phone-1" name="customer_phone" class="form-control"
                                    value="{{ $order->customer_phone }}">
                            </div>


                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="shipment_value-1"
                                    class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> قيمة الاوردر</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" min="0" id="shipment_value-1" name="shipment_value"
                                    class="form-control" value="{{ $order->shipment_value }}">
                            </div>



                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="delivery_value-1"
                                    class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> قيمة التوصيل</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" min="0" id="delivery_value-1" name="delivery_value"
                                    class="form-control" value="{{ $order->delivery_value }}">
                            </div>



                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="delivery_ratio" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> قيمة المندوب</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" id="delivery_ratio-1" name="delivery_ratio" class="form-control"
                                    value="{{ $order->delivery_ratio }}">
                            </div>


                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="shipment_pieces_number-1"
                                    class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> عدد القطع داخل الشحنة</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" min="1" id="shipment_pieces_number-1"
                                    name="shipment_pieces_number" class="form-control"
                                    value="{{ $order->shipment_pieces_number }}">
                            </div>



                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="trader_collection-1"
                                    class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> تحصيل التاجر</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" id="trader_collection-1" name="trader_collection" class="form-control"
                                    value="{{ $order->trader_collection }}">
                            </div>


                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="notes-1" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> ملاحظات</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" id="notes-1" name="notes" class="form-control"
                                    value="{{ $order->notes }}">
                            </div>



                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> المندوب</span>
                                </label>
                                <select id='delivery_id' name="delivery_id" style='width: 200px;'>
                                    <option selected value="{{ $order->delivery->id ?? null }}">
                                        {{ $order->delivery->name ?? '' }}</option>
                                </select>
                            </div>




                            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                <!--begin::Label-->
                                <label for="trader_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required mr-1"> التاجر</span>
                                </label>
                                <select id='trader_id' name="trader_id" style='width: 200px;'>
                                    <option selected value="{{ $order->trader->id ?? null }}">
                                        {{ $order->trader->name ?? '' }}</option>
                                </select>
                            </div>


                        </div>
                    </div>

                </div>



                <div class="my-4">
                    <button type="submit" id="submit" class="btn btn-success"> تعديل</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>





    <script>
        var loader_form = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>
        `;
    </script>
    <script>
        $(document).on('submit', "form#form", function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            var url = $('#form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {


                    $('#submit').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">{{ trans('admin.working') }}</span>'
                        ).attr('disabled', true);

                },

                complete: function() {},
                success: function(data) {

                    window.setTimeout(function() {

                        $('#submit').html('{{ trans('admin.submit') }}').attr('disabled',
                            false);

                        // $('#product-model').modal('hide')
                        if (data.code == 200) {
                            toastr.success(data.message)
                        } else {
                            toastr.error(data.message)
                            $('#submit').html('{{ trans('admin.submit') }}').attr('disabled',
                                false);

                        }
                    }, 1000);


                },
                error: function(data) {
                    $('#submit').html('{{ trans('admin.submit') }}').attr('disabled', false);

                    if (data.status === 500) {
                        toastr.error('there is an error')

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
        (function() {

            $("#province_id").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.getGovernorates') }}',
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

        function get_delivery_value(valu) {
            var trader_id = $('#trader_id').val();
            var province_id = $('#province_id').val();
            if (province_id && trader_id) {
                $.ajax({
                    url: '{{ route('admin.get_delivery_value') }}',
                    type: 'POST',
                    data: {
                        province_id: province_id,
                        trader_id: trader_id
                    },
                    beforeSend: function() {

                    },
                    complete: function() {},
                    success: function(data) {

                        $('#delivery_value' + valu).val(data);                       
                        get_order_value(valu);
                    },

                    error: function(data) {


                    }, //end error method


                });


            }

        }

        function get_order_value(valu) {
            var delivery_value = parseFloat($('#delivery_value').val());
            var total = parseFloat($('#shipment_value-1').val());
            if (delivery_value != '') {
                var shipment_value = total - delivery_value;
                // alert(shipment_value);
                $('.shipment_value' + valu).val(shipment_value);
            } else {
                $('.shipment_value' + valu).val('');
            }

        }
    </script>
@endsection
