@extends('Admin.layouts.inc.app')
@section('title')
    الطلبات المحولة الي المناديب
@endsection
@section('css')
@endsection
@section('content')

    <form action="{{ route('deliveryConvertedOrders.index') }}">

        <div class="row mb-3">
            <div class="d-flex flex-column mb-7 fv-row col-sm-2">
                <!--begin::Label-->
                <label for="trader_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> التاجر</span>
                </label>
                <select id='trader_id' name="trader_id">
                    <option selected disabled>- ابحث عن التاجر</option>
                    @if (request('trader_id'))
                        <option value="{{ request('trader_id') }}" selected>
                            {{ App\Models\Trader::where('id', request('trader_id'))->first()->name }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> المندوب </span>
                </label>
                <select id="delivery_id" class="form-control showBonds" name="delivery_id">
                    <option value="">اختر</option>
                    @if (!empty($delivieries))
                        @foreach ($delivieries as $delivery)
                            <option value="{{ $delivery->id }}"
                                {{ request('delivery_id') == $delivery->id ? 'selected' : '' }}>{{ $delivery->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="d-flex flex-column mb-7 fv-row col-sm-2">
                <!--begin::Label-->
                <label for="province_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> المدينه</span>
                </label>
                <select id='province_id' class="province_id1" name="province_id" style='width: 200px;'>
                    <option selected disabled>- ابحث عن مدينة</option>
                    @if (request('province_id'))
                        <option value="{{ request('province_id') }}" selected>
                            {{ App\Models\Area::where('id', request('province_id'))->first()->title }}</option>
                    @endif
                </select>
            </div>

            <div class="col-md-2 ">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> من تاريخ </span>

                </label>
                <input type="date" id="fromDate" value="{{ request('fromDate') }}" name="fromDate"
                    class="showBonds form-control">

            </div>
            <div class="col-md-2">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> إلي تاريخ </span>

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
            <h5 class="card-title mb-0 flex-grow-1"> الطلبات المحولة الي المناديب</h5>



        </div>
        <div class="card-body">

            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"> </th>
                        <th>رقم الاوردر</th>
                        <th>اسم العميل</th>
                        <th>الحالة</th>
                        <th>المدينة</th>
                        <th> رقم التليفون</th>
                        <th> العنوان </th>
                        <th>التاجر</th>
                        <th>اجمالي الاوردر</th>
                        <th> المندوب</th>
                        <th>قيمة المندوب</th>
                        <th>الملاحظات</th>
                        <th>المتبقي</th>
                        <th> تاريخ التحويل</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="5">عدد الاوردرات</td>
                        <td colspan="3" id="rows-count"></td>
                        <td colspan="4">الاجمالي</td>
                        <td colspan="3" id="total"></td>
                    </tr>
                </tfoot>
            </table>

            <div class="row mb-3">

                <div class="col-md-4">
                    <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> المندوب المحول اليه </span>
                    </label>
                    <select id="" class="form-control showBonds delivery_id" name="">
                        <option value="">اختر</option>
                        @if (!empty($delivieries))
                            @foreach ($delivieries as $delivery)
                                <option value="{{ $delivery->id }}">{{ $delivery->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="button" onclick="convert();" class="btn btn-primary my-4"> تحويل</button>
                </div>
                <div class="col-md-2">
                    <button type="button" id="print_all" class="btn btn-primary my-4"> طباعة <i class="fa fa-print"
                            aria-hidden="true"></i></button>
                </div>
            </div>
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
                    <h2><span></span> تغير حالة الطلب </h2>
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

@endsection
@section('js')
    <script>
        var columns = [

            {
                data: 'convert_order',
                name: 'convert_order',
                orderable: false
            },
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'status',
                name: 'status'
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
                data: 'customer_address',
                name: 'customer_address'
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
                data: 'delivery_name',
                name: 'delivery_name'
            },
            {
                data: 'delivery_ratio',
                name: 'delivery_ratio'
            },
            {
                data: 'notes',
                name: 'notes'
            },
            {
                data: 'residual',
                name: 'residual'
            },
            {
                data: 'converted_date',
                name: 'converted_date'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'deliveryConvertedOrders'])

    <script>
        $(document).ready(function() {
            // Assume the main checkbox has an id of 'checkAll'
            $('#checkAll').on('click', function() {
                var isChecked = $(this).prop('checked');
                $('.orders_ids').prop('checked', isChecked);
                updateCheckAllState();
            });

            // Use event delegation for .orders_ids checkboxes
            $(document).on('click', '.orders_ids', function() {
                updateCheckAllState();
            });

            function updateCheckAllState() {
                var totalCheckboxes = $('.orders_ids').length;
                var checkedCheckboxes = $('.orders_ids:checked').length;

                var allChecked = (totalCheckboxes === checkedCheckboxes);
                $('#checkAll').prop('checked', allChecked);
            }
            if (checkedCheckboxes > 0) {

                // Initial state setup
                updateCheckAllState();
            }
        });

        $(document).on('click', '.changeStatusData', function() {

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
        $(document).on('change', '.changeStatus', function() {

            var id = $(this).attr('data-id');
            var status = $(this).val();

            if (status == 'not_delivery' || status == 'partial_delivery_to_customer') {
                $('#form-load').html(loader_form)

                $('#Modal').modal('show')

                var url = "{{ route('deliveryConvertedOrders.create') }}?id=" + id + "&&status=" + status;
                setTimeout(function() {
                    $('#form-load').load(url)
                }, 1000)
            } else {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.changeStatus') }}",
                    data: {
                        id: id,
                        status: status,
                    },

                    success: function(res) {

                        toastr.success('تمت العملية بنجاح');


                        $('#table').DataTable().ajax.reload(null, false);


                    },
                    error: function(data) {
                        // location.reload();
                    }
                });

            }
        })
    </script>
    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

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

    <script>
        function convert() {
            var orders_ids = [];
            var old_deliveries = [];
            $('.orders_ids:checked').each(function() {
                orders_ids.push($(this).val());
                old_deliveries.push($(this).attr('data-delivery'));
            });
            var delivery_id = $('.delivery_id').val();

            if (orders_ids.length === 0) {
                alert("من فضلك قم بادخال الاوردرات");
                return;
            }

            if (delivery_id === '') {
                alert("من فضلك قم باختيار المندوب");
                return;
            }
            $.ajax({
                url: '{{ route('admin.convert_order') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    delivery_id: delivery_id,
                    orders_ids: orders_ids,
                    old_deliveries: old_deliveries
                },
                beforeSend: function() {
                    // Optional: Add loading spinner or disable submit button
                },
                complete: function() {
                    // Optional: Remove loading spinner or enable submit button
                },
                success: function(data) {

                    if (data.code === 200) {
                        toastr.success(data.message);
                        setTimeout(reloading, 1000);
                    } else {
                        toastr.error(data.message);
                        $('#submit').html('{{ trans('admin.submit') }}').attr('disabled', false);
                    }
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
                    } else if (data.status === 421) {
                        toastr.error(data.message);
                    }
                },

            });
        }
    </script>
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
        $(document).ready(function() {
            $(document).on('click', '.print', function(e) {
                e.preventDefault();
                var order_id = [];
                order_id.push($(this).data('order'));

                $.ajax({
                    url: '{{ route('admin.print.order') }}',
                    method: 'GET',
                    data: {
                        order_id: order_id,
                    },
                    success: function(response) {
                        // Create a new window or iframe for printing
                        var printWindow = window.open('', '_blank');
                        printWindow.document.open();
                        printWindow.document.write(response.html);
                        printWindow.document.close();

                        // Wait for the content to load and then print
                        printWindow.onload = function() {
                            printWindow.print();
                            printWindow.close();
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching printable content:', error);
                    }
                });
            });
        });
        $(document).ready(function() {
            $(document).on('click', '#print_all', function(e) {
                e.preventDefault();
                if ($('.orders_ids:checked').length <= 0) {
                    alert('لابد من اختيار أوردرات للطباعة');
                    return;
                }
                var orders_id = [];
                $('.orders_ids:checked').each(function() {
                    orders_id.push($(this).val());
                });

                $.ajax({
                    url: '{{ route('admin.print.order') }}',
                    method: 'GET',
                    data: {
                        order_id: orders_id,
                    },
                    success: function(response) {
                        // Create a new window or iframe for printing
                        var printWindow = window.open('', '_blank');
                        printWindow.document.open();
                        printWindow.document.write(response.html);
                        printWindow.document.close();

                        // Wait for the content to load and then print
                        printWindow.onload = function() {
                            printWindow.print();
                            printWindow.close();
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching printable content:', error);
                    }
                });
            });
        });
    </script>
@endsection
