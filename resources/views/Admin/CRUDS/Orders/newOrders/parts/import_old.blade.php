@extends('Admin.layouts.inc.app')
@section('title')
    استيراد اكسيل
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
    استيراد اكسيل
@endsection



@section('content')
    <div class="card">
        <div class="card-header ">

            <form id="form-excel" enctype="multipart/form-data" method="POST" action="{{ route('orders.import') }}">
                @csrf
                <div id="container-data">
                    <div id="tr-1" class="card mt-2 my-div">

                        <div class="card-body">
                            <div class="row  g-4">

                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="trader_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1"> التاجر</span>
                                    </label>
                                    <select id='trader_excel' name="trader_id" onchange="get_delivery_value(1)"
                                        class="formv1 trader_id1" style='width: 200px;'>

                                    </select>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1"> المندوب</span>
                                    </label>
                                    <select id='delivery_excel' name="delivery_id" style='width: 200px;'>
                                        <option selected value="0">- ابحث عن مندوب</option>
                                    </select>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="file" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1"> رفع الملف</span>
                                    </label>
                                    <input id='file' type="file" name="file" style='width: 200px;'>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <a href="{{ route('orders.export') }}"
                                        style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-align: center; text-decoration: none; border-radius: 5px; border: 1px solid transparent; transition: background-color 0.3s, border-color 0.3s;">
                                        تحميل نسخة الطلبات
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>

                <div class="my-4">
                    <button type="submit" id="submit-excel" class="btn btn-success"> حفظ</button>
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
        $(document).on('submit', "form#form-excel", function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            var url = $('#form-excel').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {


                    $('#submit-excel').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">{{ trans('admin.working') }}</span>'
                    ).attr('disabled', true);

                },

                complete: function() {},
                success: function(data) {

                 
                    window.setTimeout(function() {

                        // $('#product-model').modal('hide')
                        if (data.code == 200) {
                            toastr.success(data.message)
                            setTimeout(reloading, 1000);
                        } else {
                            toastr.error(data.message)
                            $('#submit-excel').html('{{ trans('admin.submit') }}').attr(
                                'disabled',
                                false);

                        }
                    }, 1000);
                    $('#submit-excel').html('{{ trans('admin.submit') }}').attr(
                        'disabled',
                        false);

                },
                error: function(data) {

                    $('#submit-excel').html('{{ trans('admin.submit') }}').attr('disabled', false);

                    if (data.status === 500) {
                        toastr.error('there is an error')

                    }

                    if (data.status === 422) {
                        var errors = data.responseJSON.errors;

                        console.log(errors);

                        $.each(errors, function(key, value) {
                            $.each(value, function(key, value) {
                                toastr.error(value)
                            });
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
        $(document).on('click', '.deleteRow', function() {
            var id = $(this).attr('data-id');
            $(`#tr-${id}`).remove();
        })
    </script>

    <script>
        function ChangeBorder(obj) {

            if (obj.val() == "") {
                // $('.'+obj.attr('id')).remove();
                // obj.after('<div id="" class="'+obj.attr('id')+'" style="color:red;">  هذا الحقل مطلوب</div>');


                obj.css('border-color', 'red');

                return 'done';
            } else {
                // $('.'+obj.attr('id')).hide();
                return 0
            }

        }
    </script>




    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

    <script>
        (function() {

            $("#delivery_excel").select2({
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
        (function() {

            $("#trader_excel").select2({
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
    </script>
@endsection
