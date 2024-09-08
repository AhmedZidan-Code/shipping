@extends('Delivery.layouts.inc.app')
@section('title')
    طلباتي
@endsection
@section('css')
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">  طلباتي</h5>



        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                   style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>المندوب</th>
                    <th>الحالة</th>
                    <th>اسم العميل</th>
                    <th>المحافظة</th>
                    <th>عنوان العميل</th>
                    <th>رقم تليفون العميل</th>
                    <th>وقت التسليم</th>
                    <th>عدد القطع داخل الشحنة</th>
                    <th>قيمة الشحنة</th>
                    <th>قيمة التوصيل</th>
                    <th>نسبة المندوب</th>
                    <th>الاجمالي</th>
                    <th> تاريخ الانشاء</th>
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
                    <h2><span ></span> تغير حالة الطلب  </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <button class="btn btn-sm btn-icon btn-active-color-primary" type="button" data-bs-dismiss="modal" aria-label="Close">
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
            {data: 'id', name: 'id'},
            {data: 'delivery_id', name: 'delivery_id'},
            {data: 'status', name: 'status'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'province.title', name: 'province.title'},
            {data: 'customer_address', name: 'customer_address'},
            {data: 'customer_phone', name: 'customer_phone'},
            {data: 'delivery_time', name: 'delivery_time'},
            {data: 'shipment_pieces_number', name: 'shipment_pieces_number'},
            {data: 'shipment_value', name: 'shipment_value'},
            {data: 'delivery_value', name: 'delivery_value'},
            {data: 'delivery_ratio', name: 'delivery_ratio'},
            {data: 'total_value', name: 'total_value'},
            {data: 'created_at', name: 'created_at'},];
    </script>
    @include('Delivery.layouts.inc.ajax',['url'=>'myCurrentOrders'])

    <script>
        $(document).on('change','.changeStatus',function (){
            var id=$(this).attr('data-id');
            var status=$(this).val();


            $.ajax({
                type: 'GET',
                url: "{{route('delivery.changeMyOrderStatus')}}",
                data: {
                    id: id,
                    status: status,
                },

                success: function (res) {

                    toastr.success('تمت العملية بنجاح');


                    $('#table').DataTable().ajax.reload(null, false);


                },
                error: function (data) {
                    // location.reload();
                }
            });

        })
    </script>


    <script>
        $(document).on('click','.changeStatusData',function (){

            var id=$(this).attr('data-id');
            
            $('#form-load').html(loader_form)

            $('#Modal').modal('show')

            var url="{{route('delivery.deliveryChangeOrderStatus',':id')}}";
            url=url.replace(':id',id);
            setTimeout(function (){
                $('#form-load').load(url)
            },1000)


        })
    </script>


@endsection
