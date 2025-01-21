<div id="{{$id}}" class="d-flex justify-content-between">

    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-2">
        <!--begin::Label-->
        <label for="product_name-{{$id}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
            <span class="required mr-1">اسم المنتج</span>
        </label>
        <!--end::Label-->
        <input id="product_name-{{$id}}" required type="text" class="form-control form-control-solid" placeholder=" " name="product_name[]" value=""/>
    </div>


    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-2">
        <!--begin::Label-->
        <label for="count-{{$id}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
            <span class="required mr-1"> الكمية</span>
        </label>
        <!--end::Label-->
        <input id="count-{{$id}}" required type="number" class="form-control form-control-solid" placeholder=" " name="count[]" value=""/>
    </div>


    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 mt-2">
        <!--begin::Label-->
        <label for="weight-{{$id}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
            <span class="required mr-1"> الوزن </span>
        </label>
        <!--end::Label-->
        <input id="weight-{{$id}}" required type="number" class="form-control form-control-solid" placeholder=" " name="weight[]" value=""/>
    </div>






    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-2 mt-2">
        <!--begin::Label-->
        <label for="details-{{$id}}" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
            <span class="required mr-1"> التفاصيل</span>
        </label>
        <!--end::Label-->
        <input id="details-{{$id}}" required type="text" class="form-control form-control-solid" placeholder=" " name="details[]" value=""/>
    </div>




    <div style="cursor: pointer" data-id="{{$id}}" class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 mt-2 deleteRow">

      x

    </div>

</div>
