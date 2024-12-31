        @extends('Admin.layouts.inc.app')
        @section('title')
            تقارير المناديب
        @endsection
        @section('css')
        @endsection
        @section('content')
            <div class="row mb-3">
                <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                    <!--begin::Label-->
                    <label for="delivery_data" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> المندوب</span>
                    </label>
                    <select id='delivery_data' name="delivery_id" style='width: 200px;'>
                        <option selected value="0">- ابحث عن مندوب</option>
                        @if (request('delivery_id'))
                            <option value="{{ request('delivery_id') }}" selected>
                                {{ App\Models\Delivery::where('id', request('delivery_id'))->first()()->name }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-md-4 ">
                    <label for="from_date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> من تاريخ </span>

                    </label>
                    <input type="date" id="from_date" value="{{ request('fromDate') ?? date('Y-m-d') }}" name="fromDate"
                        class="showBonds form-control">

                </div>

                <div class="col-md-4 ">
                    <label for="to_date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> الي تاريخ </span>

                    </label>
                    <input type="date" value="{{ request('toDate') ?? date('Y-m-d') }}" id="to_date" name="toDate"
                        class="showBonds form-control">

                </div>





                <div class="col-md-4">
                    <label for="order_status" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required mr-1"> الحالة </span>

                    </label>

                    <select id="order_status" class="form-control showBonds" name="status">
                        <option selected disabled> جميع الحالات</option>
                        <option
                            @isset($request['status']) @if ($request['status'] == 'new') selected @endif   @endisset
                            value="new">جديد</option>
                        <option
                            @isset($request['status']) @if ($request['status'] == 'converted_to_delivery') selected @endif   @endisset
                            value="converted_to_delivery">محول الي مندوب</option>
                        <option
                            @isset($request['status']) @if ($request['status'] == 'total_delivery_to_customer') selected @endif   @endisset
                            value="total_delivery_to_customer">مسلم كليا</option>
                        <option
                            @isset($request['status']) @if ($request['status'] == 'partial_delivery_to_customer') selected @endif   @endisset
                            value="partial_delivery_to_customer">مسلم جزئيا</option>
                        <option
                            @isset($request['status']) @if ($request['status'] == 'not_delivery') selected @endif   @endisset
                            value="not_delivery">لم يسلم</option>
                        <option
                            @isset($request['status']) @if ($request['status'] == 'under_implementation') selected @endif   @endisset
                            value="under_implementation">تحت التنفيذ</option>
                        <option
                            @isset($request['status']) @if ($request['status'] == 'delaying') selected @endif   @endisset
                            value="delaying">مؤجل </optiيذon>

                        <option
                            @isset($request['status']) @if ($request['status'] == 'cancel') selected @endif   @endisset
                            value="cancel">لاغي </optiيذon>


                        <option
                            @isset($request['status']) @if ($request['status'] == 'collection') selected @endif   @endisset
                            value="collection">التحصيل</option>
                        <option
                            @isset($request['status']) @if ($request['status'] == 'paid') selected @endif   @endisset
                            value="paid">الدفع</option>


                    </select>


                </div>

                <div class="col-md-4">
                    <button type="button" onclick="get_result();" class="btn btn-primary my-4">بحث</button>
                </div>
                <div id="result"></div>

            </div>
        @endsection
        @section('js')
            <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
            <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>



            <script>
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
                function get_result() {

                    var delivery_id = $('#delivery_data').val();
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var order_status = $('#order_status').val();

                    if (from_date == '' || to_date == '') {
                        alert(" من فضلك قم باختيار التواريخ");
                        return;
                    }


                    $.ajax({
                        url: '{{ route('admin.get_delivery_orders') }}',
                        type: 'POST',
                        data: {
                            delivery_id: delivery_id,
                            from_date: from_date,
                            to_date: to_date,
                            order_status: order_status
                        },
                        beforeSend: function() {

                        },
                        complete: function() {},
                        success: function(data) {
                            $('#result').html(data);

                            //$('.delivery_value'+valu).val(data);
                            // get_order_value(valu);
                        },

                        error: function(data) {


                        }, //end error method


                    });




                }
            </script>
        @endsection
