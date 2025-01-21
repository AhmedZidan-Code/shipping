@extends('Trader.layouts.inc.app')
@section('title')
    الطلبات
@endsection
@section('css')
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> الطلبات</h5>

            {{-- <div>
                <a href="{{ route('orders.create') }}" class="btn btn-primary">اضافة طلب</a>
            </div> --}}

        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>اسم العميل</th>
                        <th>المدينة</th>
                        <th> رقم التليفون</th>
                        <th> العنوان </th>
                        <th>قيمه الاوردر</th>
                        <th>الملاحظات</th>
                        <th> تاريخ الانشاء</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
@section('js')
    <script>
        var columns = [
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
                data: 'customer_address',
                name: 'customer_address'
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
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'orders'])

    <script>
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
@endsection
