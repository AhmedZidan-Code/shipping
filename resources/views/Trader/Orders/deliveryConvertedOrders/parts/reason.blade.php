
<form id="form" enctype="multipart/form-data" method="POST" action="{{route('deliveryConvertedOrders.store')}}">
    @csrf
    <div class="row g-4">

       <input type="hidden" name="order_id" value="{{$order->id}}">
        <input type="hidden" name="status" value="{{$status}}">


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
