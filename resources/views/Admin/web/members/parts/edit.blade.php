<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('members.update', $row->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder=""
                name="name" value="{{ $row->name }}" />
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="job_title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">المسمى الوظيفي</span>
            </label>
            <!--end::Label-->
            <input id="job_title" required type="text" class="form-control form-control-solid" placeholder=""
                name="job_title" value="{{ $row->job_title }}" />
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="facebook_profile" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">بروفايل الفيس بوك</span>
            </label>
            <!--end::Label-->
            <input id="facebook_profile" required type="url" class="form-control form-control-solid" placeholder=""
                name="facebook_profile" value="{{ $row->facebook_profile }}" />
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="twitter_profile" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">بروفايل تويتر</span>
            </label>
            <!--end::Label-->
            <input id="twitter_profile" required type="url" class="form-control form-control-solid" placeholder=""
                name="twitter_profile" value="{{ $row->twitter_profile }}" />
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="linkedin_profile" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">بروفايل لينكد إن</span>
            </label>
            <!--end::Label-->
            <input id="linkedin_profile" required type="url" class="form-control form-control-solid" placeholder=""
                name="linkedin_profile" value="{{ $row->linkedin_profile }}" />
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="image" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الصورة </span>
            </label>
            <!--end::Label-->
            <input type="file" name="image" id="image" class="dropify"
                data-default-file="{{ asset('/storage/' . $row->image) }}" accept="image/*" />
        </div>

    </div>
</form>
