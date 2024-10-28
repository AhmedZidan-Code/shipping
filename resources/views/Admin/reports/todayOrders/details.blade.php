@extends('Admin.layouts.inc.app')
@section('title')
    تقارير يومية الطلبات
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('todayOrdersReports.details') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4 ">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ البداية </span>

                </label>
                <input type="date" id="fromDate" value="{{ request('fromDate') }}" name="fromDate"
                    class="showBonds form-control">
            </div>
            <div class="col-md-4">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ النهاية </span>

                </label>
                <input type="date" id="toDate" value="{{ request('toDate') }}" name="toDate"
                    class="showBonds form-control">
            </div>
            <input type="hidden" value="{{ request('delivery_id') }}" name="delivery_id" id="delivery_id">
            {{-- <div class="col-md-4">
                <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> المندوب </span>
                </label>
                <select id="delivery_id" class="form-control showBonds" name="delivery_id">
                    <option value="">اختر</option>
                    @if (!empty($delivieries))
                        @foreach ($delivieries as $delivery)
                            <option value="{{ $delivery->id }}">{{ $delivery->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div> --}}
            <div class="col-md-2">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>

    </form>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تقارير يومية الطلبات</h5>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الحالة</th>
                        <th>المندوب</th>
                        <th>اسم العميل</th>
                        <th>المحافظة</th>
                        <th>عنوان العميل</th>
                        <th>رقم تليفون العميل</th>
                        <th>وقت التسليم</th>
                        <th>التاجر</th>
                        <th>عدد القطع داخل الشحنة</th>
                        <th>قيمة الشحنة</th>
                        <th>قيمة التوصيل</th>
                        <th>نسبة المندوب</th>
                        <th>الاجمالي</th>
                        <th> تفاصيل الطلب</th>
                    </tr>
                </thead>

            </table>
        </div>
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
                data: 'status',
                name: 'status'
            },
            {
                data: 'delivery_id',
                name: 'delivery_id'
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
                data: 'customer_address',
                name: 'customer_address'
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
                data: 'trader.name',
                name: 'trader.name'
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
                data: 'delivery_value',
                name: 'delivery_value'
            },
            {
                data: 'delivery_ratio',
                name: 'delivery_ratio'
            },
            {
                data: 'total_value',
                name: 'total_value'
            },
            {
                data: 'orderDetails',
                name: 'orderDetails'
            },
        ];
        var newUrl = "{{ route('todayOrdersReports.details') }}";
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();
        let delivery_id = "{{ request('delivery_id') }}";
        $(document).ready(function() {

            var test = $("#table").DataTable({
                processing: true,
                // pageLength: 50,
                paging: true,
                dom: 'Bfrltip',
                bLengthChange: true,
                serverSide: true,
                ajax: {
                    url: newUrl,
                    data: {
                        fromDate: fromDate,
                        toDate: toDate,
                        delivery_id: delivery_id
                    }
                },
                columns: columns,
                // order: [
                //     [0, "asc"]
                // ],
                "language": <?php echo json_encode(datatable_lang()); ?>,

                "drawCallback": function(settings) {
                    console.log(settings.json.rowsCount);
                    console.log(settings.json.total);
                    if (settings.json && settings.json.rowsCount) {
                        $('#rows-count').val(settings.json.rowsCount);
                        $('#total').val(settings.json.total);

                    }

                    if (settings.json && settings.json.total_sum) {
                        console.log(settings.json.total_sum);

                        $('#total_sum').html(settings.json.total_sum); // Update total sum
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
@endsection
