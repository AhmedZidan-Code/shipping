<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('trader-payments.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-12 ">
            <label for="date" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> التاريخ </span>
            </label>
            <input type="date" id="date" name="date" class="showBonds form-control">
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="trader_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> التاجر</span>
            </label>
            <select id='trader_modal_id' name="trader_id" >
                <option selected value="0" disabled>- ابحث عن التاجر</option>
            </select>
        </div>
        <div class="col-md-6 ">
            <label for="trader_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> النوع</span>
            </label>
            <select class="form-control" name="type" >
               
              <option value="2"> مقدم </option>
            </select>
        </div>
        <div class="col-md-6 ">
            <label for="cash" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> نقدي </span>
            </label>
            <input type="number" id="cash" name="cash" class="showBonds form-control">
        </div>
        <div class="col-md-6 ">
            <label for="cheque" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> غير نقدي</span>
            </label>
            <input type="number" id="cheque" name="cheque" class="showBonds form-control">
        </div>
        <div class="col-md-12 ">
            <label for="notes" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الملاحظات </span>
            </label>
            <textarea id="notes" name="notes" class="showBonds form-control"></textarea>
        </div>
    </div>
</form>
