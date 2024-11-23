@extends('Admin.layouts.inc.app')
@section('title')
      تقرير الربح العام
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('company-profits.index') }}">
        <div class="row mb-3">

            <div class="d-flex flex-column mb-7  col-sm-3">
                <label for="month-select" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">اختر الشهر:</label>
                <select id="month-select" class="select2" name="month">
                    <!-- Options will be dynamically added -->
                </select>
            </div>
            <div class="d-flex flex-column mb-7  col-sm-3">
                <label for="year-select" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">اختر السنة:</label>
                <select id="year-select" class="select2" name="year">
                    <!-- Options will be dynamically added -->
                </select>

            </div>
            <div class="col-md-3">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">   تقرير الربح العام</h5>


        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>عمولة الشركة</th>
                        <th>المصروف</th>
                        <th>البنزين</th>
                        <th>المصروفات الادارية</th>
                        <th>المتبقي</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="2">المجموع</td>
                        <td id="commission_sum"></td>
                        <td id="fees_sum"></td>
                        <td id="solar_sum"></td>
                        <td id="value_sum"></td>
                        <td id="total_remainder"></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td>اجمالي الرواتب</td>
                        <td id="total_salary"></td>
                        <td colspan="4">الصـــــــــــــــافي</td>
                        <td id="net_profit"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets_new/datatable/feather.min.js') }}"></script>
    <script src="{{ URL::asset('assets_new/datatable/datatables.min.js') }}"></script>
    <script>
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'company_commission',
                name: 'company_commission'
            },
            {
                data: 'fees',
                name: 'fees'
            },
            {
                data: 'solar',
                name: 'solar'
            },
            {
                data: 'value',
                name: 'value',
            },
            {
                data: 'remainder',
                name: 'remainder'
            },
        ];
        var newUrl = "{{ route('company-profits.index') }}";
        let month = "{{ request('month') }}";
        let year = "{{ request('year') }}";
        $(function() {
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
                        month: month,
                        year: year,
                    }
                },
                columns: columns,
                "language": <?php echo json_encode(datatable_lang()); ?>,

                "drawCallback": function(response) {

                    if (response.json) {
                        $('#total_salary').html(response.json.total_salary);
                        $('#total_remainder').html(response.json.total_remainder);
                        $('#net_profit').html(response.json.net_profit);
                        $('#commission_sum').html(response.json.commission_sum);
                        $('#fees_sum').html(response.json.fees_sum);
                        $('#solar_sum').html(response.json.solar_sum);
                        $('#value_sum').html(response.json.value_sum);
                    }
                },

                searching: true,
                destroy: true,
                info: false,


            });


        });
    </script>


    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>
    <script>
        $(".select2").select2({});
    </script>

    <script>
        const months = [
            "يناير", "فبراير", "مارس", "ابريل",
            "مايو", "يونيو", "يوليو", "أغسطس",
            "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"
        ];
        const monthSelect = document.getElementById('month-select');
        const currentMonth = new Date().getMonth(); // Current month (0-based index)

        months.forEach((month, index) => {
            const option = document.createElement('option');
            option.value = index + 1; // Month value (1-12)
            option.textContent = month; // Month name

            // Mark the current month as selected
            if (index === currentMonth) {
                option.selected = true;
            }

            monthSelect.appendChild(option);
        });
    </script>
    </script>
    <script>
        const startYear = 2015; // Start year for the dropdown
        const endYear = new Date().getFullYear(); // Current year
        const yearSelect = document.getElementById('year-select');

        for (let year = startYear; year <= endYear; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;

            // Check if the year is the current year and mark it as selected
            if (year === endYear) {
                option.selected = true;
            }

            yearSelect.appendChild(option);
        }
    </script>
@endsection
