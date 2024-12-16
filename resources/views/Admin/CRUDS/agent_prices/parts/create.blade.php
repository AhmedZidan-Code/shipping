<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('agent-price.store') }}">
    @csrf
    <div class="row g-4">


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="agent_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الوكيل</span>
            </label>

            <select id="agent_id" name="agent_id" class="form-control select2" data-live-search="true">

                <option selected disabled> اختر الوكيل</option>

            </select>


        </div>
        <table
            class="table table-bordered dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المحافظه</th>
                    <th>القيمه</th>
                </tr>
            </thead>
            <tbody>
                @php $x=0 ; @endphp
                @foreach ($countries as $country)
                    <tr>
                        <td>@php echo $x++ ; @endphp</td>
                        <td>{{ $country->title }} <input type="hidden" value="{{ $country->id }}" class="form-control"
                                name="govern_id[]" /> </td>
                        <td> <input type="text" value="0" class="form-control" name="value[]" /> </td>

                    </tr>
                @endforeach
            </tbody>

        </table>

        <!--

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            
            <label for="from_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">المحافظة</span>
            </label>

            <select id="govern_id"  name="govern_id" class="form-control">

                <option selected disabled>اختر المحافظة</option>

                @foreach ($countries as $country)
<option value="{{ $country->id }}" > {{ $country->title }}</option>
@endforeach
            </select>


        </div>
        
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            
            <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> القيمه</span>
            </label>
           
            <input id="title" required type="number" class="form-control form-control-solid" placeholder="" name="value" value=""/>
        </div>
<!--begin::Label-->


    </div>
</form>

<link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
<script src="{{ url('assets/dashboard/js/select2.js') }}"></script>
<script>
    $('#Modal').on('shown.bs.modal', function(event) {
        $(document).ready(function() {

            setTimeout(function() {
                $("#agent_id").select2({
                    placeholder: 'Channel...',
                    allowClear: true,
                    dropdownParent: $('#Modal'), // Attach the dropdown to the modal
                    ajax: {
                        url: '{{ route('admin.getAgents') }}',
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
<script>
    $('.dropify').dropify();
</script>
