@extends('Admin.layouts.inc.app')

@section('title')
    الطلبات
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('treasury.index') }}">
        <div class="row mb-3">
            <div class="col-md-4 ">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> من تاريخ </span>

                </label>
                <input type="date" id="fromDate" value="{{ request('fromDate') }}" name="fromDate"
                    class="showBonds form-control">

            </div>
            <div class="col-md-4">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> إلي تاريخ </span>

                </label>
                <input type="date" id="toDate" value="{{ request('toDate') }}" name="toDate"
                    class="showBonds form-control">
            </div>

            <div class="col-md-4">
                <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> النوع </span>
                </label>
                <select id="type" class="form-control showBonds" name="type">
                    <option selected disabled>اختر</option>
                    <option value="1" {{ request('type') == "1" ? 'selected' : '' }}>تفصيلي</option>
                    <option value="2" {{ request('type') == "2" ? 'selected' : '' }}>إجمالي</option>
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

                        <th>
                            @if ($type == '1')
                                التاريخ
                            @else
                                #
                            @endif
                        </th>
                        <th>إجمالي الاوردرات </th>
                        <th>المصروفات</th>
                        <th> تسديدات التجار</th>
                        <th> تسديدات الوكلاء</th>
                        <th>بدل البنزين</th>
                        <th>قيد التحصيل</th>
                        <th>المجموع</th>
                    </tr>
                </thead>
                @if ($type == '2')
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $allOrdersValues }}</td>
                            <td>{{ $expenses }}</td>
                            <td>{{ $traderPayments }}</td>
                            <td>{{ $solar }}</td>
                            <td>{{ $tahseel }}</td>
                            <td>{{ $allOrdersValues - ($expenses + $traderPayments + $solar + $tahseel) }}</td>
                        </tr>
                    </tbody>
                @endif
                {{-- <tfoot>
                    <tr>
                        <td> </td>
                        <td> شحن المندوب:</td>
                        <td id="commission"> </td>
                        <td> مصاريف المندوب :</td>
                        <td id="fees"> </td>
                        <td> قيمه الشحن بعد المصاريف: </td>
                        <td id="commission_after_fees"> </td>
                        <td> الراتب الاساسي :</td>
                        <td id="salary"> </td>
                        <td> المرتب : </td>
                        <td id="total"> </td>
                    </tr>


                </tfoot> --}}

            </table>
        </div>
    </div>
@endsection
@section('js')
    @if ($type == '1')
        <script src="{{ URL::asset('assets_new/datatable/feather.min.js') }}"></script>
        <script src="{{ URL::asset('assets_new/datatable/datatables.min.js') }}"></script>
        <script>
            var columns = [{
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'total_orders',
                    name: 'total_orders'
                },
                {
                    data: 'value',
                    name: 'value'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'solar',
                    name: 'solar'
                },
                {
                    data: 'shipment_value',
                    name: 'shipment_value'
                },
                {
                    data: 'total_value',
                    name: 'total_value'
                },
            ];

            var newUrl = '{{ route('treasury.index') }}';
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


                        $('#commission').html(settings.json.commission);
                        $('#fees').html(settings.json.fees);
                        $('#commission_after_fees').html(settings.json.commission_after_fees);
                        $('#salary').html(settings.json.salary);
                        $('#total').html(parseFloat(settings.json.salary) + parseFloat(settings.json
                            .commission_after_fees));


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
    @endif
@endsection
