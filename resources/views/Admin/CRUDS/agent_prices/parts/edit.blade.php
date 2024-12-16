<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('agent-price.update', $row->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="agent_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الوكيل</span>
            </label>

            <select id="agent_id" name="agent_id" class="form-control">

                <option selected disabled>اختر الوكيل</option>

            </select>


        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="from_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">المحافظة</span>
            </label>

            <select id="govern_id" name="govern_id" class="form-control">

                <option selected disabled>اختر المحافظة</option>

                @foreach ($countries as $country)
                    <option @if ($row->govern_id == $country->id) selected @endif value="{{ $country->id }}">
                        {{ $country->title }}</option>
                @endforeach
            </select>


        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">القيمه</span>
            </label>
            <!--end::Label-->
            <input id="value" required type="text" class="form-control form-control-solid" placeholder=""
                name="value" value="{{ $row->value }}" />
        </div>




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
