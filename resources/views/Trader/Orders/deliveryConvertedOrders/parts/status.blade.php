
<form id="form" enctype="multipart/form-data" method="POST" action="{{route('admin.changeStatusForOrder_store',$order->id)}}">
    @csrf
    <div class="row g-4">




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="status-convert" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الحالة</span>
            </label>
            <!--end::Label-->
            <select class="form-control" name="status" id="status-convert" onchange="put_partial_value();">
                <option value="converted_to_delivery" selected > محول الي المندوب</option>
                <option value="total_delivery_to_customer" @if($order->status=='total_delivery_to_customer')  selected @endif >تم التسليم </option>
                <option value="partial_delivery_to_customer" @if($order->status=='partial_delivery_to_customer')  selected @endif  >تسليم  جزئي</option>
                <option value="not_delivery" @if($order->status=='not_delivery')  selected @endif  >     عدم استلام </option>
                
                <option value="delaying" @if($order->status=='delaying')  selected @endif  > مؤجل </option>
                <option value="cancel"  @if($order->status=='cancel')  selected @endif > لاغي </option>
                <option value="under_implementation" @if($order->status=='under_implementation')  selected @endif  > تحت التنفيذ </option>
                 <option value="shipping_on_messanger" @if($order->status=='shipping_on_messanger')  selected @endif  > الشحن علي الراسل</option>

            </select>
        </div>
        
        
         <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="status-convert" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">تغيير المندوب</span>
            </label>
            <!--end::Label-->
            <select class="form-control" name="delivery_id" id="delivery_id" >
             <option value=""> اختر </option>
               @foreach($delivies as $row)
               <option value="{{ $row->id }}" @if($order->delivery_id == $row->id )  selected @endif> {{ $row->name }}</option>
               @endforeach

            </select>
        </div>

        <div class=" col-sm-6 partial_value" @if($order->status != 'partial_delivery_to_customer') style="display: none;" @endif >
            <!--begin::Label-->
            <label for="status-convert" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> المبلغ المحصل</span>
                
            </label>
            <input type="number" value="{{$order->partial_value}}" name="partial_value" class="form-control" id="partial_value" />
            </div>
            
            <div class=" col-sm-6 delivery_value" @if($order->status != 'not_delivery') style="display: block;" @endif >
            <!--begin::Label-->
            <label for="status-convert" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> قيمه التوصيل</span>
                
            </label>
            <input type="number" value="{{$order->delivery_value}}" name="delivery_value" class="form-control" id="delivery_value" />
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

   <script>
      function put_partial_value()
      {
        var status = $('#status-convert').val();
        if(status == 'partial_delivery_to_customer')
        {
            $('.partial_value').show();
            $('#partial_value').show();
          
        }else{
            
            $('.partial_value').hide();
            $('#partial_value').hide();
            $('#partial_value').val( '');
        }
        
        if(status == 'not_delivery')
        {
            $('.delivery_value').show();
            $('#delivery_value').show();
          
        }else{
            
            $('.delivery_value').hide();
            $('#delivery_value').hide();
           // $('#delivery_value').val( '');
        }
      }
     
     </script>
