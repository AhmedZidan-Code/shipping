<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('statistics.store') }}">
    @csrf
    <div class="row g-4">
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="from_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الصفحة</span>
            </label>

            <select id="from_id" name="page" class="form-control">

                <option selected disabled>اختر الصفحة</option>

                @foreach ($pages as $key => $page)
                    <option value="{{ $key }}"> {{ $page }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
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
            <label for="cash" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">القيمة</span>
            </label>
            <!--end::Label-->
            <input id="value" required type="text" class="form-control form-control-solid" placeholder=""
                name="value" value="" />
        </div>
    </div>
</form>
