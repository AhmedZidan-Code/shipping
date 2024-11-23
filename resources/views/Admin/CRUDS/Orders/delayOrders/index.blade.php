@extends('Admin.layouts.inc.app')
@section('title')
    الطلبات المسلمة كليا
@endsection
@section('css')
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> الطلبات المسلمة كليا</h5>



        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>الحالة</th>
                        <th>المدينة</th>
                        <th> رقم التليفون</th>
                        <th> عنوان العميل </th>

                        <th>التاجر</th>
                        <th>قيمه الاوردر </th>
                        <th>الملاحظات</th>
                        <th> تاريخ التحويل</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
            </table>
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
        var columns = [{
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
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'delayedOrders'])

    <script>
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
@endsection
