<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('administrative-settings.store') }}">
    @csrf
    <div class="row g-4">


        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">العنوان</span>
            </label>
            <!--end::Label-->
            <input id="title" required type="text" class="form-control form-control-solid" placeholder=""
                name="title" value="" />
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <select name='type' data-id='$row->id' class='form-control changeStatus'>
                <option selected disabled> اختر الحالة</option>
                @foreach (App\Enums\SettingType::getValues() as  $value)
                <option $option1 value='{{$value}}'>{{App\Enums\SettingType::getName($value)}}</option>
                @endforeach

            </select>
        </div>



    </div>
</form>
<script>
    $('.dropify').dropify();
</script>
