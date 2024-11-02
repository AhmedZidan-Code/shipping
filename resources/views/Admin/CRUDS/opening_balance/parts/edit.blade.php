<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('opening-balance.update', $row->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">



        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <label for="date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">التاريخ </span>
            </label>
            <!--end::Label-->
            <input id="date" required type="date" class="form-control form-control-solid" placeholder=""
                name="date" value="{{ $row->date }}" />
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="balance" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> قيمة الرصيد</span>
            </label>
            <!--end::Label-->
            <input id="balance" required type="number" class="form-control form-control-solid" placeholder=""
                name="balance" value="{{ $row->balance }}" />
        </div>
    </div>
</form>

