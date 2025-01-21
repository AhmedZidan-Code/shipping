@extends('Admin.layouts.inc.app')
@section('title')
    اضافة طلب
@endsection
@section('css')

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"/>
    <style>

        .my-div {
            position: relative;
        }

        .my-div i {
            position: absolute;
            top: 10px; /* adjust as needed */
            right: 10px; /* adjust as needed */
        }
    </style>
@endsection

@section('page-title')
    اضافة طلب
@endsection



@section('content')

    <div class="card">
        <div class="card-header ">



            <form id="form" enctype="multipart/form-data" method="POST" action="{{route('admin.storeOrderToTrader',$trader->id)}}">
                @csrf
                <div id="container-data">
                    <div id="tr-1" class="card mt-2 my-div">
                        <i data-id="1" style="color: red" class="fas fa-trash deleteRow"></i> <!-- Font Awesome user icon -->

                        <div class="card-body">
                            <div class="row  g-4">




                                                        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                                            <!--begin::Label-->
                                                            <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                                <span class="required mr-1">   المندوب</span>
                                                            </label>
                                                            <select id='delivery_id' name="delivery_id[]" style='width: 200px;'>
                                                                <option selected value="0"> ابحث عن مندوب</option>
                                                            </select>
                                                        </div>



                                {{--                            <div class="d-flex flex-column mb-7 fv-row col-sm-2">--}}
                                {{--                                <!--begin::Label-->--}}
                                {{--                                <label for="province_id-1" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">--}}
                                {{--                                    <span class="required mr-1">المحافظة</span>--}}
                                {{--                                </label>--}}
                                {{--                                <!--end::Label-->--}}
                                {{--                                <select class="form-control" name="province_id[]" id="province_id-1">--}}
                                {{--                                    <option selected > </option>--}}
                                {{--                                    @foreach($provinces as $province)--}}
                                {{--                                        <option value="{{$province->id}}">{{$province->title}}</option>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </select>--}}
                                {{--                            </div>--}}




                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="province_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">   المدن</span>
                                    </label>
                                    <select id='province_id' name="province_id[]" style='width: 200px;'>
                                        <option selected disabled>- ابحث عن مدينة</option>
                                    </select>
                                </div>






                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="customer_phone-1"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">هاتف العميل</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" id="customer_phone-1" name="customer_phone[]" class="form-control"
                                           value="">
                                </div>




                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="customer_name-1"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">اسم العميل</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" id="customer_name-1" name="customer_name[]" class="form-control"
                                           value="">
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="shipment_pieces_number-1"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1"> عدد القطع داخل الشحنة</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="number" min="1" id="shipment_pieces_number-1" name="shipment_pieces_number[]"
                                           class="form-control" value="">
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="shipment_value-1"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">    قيمة الاوردر</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="number" min="0" id="shipment_value-1" name="shipment_value[]"
                                           class="form-control" value="">
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="delivery_value-1"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">    قيمة التوصيل</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="number" min="0" id="delivery_value-1" name="delivery_value[]"
                                           class="form-control" value="">
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="delivery_ratio"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">     قيمة المندوب</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="number" min="0" max="100" id="delivery_ratio-1" name="delivery_ratio[]"
                                           class="form-control" value="">
                                </div>




                                <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                                    <!--begin::Label-->
                                    <label for="customer_address-1"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1"> عنوان العميل</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" id="customer_address-1" name="customer_address[]" class="form-control"
                                           value="">
                                </div>



                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="trader_collection-1"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">  تحصيل التاجر</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="number" id="trader_collection-1" name="trader_collection[]" class="form-control"
                                           value="">
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="notes-1"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">   ملاحظات</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" id="notes-1" name="notes[]" class="form-control"
                                           value="--">
                                </div>





                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end">

                    <button id="addNewOrderBtn" class="btn btn-primary">اضافة طلب اخر للتاجر
                        -
                        {{$trader->name}}
                    </button>
                </div>



                <div class="my-4">
                    <button type="submit" id="submit" class="btn btn-success"> حفظ</button>
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
        $(document).on('submit', "form#form", function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            var url = $('#form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function () {


                    $('#submit').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">{{trans('admin.working')}}</span>').attr('disabled', true);

                },

                complete: function () {
                },
                success: function (data) {

                    window.setTimeout(function () {

// $('#product-model').modal('hide')
                        if (data.code == 200) {
                            toastr.success(data.message)
                            setTimeout(reloading, 1000);
                        } else {
                            toastr.error(data.message)
                            $('#submit').html('{{trans('admin.submit')}}').attr('disabled', false);

                        }
                    }, 1000);


                },
                error: function (data) {
                    $('#submit').html('{{trans('admin.submit')}}').attr('disabled', false);

                    if (data.status === 500) {
                        toastr.error('there is an error')

                    }

                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);


                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value)
                                });

                            } else {

                            }
                        });
                    }
                    if (data.status == 421) {
                        toastr.error(data.message)

                    }

                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>

    <script>
        $(document).on('click','.deleteRow',function (){
            var id=$(this).attr('data-id');
            $(`#tr-${id}`).remove();
        })
    </script>
    <script>
        $(document).on('click','#addNewOrderBtn',function (e){
            e.preventDefault();
            let x = Math.floor((Math.random() * 9999999999999999) + 1);

            var order=`
                            <div id="tr-${x}" class="card mt-2 my-div">
                    <i data-id="${x}" style="color: red" class="fas fa-trash deleteRow"></i> <!-- Font Awesome user icon -->

                    <div class="card-body">
                        <div class="row  g-4">

                             <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                           <!--begin::Label-->
                                           <label for="delivery_id-${x}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                               <span class="required mr-1">   المندوب</span>
                                           </label>
                                           <select id='delivery_id-${x}' name="delivery_id[]" style='width: 200px;'>
                                               <option selected value="0">- ابحث عن مندوب</option>
                                           </select>
                                       </div>







            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                <!--begin::Label-->
                <label for="province_id-${x}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">   المدن</span>
                </label>
                <select id='province_id-${x}' name="province_id[]" style='width: 200px;'>
                    <option selected disabled>- ابحث عن مدينة</option>
                </select>
            </div>





<div class="d-flex flex-column mb-7 fv-row col-sm-3">
<!--begin::Label-->
<label for="customer_phone-${x}"
                   class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">هاتف العميل</span>
            </label>
            <!--end::Label-->
            <input type="text" id="customer_phone-${x}" name="customer_phone[]" class="form-control"
                   value="">
        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="customer_name-${x}"
                   class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">اسم العميل</span>
            </label>
            <!--end::Label-->
            <input type="text" id="customer_name-${x}" name="customer_name[]" class="form-control"
                   value="">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="shipment_pieces_number-${x}"
                   class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> عدد القطع داخل الشحنة</span>
            </label>
            <!--end::Label-->
            <input type="number" min="1" id="shipment_pieces_number-${x}" name="shipment_pieces_number[]"
                   class="form-control" value="">
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="shipment_value-${x}"
                   class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">    قيمة الاوردر</span>
            </label>
            <!--end::Label-->
            <input type="number" min="0" id="shipment_value-${x}" name="shipment_value[]"
                   class="form-control" value="">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="delivery_value-${x}"
                   class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">    قيمة التوصيل</span>
            </label>
            <!--end::Label-->
            <input type="number" min="0" id="delivery_value-${x}" name="delivery_value[]"
                   class="form-control" value="">
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-3">
            <!--begin::Label-->
            <label for="delivery_ratio-${x}"
                   class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">     قيمة المندوب</span>
            </label>
            <!--end::Label-->
            <input type="number" min="0" max="100" id="delivery_ratio-${x}" name="delivery_ratio[]"
                   class="form-control" value="">
        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="customer_address-${x}"
                   class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> عنوان العميل</span>
            </label>
            <!--end::Label-->
            <input type="text" id="customer_address-${x}" name="customer_address[]" class="form-control"
                   value="">
        </div>





                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="trader_collection-${x}"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">  تحصيل التاجر</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="number" id="trader_collection-${x}" name="trader_collection[]" class="form-control"
                                           value="">
                                </div>


                                <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                                    <!--begin::Label-->
                                    <label for="notes-${x}"
                                           class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span class="required mr-1">   ملاحظات</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" id="notes-${x}" name="notes[]" class="form-control"
                                           value="--">
                                </div>




    </div>
</div>
</div>

`;

            $(document).find('#container-data').append(order);
            $("html, body").animate({ scrollTop: $(document).height() }, 1000);

            loadScript(x);
        })
    </script>

    <script>
        function reloading(){
            var route="{{route('orders.index')}}";
            window.location.href=route;
        }
    </script>

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>
    <script>

        (function () {

            $("#trader_id").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{route('admin.getTraders')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
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

        (function () {

            $("#delivery_id").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{route('admin.getDeliveries')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
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

        (function () {

            $("#province_id").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{route('admin.getGovernorates')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
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
        function loadScript(id) {
            $(`#province_id-${id}`).select2({
                placeholder: 'searching For Supplier...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{route('admin.getGovernorates')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });



            $(`#delivery_id-${id}`).select2({
                placeholder: 'searching For Supplier...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{route('admin.getDeliveries')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });

        }
    </script>


@endsection
