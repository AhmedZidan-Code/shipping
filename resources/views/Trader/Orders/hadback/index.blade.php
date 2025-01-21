@extends('Trader.layouts.inc.app')
@section('title')
    المرتجعات
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('trader.hadback.index') }}">
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

        </div>
        <div class="col-md-2">
            <button class="btn btn-primary my-4">بحث</button>
        </div>
        </div>

    </form>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تقارير التجار</h5>


        </div>

        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th> الحالة</th>

                        <th>اسم العميل</th>
                        <th>المحافظة</th>

                        <th>رقم تليفون العميل</th>

                        <th> الاجمالي</th>
                        <th> قيمه التوصيل</th>

                        <th>قيمة الشحنة</th>
                        <th> الملاحظات</th>
                        <th>تاريخ التحويل</th>
                        <th> تاريخ الانشاء</th>

                    </tr>

                <tfoot>
                    <tr style="background: whitesmoke;">
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>

                        <td> المجموع </td>
                        <td id="ahmed"> </td>
                        <td> </td>
                        <td> </td>


                    </tr>


                </tfoot>

            </table>
        </div>
    </div>
@endsection
@section('js')
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
                data: 'total_value',
                name: 'total_value'
            },
            {
                data: 'delivery_value',
                name: 'delivery_value'
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
                data: 'created_at',
                name: 'created_at'
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'hadback'])

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

    <script>
        function change_status() {
            var selectedValues = [];
            $('.myCheckboxClass:checked').each(function() {
                selectedValues.push($(this).val());
            });
            if (selectedValues.length == '') {
                alert("من فضلك قم بادخال الاوردرات");
                return;
            }
            $.ajax({
                url: '{{ route('hadback.store') }}',
                type: 'POST',
                data: {
                    selectedValues: selectedValues,
                    _token: '{{ csrf_token() }}' // Add CSRF token if needed
                },
                beforeSend: function() {
                    // Optionally, show a loader or disable the button
                },
                complete: function() {
                    // Optionally, hide the loader or enable the button
                },
                success: function(data) {
                    if (data.code == 200) {
                        toastr.success(data.message);
                        $('#table').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422) { // Laravel validation error
                        var errors = jqXHR.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]); // Show the first()t error message for each field
                        });
                    } else {
                        toastr.error('حدث خطأ غير متوقع، حاول مرة أخرى.');
                    }
                }
            });
        }
    </script>



    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

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
@endsection
