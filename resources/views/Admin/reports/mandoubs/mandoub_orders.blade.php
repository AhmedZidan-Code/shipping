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
                <input type="date" id="fromDate" ) value="{{ request('fromDate') }}" name="fromDate"
                    class="showBonds form-control">

            </div>
            <div class="col-md-4 " style="display: none;">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> اختر الشهر </span>

                </label>
                <input type="date" id="toDate" value="{{ request('toDate') }}" name="toDate"
                    class="showBonds form-control">
            </div>
            <div class="col-md-4">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> الشهر</span>

                </label>
                <select class="form-control" id="month" name="month">
                    <option value=""> اختر الشهر </option>
                    <option value="1" {{ request('month') == 1 ? 'selected' : '' }}> يناير </option>
                    <option value="2" {{ request('month') == 2 ? 'selected' : '' }}> فبراير </option>
                    <option value="3" {{ request('month') == 3 ? 'selected' : '' }}> مارس </option>
                    <option value="4" {{ request('month') == 4 ? 'selected' : '' }}> ابريل </option>
                    <option value="5" {{ request('month') == 5 ? 'selected' : '' }}> مايو </option>
                    <option value="6" {{ request('month') == 6 ? 'selected' : '' }}> يونيو </option>
                    <option value="7" {{ request('month') == 7 ? 'selected' : '' }}> يوليو </option>
                    <option value="8" {{ request('month') == 8 ? 'selected' : '' }}> اغسطس </option>
                    <option value="9" {{ request('month') == 9 ? 'selected' : '' }}> سبتمبر </option>
                    <option value="10" {{ request('month') == 10 ? 'selected' : '' }}> اكتوبر </option>
                    <option value="11" {{ request('month') == 11 ? 'selected' : '' }}> نوفمبر </option>
                    <option value="12" {{ request('month') == 12 ? 'selected' : '' }}> ديسمبر </option>
                </select>

            </div>

            <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                <!--begin::Label-->
                <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">المندوب</span>
                </label>
                <select id="delivery_id" name="delivery_id">
                    <option selected disabled>- ابحث عن المندوب</option>
                    @if (request('delivery_id'))
                        <option value="{{ request('delivery_id') }}" selected>
                            {{ App\Models\Delivery::where('id', request('delivery_id'))->first()->name }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>

    </form>
    <input type="hidden" name="delivery_id_data" value="{{ request('delivery_id') }}" id="delivery_id_data">
    <input type="hidden" name="month_data" value="{{ request('month') }}" id="month_data">
    <div class="card">

        <div class="card-body">
            <div style="overflow-x: auto;">
                <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
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
                    <tfoot style="background-color: rgb(223, 235, 242)">
                        <tr>
                            <td> عدد التنفيذات:
                                <input style="outline: none; border: none; box-shadow: none;" type="text"
                                    name="orders_count" id="orders_count" readonly>
                            </td>
                            <td colspan="2"> شحن المندوب:
                                <input style="outline: none; border: none; box-shadow: none;" type="text"
                                    name="mandoub_commission" id="mandoub_commission" readonly>
                            </td>
                            <td colspan="2"> مصاريف المندوب :
                                <input style="outline: none; border: none; box-shadow: none;" type="text" name="fees"
                                    id="fees" readonly>
                            </td>
                            <td colspan="2"> قيمه الشحن بعد المصاريف:
                                <input style="outline: none; border: none; box-shadow: none;" type="text"
                                    name="commission_after_fees" id="commission_after_fees" readonly>
                            </td>
                            <td colspan="2"> الراتب الاساسي :
                                <input style="outline: none; border: none; box-shadow: none;" type="text" name="salary"
                                    id="salary" readonly>
                            </td>
                            <td colspan="1"> المرتب الصافي :
                                <input style="outline: none; border: none; box-shadow: none;" type="text" name="total"
                                    id="total" readonly>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">عمولة الشركة :
                                <input style="outline: none; border: none; box-shadow: none;" type="text"
                                    name="company_commission" id="company_commission" readonly>
                            </td>
                            <td colspan="2"> المصاريف الادارية :
                                <input style="outline: none; border: none; box-shadow: none;" type="text"
                                    name="expenses" id="expenses" readonly>
                            </td>
                            <td colspan="2"> مصاريف البنزين :
                                <input style="outline: none; border: none; box-shadow: none;" type="text"
                                    name="solar" id="solar" readonly>
                            </td>
                            <td colspan="3">أربـــاح الشركة :
                                <input style="outline: none; border: none; box-shadow: none;" type="text"
                                    name="profit" id="profit" readonly>
                            </td>
                            <td colspan="2"><button class="btn btn-success" onclick="save(event)">حفظ</button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

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
    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>
    <script>
        var columns = [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'day_date',
                name: 'day_date'
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

                    $('#orders_count').val(settings.json.orders_count);
                    $('#solar').val(settings.json.solar);
                    $('#profit').val(settings.json.profit);
                    $('#expenses').val(settings.json.expenses);
                    $('#total').val(parseFloat(settings.json.salary) + parseFloat(settings.json
                        .commission_after_fees) - (parseFloat(settings.json.expenses)));
                    $('#company_commission').val(settings.json.company_commission);


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
    <script>
        function save(e) {
            e.preventDefault();
            var delivery_shipping = $('#mandoub_commission').val();
            var delivery_fees = $('#fees').val();
            var shipping_after_fees = $('#commission_after_fees').val();
            var base_salary = $('#salary').val();
            var total_salary = $('#total').val();
            var orders_count = $('#orders_count').val();
            var solar = $('#solar').val();
            var company_profit = $('#profit').val();
            var delivery_id = $('#delivery_id_data').val();
            var month = $('#month_data').val();
            var expenses = $('#expenses').val();

            var url = "{{ route('mandoub-salary.store') }}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    delivery_shipping: delivery_shipping,
                    delivery_fees: delivery_fees,
                    shipping_after_fees: shipping_after_fees,
                    base_salary: base_salary,
                    total_salary: total_salary,
                    orders_count: orders_count,
                    solar: solar,
                    expenses: expenses,
                    company_profit: company_profit,
                    delivery_id: delivery_id,
                    month: month,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {


                    $('#submit').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">جاري الحفظ</span>'
                    ).attr('disabled', true);

                },
                success: function(data) {

                    window.setTimeout(function() {
                        location.reload();
                    }, 1000);
                    toastr.success(data.message)
                    $('#submit').html('حفظ').attr('disabled',
                        false);

                },
                error: function(data) {
                    $('#submit').html('حفظ').attr('disabled', false);

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
            });
        }
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
    </script>
@endsection
