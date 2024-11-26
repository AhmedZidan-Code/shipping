<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('features.update', $row->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="cash" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">العنوان</span>
            </label>
            <!--end::Label-->
            <input id="title" required type="text" class="form-control form-control-solid" placeholder=""
                name="title" value="{{ $row->title }}" />
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="description" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الوصف </span>
            </label>
            <!--end::Label-->
            <textarea name="description" id="description" rows="5">{{ $row->description }}</textarea>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="image" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الصورة </span>
            </label>
            <!--end::Label-->
            <input type="file" name="image" id="image" class="dropify" data-default-file="{{ asset('/storage/' . $row->image) }}"
                accept="image/*" />
        </div>

    </div>
</form>
