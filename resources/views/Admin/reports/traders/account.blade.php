@extends('Admin.layouts.inc.app')
@section('title')
    تقارير التجار
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('tradersReports.index') }}">

        <div class="d-flex flex-column mb-7 fv-row col-sm-4">
            <!--begin::Label-->
            <label for="trader_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> التاجر</span>
            </label>
            <select id='trader_id' name="trader_id" style='width: 200px;'>
                <option selected value="0">- ابحث عن التاجر</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary my-4">بحث</button>
        </div>
        </div>

    </form>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تقارير أرصدة التجار</h5>


        </div>

        <div class="card-body" id="table_content">
            <h5 class="card-title mb-0 flex-grow-1" id="table_place">من فضلك اختر تاجر</h5>
        </div>
    </div>
@endsection
@section('js')
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

        $('#trader_id').on('change', function() {

            var traderId = $(this).val();
            let url = '{{ route('admin.trader_accounts', ['trader_id' => ':trader_id']) }}';
            url = url.replace(':trader_id', traderId);
            console.log(url);

            if (traderId) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#table_content').html(data.view); // Replace the content of the div with the new data
                    },
                    error: function(err) {
                        console.error('Error:', err);
                    }
                });
            }
        });
    </script>
@endsection
