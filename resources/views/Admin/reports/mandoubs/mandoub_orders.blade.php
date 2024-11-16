@extends('Admin.layouts.inc.app')

@section('title')
    الطلبات
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('admin.mandoub_orders') }}">

        <div class="row mb-3">
            <div class="col-md-4 " style="display: none;">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ البداية </span>

                </label>
                <input type="date" id="fromDate"
                    @isset($request['fromDate']) value="{{ $request['fromDate'] }}"
                       @endisset
                    name="fromDate" class="showBonds form-control">

            </div>
            <div class="col-md-4 " style="display: none;">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ النهاية </span>

                </label>
                <input type="date" id="toDate"
                    @isset($request['toDate']) value="{{ $request['toDate'] }}"
                       @endisset
                    name="toDate" class="showBonds form-control">
            </div>
            <div class="col-md-4">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ النهاية </span>

                </label>
                <select class="form-control" id="month" name="month">
                    <option value=""> اختر الشهر </option>
                    <option value="1" <?php if (date('m') == 1) {
                        echo 'selected';
                    } ?>> يناير </option>
                    <option value="2" <?php if (date('m') == 2) {
                        echo 'selected';
                    } ?>> فبراير </option>
                    <option value="3" <?php if (date('m') == 3) {
                        echo 'selected';
                    } ?>> مارس </option>
                    <option value="4" <?php if (date('m') == 4) {
                        echo 'selected';
                    } ?>> ابريل </option>
                    <option value="5" <?php if (date('m') == 5) {
                        echo 'selected';
                    } ?>> مايو </option>
                    <option value="6" <?php if (date('m') == 6) {
                        echo 'selected';
                    } ?>> يونيو </option>
                    <option value="7" <?php if (date('m') == 7) {
                        echo 'selected';
                    } ?>> يوليو </option>
                    <option value="8" <?php if (date('m') == 8) {
                        echo 'selected';
                    } ?>> اغسطس </option>
                    <option value="9" <?php if (date('m') == 9) {
                        echo 'selected';
                    } ?>> سبتمبر </option>
                    <option value="10" <?php if (date('m') == 10) {
                        echo 'selected';
                    } ?>> اكتوبر </option>
                    <option value="11" <?php if (date('m') == 11) {
                        echo 'selected';
                    } ?>> نوفمبر </option>
                    <option value="12" <?php if (date('m') == 12) {
                        echo 'selected';
                    } ?>> ديسمبر </option>
                </select>

            </div>

            <div class="col-md-4">
                <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> المندوب </span>

                </label>

                <select id="delivery_id" class="form-control showBonds" name="delivery_id">
                    <option selected disabled>اختر</option>
                    @foreach ($deliveries as $row)
                        <option value="{{ $row->id }}"> {{ $row->name }}</option>
                    @endforeach
                </select>


            </div>
            <div class="col-md-2">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>

    </form>
    <div class="card">

        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>التاريخ </th>
                        <th>المندوب</th>
                        <th>عدد التنفيذات</th>
                        <th> اجمالي قيمه الشحن </th>
                        <th> اجمالي الاوردرات </th>
                        <th> المصروف</th>
                        <th> بدل البنزين</th>
                        <th> عموله المندوب</th>
                        <th> عموله الشركه</th>
                        <th> التفاصيل</th>

                    </tr>
                </thead>
                <tfoot style="background-color: darkgray;">
                    <tr>
                        <td> </td>
                        <td colspan="2"> شحن المندوب:
                            <input style="  outline: none; border: none; box-shadow: none;" type="text"
                                name="mandoub_commission" id="mandoub_commission" readonly>
                        </td>
                        <td colspan="2"> مصاريف المندوب :
                            <input style="  outline: none; border: none; box-shadow: none;" type="text" name="fees"
                                id="fees" readonly>
                        </td>
                        <td colspan="2"> قيمه الشحن بعد المصاريف:
                            <input style="  outline: none; border: none; box-shadow: none;" type="text"
                                name="commission_after_fees" id="commission_after_fees" readonly>
                        </td>
                        <td colspan="2"> الراتب الاساسي :
                            <input style="  outline: none; border: none; box-shadow: none;" type="text" name="salary"
                                id="salary" readonly>
                        </td>
                        <td colspan="2"> المرتب :
                            <input style="  outline: none; border: none; box-shadow: none;" type="text" name="total"
                                id="total" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2">اجمالي تنفيذات المندوب :
                            <input style="  outline: none; border: none; box-shadow: none;" type="text"
                                name="orders_count" id="orders_count" readonly>
                        </td>
                        <td colspan="2"> مصاريف البنزين :
                            <input style="  outline: none; border: none; box-shadow: none;" type="text" name="solar"
                                id="solar" readonly>
                        </td>
                        <td colspan="4">أربـــاح الشركة :
                            <input style="  outline: none; border: none; box-shadow: none;" type="text" name="profit"
                                id="profit" readonly>
                        </td>
                        <td colspan="2"><button class="btn btn-success" id="save">حفظ</button></td>
                    </tr>

                </tfoot>

            </table>
        </div>
    </div>

    <div class="modal fade" id="Modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-fullscreen mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2><span id="operationType"></span> طلب </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <button class="btn btn-sm btn-icon btn-active-color-primary" type="button" data-bs-dismiss="modal"
                        aria-label="Close">
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
                        <button form="form" type="submit" id="submit" class="btn btn-primary">
                            <span class="indicator-label">اتمام</span>
                        </button>
                    </div>
                </div>
            </div>

            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>


    <div class="modal fade" id="Modal-delivery" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent-delivery">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2> التسليم الي المندوب </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <button class="btn btn-sm btn-icon btn-active-color-primary" type="button" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                    <!--end::Close-->
                </div>
                <!--begin::Modal body-->
                <div class="modal-body py-4" id="form-load-delivery">

                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light me-2">
                            الغاء
                        </button>
                        <button form="form-delivery" type="submit" id="submit-delivery" class="btn btn-primary">
                            <span class="indicator-label">اتمام</span>
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
                data: 'id',
                name: 'id'
            },
            {
                data: 'date_time',
                name: 'date_time'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'num_mandoub_orders',
                name: 'num_mandoub_orders'
            },
            {
                data: 'total_shipping',
                name: 'total_shipping'
            },
            {
                data: 'total_orders',
                name: 'total_orders'
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
                data: 'commission_after_fees',
                name: 'commission_after_fees'
            },
            {
                data: 'company_commission',
                name: 'company_commission'
            },
            {
                data: 'orderDetails',
                name: 'orderDetails',
                orderable: false,
                searchable: false
            },
        ];
    </script>
    <script>
        //  var newUrl = '{{ route('admin.mandoub_orders') }}';
        var newUrl = location.href;
        $(function() {
            $("#table").DataTable({
                processing: true,
                // pageLength: 50,
                paging: true,
                dom: 'Bfrltip',

                bLengthChange: true,
                serverSide: true,
                ajax: newUrl,
                columns: columns,
                "order": [],
                "language": <?php echo json_encode(datatable_lang()); ?>,

                "drawCallback": function(settings) {


                    $('#mandoub_commission').val(settings.json.mandoub_commission);
                    $('#fees').val(settings.json.fees);
                    $('#commission_after_fees').val(settings.json.commission_after_fees);
                    $('#salary').val(settings.json.salary);
                    $('#total').val(parseFloat(settings.json.salary) + parseFloat(settings.json
                        .commission_after_fees));
                    $('#orders_count').val(settings.json.orders_count);
                    $('#solar').val(settings.json.solar);
                    $('#profit').val(settings.json.profit);


                    // parseFloat()
                    // console.log(settings.json.total2); 

                    //$('#ahmed').html(settings.json.total2);

                    //do whatever  
                },

                // "language": {
                //     paginate: {
                //         previous: "<i class='simple-icon-arrow-left'></i>",
                //         next: "<i class='simple-icon-arrow-right'></i>"
                //     },
                //     "sProcessing": "جاري التحميل ..",
                //     "sLengthMenu": "اظهار _MENU_ سجل",
                //     "sZeroRecords": "لا يوجد نتائج",
                //     "sInfo": "اظهار _START_ الى  _END_ من _TOTAL_ سجل",
                //     "sInfoEmpty": "لا نتائج",
                //     "sInfoFiltered": "للبحث",
                //     "sSearch": "بحث :    ",
                //     "oPaginate": {
                //         "sPrevious": "السابق",
                //         "sNext": "التالي",
                //     }
                // },
                // buttons: [
                //     'colvis',
                //     'excel',
                //     'print',
                //     'copy',
                //     'csv',
                //     // 'pdf'
                // ],

                searching: true,
                destroy: true,
                info: false,


            });

        });
    </script>
@endsection
<script>
    $(document).on('submit', "form#form", function(e) {
        e.preventDefault();

        let mandoub_commission = $('#mandoub_commission').val();
        let mandoub_commission = $('#mandoub_commission').val();
        let fees = $('#fees').val();
        let commission_after_fees = $('#commission_after_fees').val();
        let salary = $('#salary').val();
        let total = $('#total').val();
        let orders_count = $('#orders_count').val();
        let solar = $('#solar').val();
        let profit = $('#profit').val();
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
