@extends('Trader.layouts.inc.app')
@section('title')
    طلبات التاجر
@endsection
@section('css')
@endsection
@section('content')


    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> عرض  طلبات التاجر</h5>


        </div>

        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>الحالة</th>
                        <th>اسم العميل</th>
                        <th>المحافظة</th>

                        <th>رقم تليفون العميل</th>
                        <th>وقت التسليم</th>
                        <th>عدد القطع داخل الشحنة</th>
                        <th>قيمة الشحنة</th>
                        <th>قيمة الاوردر</th>

                        <th> الملاحظات </th>
                        <th>قيمة التوصيل</th>


                        <th>تاريخ التحويل</th>
                        <th> تاريخ الانشاء</th>

                    </tr>
            </table>



        </div>
    </div>
@endsection
@section('js')
<script src="{{ URL::asset('assets_new/datatable/feather.min.js') }}"></script>
<script src="{{ URL::asset('assets_new/datatable/datatables.min.js') }}"></script>
    <script>
        var columns = [


            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'province.title',
                name: 'province.title'
            },

            {
                data: 'customer_phone',
                name: 'customer_phone'
            },
            {
                data: 'delivery_time',
                name: 'delivery_time'
            },
            {
                data: 'shipment_pieces_number',
                name: 'shipment_pieces_number'
            },
            {
                data: 'shipment_value',
                name: 'shipment_value'
            },
            {
                data: 'total_value',
                name: 'total_value'
            },
            {
                data: 'notes',
                name: 'notes'
            },
            {
                data: 'delivery_ratio',
                name: 'delivery_ratio'
            },

            {
                data: 'converted_date',
                name: 'converted_date'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
        ];
            $(function() {

        $("#table").DataTable({
            processing: true,
            // pageLength: 50,
            paging: true,
            dom: 'Bfrltip',
            bLengthChange: true,
            serverSide: true,
            ajax: '{{route('trader.trader-orders.index')}}',
            columns: columns,
            // order: [
            //     [0, "asc"]
            // ],
            "language": <?php echo json_encode(datatable_lang()); ?>,

            "drawCallback": function(settings) {

            if (settings.json && settings.json.total_sum) {
                console.log(settings.json.total_sum);
                
                    $('#total_sum').html(settings.json.total_sum);  // Update total sum
                }

                $('#ahmed').html(settings.json.total2);

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
    {{-- @include('Admin.layouts.inc.ajax', ['url' => 'trader-orders']) --}}

    <script>
        $(document).on('change', '.showBonds', function() {
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var trader_id = $('#trader_id').val();
            var status = $('#order_status').val();

            var url = "{{ route('tradersReports.index') }}";
            url = url + "?-=-";
            if (fromDate != null) {
                url = url + "&&fromDate=" + fromDate;
            }
            if (toDate != null) {
                url = url + "&&toDate=" + toDate;
            }
            if (trader_id != null) {
                url = url + "&&trader_id=" + trader_id;
            }
            if (status != null) {
                url = url + "&&status=" + status;
            }
            // window.location.href = url;
        })
    </script>




    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

@endsection
