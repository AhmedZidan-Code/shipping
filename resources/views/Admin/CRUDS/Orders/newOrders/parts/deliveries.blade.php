
<form id="form-delivery" enctype="multipart/form-data" method="POST" action="{{route('admin.insertingDeliveryForOrder',$order->id)}}">
    @csrf
    <div class="row g-4">


        <input type="hidden" id="order_id_delivery" value="{{$order->id}}">

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">المندوب</span>
            </label>
            <!--end::Label-->
              <select class="form-control" id="delivery_id" name="delivery_id">
                  <option disabled selected>اختر المندوب</option>

                  @foreach($delivers as $delivery)

                      <option value="{{$delivery->id}}">{{$delivery->name}}</option>

                  @endforeach

              </select>
        </div>







    </div>
</form>
