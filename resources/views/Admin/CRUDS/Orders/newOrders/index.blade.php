@extends('Admin.layouts.inc.app')
@section('title')
    الطلبات
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('orders.index') }}">

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
            <div class="d-flex flex-column mb-7 fv-row col-sm-2">
                <!--begin::Label-->
                <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1">المندوب</span>
                </label>
                <select id="delivery_data" name="delivery_id">
                    <option selected disabled>- ابحث عن المندوب</option>
                    @if (request('delivery_id'))
                        <option value="{{ request('delivery_id') }}" selected>
                            {{ App\Models\Delivery::where('id', request('delivery_id'))->first()->name }}</option>
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
            <h5 class="card-title mb-0 flex-grow-1"> الطلبات</h5>

            <div>
                <a href="{{ route('orders.create') }}" class="btn btn-primary">اضافة طلب</a>
            </div>

        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"> </th>
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>المندوب</th>
                        <th>المدينة</th>
                        <th> رقم التليفون</th>
                        <th> العنوان </th>
                        <th>التاجر</th>
                        <th>قيمه الاوردر</th>
                        <th>الملاحظات</th>
                        <th> تاريخ الانشاء</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="3" style="background-color: rgb(223, 235, 242)">عدد الاوردرات</td>
                        <td colspan="3" id="rows-count" style="background-color: rgb(223, 235, 242)"></td>
                        <td colspan="3" style="background-color: rgb(197, 222, 237)">الاجمالي</td>
                        <td colspan="3" id="total" style="background-color: rgb(197, 222, 237)"></td>
                    </tr>
                </tfoot>
            </table>
            <div class="row mb-3">

                <div class="col-md-4">
                    <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> التسليم الي المندوب</span>
                    </label>
                    <select id="delivery_id" class="form-control showBonds delivery_id select2" name="">
                        <option value="">اختر</option>
                        @if (!empty($delivieries))
                            @foreach ($delivieries as $delivery)
                                <option value="{{ $delivery->id }}">{{ $delivery->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-primary my-4 delivered"> تسليم</button>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ URL::asset('assets_new/js/sweet_alert.js') }}"></script>

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
            })
        })();

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
        var columns = [{
                data: 'checkbox',
                name: 'checkbox',
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
                data: 'delivery_id',
                name: 'delivery_id'
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
                data: 'shipment_value',
                name: 'shipment_value'
            },
            {
                data: 'notes',
                name: 'notes'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
        $(function() {
            let delivery_id = '{{ request('delivery_id') }}';
            let trader_id = '{{ request('trader_id') }}';
            let fromDate = '{{ request('fromDate') }}';
            let toDate = '{{ request('toDate') }}';
            let URL = '{{ route('orders.index') }}';

            $("#table").DataTable({
                processing: true,
                // pageLength: 50,
                paging: true,
                dom: 'Bfrltip',
                bLengthChange: true,
                serverSide: true,
                ajax: {
                    url: URL,
                    data: {
                        delivery_id: delivery_id,
                        trader_id: trader_id,
                        fromDate: fromDate,
                        toDate: toDate,
                    }
                },
                columns: columns,
                // order: [
                //     [0, "asc"]
                // ],
                "language": <?php echo json_encode(datatable_lang()); ?>,
                "drawCallback": function(settings) {

                    if (settings.json && settings.json.rowsCount) {
                        $('#rows-count').html(settings.json.rowsCount);
                        $('#total').html(settings.json.total);

                    }
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
        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            swal.fire({
                title: "{{ trans('admin.submit delete') }}",
                text: "{{ trans('admin.delete text') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "{{ trans('admin.submit') }}",
                cancelButtonText: "{{ trans('admin.cancel') }}",
                okButtonText: "{{ trans('admin.submit') }}",
                closeOnConfirm: false
            }).then((result) => {
                if (!result.isConfirmed) {
                    return true;
                }


                var url = '{{ route('orders.destroy', ':id') }}';
                url = url.replace(':id', id)
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    beforeSend: function() {
                        $('.loader-ajax').show()

                    },
                    success: function(data) {

                        window.setTimeout(function() {
                            $('.loader-ajax').hide()
                            if (data.code == 200) {
                                toastr.success(data.message)
                                $('#table').DataTable().ajax.reload(null, false);
                            } else {
                                toastr.error('{{ trans('admin.error') }}')
                            }

                        }, 1000);
                    },
                    error: function(data) {
                        $('.loader-ajax').hide()
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
                        if (data.status === 403) {
                            toastr.error('You are not authorized to perform this action.',
                                'Unauthorized');
                        }
                    }

                });
            });
        });

        $(document).on('click', '#addDetails', function(e) {

            e.preventDefault();

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.getOrderDetails') }}",

                success: function(res) {

                    $('#details-container').append(res.html);

                },
                error: function(data) {
                    // location.reload();
                }
            });



        })


        $(document).on('click', '.deleteRow', function() {
            var id = $(this).attr('data-id');

            $(`#${id}`).remove();


        })
    </script>

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
        $(document).on('change', '.changeDelivery', function() {
            var id = $(this).attr('data-id');
            var delivery_id = $(this).val();

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.changeDelivery') }}",
                data: {
                    id: id,
                    delivery_id: delivery_id,
                },

                success: function(res) {

                    toastr.success('تمت العملية بنجاح');


                    $('#table').DataTable().ajax.reload(null, false);


                },
                error: function(data) {
                    // location.reload();
                }
            });

        })
    </script>

    <script>
        $(document).on('click', '.insertDelivery', function() {
            var id = $(this).attr('data-id');

            var route = "{{ route('admin.getDeliveryForOrder', ':id') }}";

            route = route.replace(':id', id);

            $('#form-load-delivery').html(loader_form)

            $('#Modal-delivery').modal('show')

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
        $(document).on('click', ".delivered", function(e) {
            e.preventDefault();
            var orders_ids = [];
            $('.orders_ids:checked').each(function() {
                orders_ids.push($(this).val());
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

            let url = "{{ route('admin.insertBulkOrdersForDelivery') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    delivery_id: delivery_id,
                    orders_ids: orders_ids,
                }),
                contentType: 'application/json',
                beforeSend: function() {
                    $('.delivered').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span><span style="margin-left: 4px;">{{ trans('admin.working') }}</span>'
                        )
                        .attr('disabled', true);
                    $('.delivered').append(loader_form);
                    $('.delivered > form').hide();
                },
                success: function(data) {
                    window.setTimeout(function() {
                        $('.delivered').html('تسليم')
                            .attr('disabled', false);

                        if (data.code == 200) {
                            toastr.success(data.message);
                            $('#Modal-delivery').modal('hide');
                            $('.delivered > form').remove();
                            $('#table').DataTable().ajax.reload(null, false);
                        } else {
                            $('.delivered > .linear-background').hide();
                            $('.delivered > form').show();
                            toastr.error(data.message);
                        }
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    $('.delivered').html('تسليم')
                        .attr('disabled', false);


                    if (xhr.status === 500) {
                        toastr.error('{{ trans('admin.error') }}');
                    } else if (xhr.status === 422) {
                        var errors = JSON.parse(xhr.responseText);
                        $.each(errors.errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else if (xhr.status == 421) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('An unexpected error occurred');
                    }
                }
            });
        });
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
