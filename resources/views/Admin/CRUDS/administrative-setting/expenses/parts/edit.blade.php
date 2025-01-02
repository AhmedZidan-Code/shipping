<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('expenses.update', $row->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> اختر المندوب </span>

            </label>
            <select class="delivery_data" name="delivery_id">
                <option selected disabled>- ابحث عن المندوب</option>
                @if ($row->delivery)
                <option value="{{ $row->delivery_id }}" selected > {{ $row->delivery->name }}</option>
                @endif
            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">تاريخ الصرف</span>
            </label>
            <!--end::Label-->
            <input id="date" required type="date" class="form-control form-control-solid" placeholder=""
                name="date" value="{{ $row->date }}" />
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <select name='setting_id' data-id='$row->id' class='form-control changeStatus'>
                <option selected disabled> اختر فئة المصروفات</option>
                @foreach ($settings as $value)
                    <option value='{{ $value->id }}' {{ $value->id == $row->setting_id ? 'selected' : '' }}>
                        {{ $value->title }}</option>
                @endforeach

            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="value" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">قيمة المصروفات</span>
            </label>
            <!--end::Label-->
            <input id="value" required type="number" class="form-control form-control-solid" placeholder=""
                name="value" value="{{ $row->value }}" />
        </div>
    </div>
</form>
<script>
    $('.dropify').dropify();
</script>
