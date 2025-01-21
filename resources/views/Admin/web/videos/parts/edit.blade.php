<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('videos.update', $row->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="image" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الصورة </span>
            </label>
            <!--end::Label-->
            <input type="file" name="image" id="image" class="dropify" data-default-file="{{ asset('/storage/' . $row->image) }}"
                accept="image/*" />
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="video" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الفيديو </span>
            </label>
            <!--end::Label-->
            <input type="file" name="video" id="video" class="dropify" data-default-file="{{ asset('/storage/' . $row->video) }}">
        </div>

    </div>
</form>
