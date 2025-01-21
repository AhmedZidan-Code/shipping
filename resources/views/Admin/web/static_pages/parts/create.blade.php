<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('static-pages.store') }}">
    @csrf
    <div class="row g-4">
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="from_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الصفحة</span>
            </label>

            <select id="from_id" name="page" class="form-control">

                <option selected disabled>اختر الصفحة</option>

                @foreach ($pages as $key => $page)
                    @if (!in_array($key, $created->toArray()))
                        <option value="{{ $key }}"> {{ $page }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="cash" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">العنوان</span>
            </label>
            <!--end::Label-->
            <input id="title" required type="text" class="form-control form-control-solid" placeholder=""
                name="title" value="" />
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="description" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الوصف </span>
            </label>
            <!--end::Label-->
            <textarea name="description" id="description" rows="5"></textarea>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="image" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الصورة </span>
            </label>
            <!--end::Label-->
            <input type="file" name="image" id="image" class="dropify">
        </div>





    </div>
</form>
