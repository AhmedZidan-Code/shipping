@extends('Admin.layouts.inc.app')

@section('title')
     الطلبات
@endsection
@section('css')
@endsection
@section('content')
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
                    <th> التفاصيل</th>
                   
                </tr>
                </thead>
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
                    <button class="btn btn-sm btn-icon btn-active-color-primary" type="button" data-bs-dismiss="modal" aria-label="Close">
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
<script src="{{URL::asset('assets_new/datatable/feather.min.js')}}"></script>
<script src="{{URL::asset('assets_new/datatable/datatables.min.js')}}"></script>
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'date_time', name: 'date_time'},
            {data: 'name', name: 'name'},
            {data: 'num_mandoub_orders', name: 'num_mandoub_orders'},
            {data: 'total_shipping', name: 'total_shipping'},
            {data: 'total_orders', name: 'total_orders'},
           
            {data: 'orderDetails', name: 'orderDetails', orderable: false, searchable: false},
        ];
    </script>
    <script>
       var newUrl = '{{ route("admin.mandoub_orders") }}';
        $(function () {
        $("#table").DataTable({
            processing: true,
            // pageLength: 50,
            paging: true,
            dom: 'Bfrltip',

            bLengthChange: true,
            serverSide: true,
            ajax: newUrl,
            columns: columns,
            // order: [
            //     [0, "asc"]
            // ],
            "language":<?php echo json_encode(datatable_lang());?>,
            
            "drawCallback": function(settings) {
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
