
<form id="form" enctype="multipart/form-data" method="POST" action="{{route('delivery.deliveryChangeOrderStatus_store',$row->id)}}">
    @csrf
    <div class="row g-4">




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="status-convert" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الحالة</span>
            </label>
            <!--end::Label-->
            <select class="form-control" name="status" id="status-convert">
                <option value="converted_to_delivery" selected disabled>تم التحويل الي المندوب</option>
                <option value="total_delivery_to_customer"  >تم   التسليم الكلي</option>
                <option value="partial_delivery_to_customer"  >تم التسليم  الجزئي</option>
                <option value="not_delivery"  >   لم يتم التسليم</option>

            </select>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="refused_reason" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> السبب</span>
            </label>
            <textarea  name="refused_reason" id="refused_reason" rows="5" class="form-control"
                       placeholder=" اكتب هنا "></textarea>
        </div>

    </div>
</form>
