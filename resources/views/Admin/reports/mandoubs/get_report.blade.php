<style>
    .table-container {
        max-height: 400px;
        max-height: 800px;
         /* Adjust the height as needed */
        overflow-y: auto;
         overflow-x: auto;
    }
    .table thead th {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 10;
    }
</style>

    <input type="hidden" name="delivery_id" class="delivery_id" value="{{ $delivery_id }}"/>
<div class="card-body table-responsive">
    <table id="table2" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
        <thead>
            <tr style="background-color: black;">
                <th style="background-color: black;">#</th>
                <th style="background-color: black;">رقم الاوردر</th>
                <th style="background-color: black;">الحالة</th>
                <th style="background-color: black;">المندوب</th>
                <th style="background-color: black;">اسم العميل</th>
                <th style="background-color: black;">المحافظة</th>
                <th style="background-color: black;">عنوان العميل</th>
                <th style="background-color: black;">رقم تليفون العميل</th>
                <th style="background-color: black;">التاجر</th>
                <th style="background-color: black;">الاجمالي</th>
                <th style="background-color: black;">المحصل (جزئي)</th>
                <th style="background-color: black;">الملاحظات</th>
                 <th style="background-color: black;">تاريخ التحويل</th>
                <th style="background-color: black;">تفاصيل الطلب</th>
            </tr>
        </thead>
        <tbody>
            @php $x=0 ;
            $all_total= 0;
            $total_for_mndoub= 0 ;
            $num_for_mandoub = 0 ;
            $arr= array(
                'converted_to_delivery'=>'محول الي مندوب',
                'partial_delivery_to_customer'=>'تسليم جزئي',
                'not_delivery'=>'عدم استلام',
                'total_delivery_to_customer'=>'تم التسليم',
                'collection'=>'تحصيل',
                'delaying'=>'مؤجل',
                'cancel'=>'ملغي',
                'under_implementation'=> 'تحت  التنفيذ',
                'new'=> 'جديد',
                'paid'=>'تم الدفع',
                'shipping_on_messanger'=>'الشحن علي الراسل'
            );
            @endphp

            @foreach($records as $row)
            @php
          $count=  DB::table('delivery_orders_details')->where('order_id',$row->id)->count();
          @endphp
           @if ($count > 0)
        @continue
        @endif
            
            @php $x++ @endphp
            
             @if($row->status =='shipping_on_messanger')
            @php
            
            $num_for_mandoub = $num_for_mandoub+1;
           
            @endphp
            @endif
            @if($row->status =='total_delivery_to_customer' || $row->status == 'paid')
            @php
            $all_total= $all_total + $row->total_value;
            $num_for_mandoub = $num_for_mandoub+1;
            $total_for_mndoub = $total_for_mndoub + $row->delivery_value;
            @endphp
            @endif

            @if($row->status =='not_delivery')
            @php
            $all_total= $all_total + $row->delivery_value;
            $num_for_mandoub = $num_for_mandoub+1;
            $total_for_mndoub = $total_for_mndoub + $row->delivery_value;
            @endphp
            @endif

            @if($row->status =='partial_delivery_to_customer')
            @php
            $all_total= $all_total + $row->partial_value;
            $num_for_mandoub = $num_for_mandoub+1;
            $total_for_mndoub = $total_for_mndoub + $row->delivery_value;
            @endphp
            @endif
            <tr>
                <td> <input checked="" type="checkbox" data-status="{{ $row->status }}" class="myCheckboxClass" value="{{ $row->id }}" /> </td>
                <td>{{ $row->id }}</td>
                @if($row->status=='new')
                <td id="td{{$row->id}}"> <button class="btn btn-info insertDelivery" data-id= '{{$row->id}}'>{{ $arr[$row->status] }}</button> </td>
                @elseif($row->status=='converted_to_delivery')
                <td id="td{{$row->id}}"> <button class="btn btn-primary changeStatusData" data-id= '{{$row->id}}'>{{ $arr[$row->status] }}</button> </td>
                @elseif($row->status=='total_delivery_to_customer')
                <td> <button class="btn btn-success StatusTotalDelivery" data-id= '{{$row->id}}'>{{ $arr[$row->status] }}</button> </td>
                @elseif($row->status=='not_delivery')
                <td> <button class="btn btn-danger StatusNotDelivery" data-id= '{{$row->id}}'>{{ $arr[$row->status] }}</button> </td>
                @elseif($row->status=='cancel')
                <td> <button class="btn btn-danger StatusCancel" data-id= '{{$row->id}}'>{{ $arr[$row->status] }}</button> </td>
                @elseif($row->status=='delaying')
                <td> <button class="btn btn-warning StatusDelaying" data-id= '{{$row->id}}'>{{ $arr[$row->status] }}</button> </td>
                @elseif($row->status == 'partial_delivery_to_customer')
                <td> <button class="btn btn-warning StatusPartialDelivery" data-id= '{{$row->id}}'>{{ $arr[$row->status] }}</button> </td>
                @else
                <td> <button class="btn btn-info info" data-id= '{{$row->id}}'>{{ $arr[$row->status] }}</button> </td>
                @endif
                <td>@if($row->delivery) {{ $row->delivery->name }} @endif</td>
                <td>{{ $row->customer_name }}</td>
                <td>{{ $row->province->title }}</td>
                <td>{{ $row->customer_address }}</td>
                <td>{{ $row->customer_phone }}</td>
                <td>{{ $row->trader->name }}</td>
                <td> {{ $row->total_value }}</td>
                <td> {{ $row->partial_value }}</td>
                <td> {{ $row->notes }}</td>
                <td> {{ $row->converted_date }}</td>
                <td><a href="{{ route('admin.orderDetails',$row->id) }}" target="_blank" class="btn rounded-pill btn-outline-dark"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: whitesmoke;">
                <td style="width: 2%;"><input style="width: 30px;" type="text" width="10px" id="all_orders" readonly="" value="{{$x }}" /></td>
                
                <td colspan=""> تنفيذات المندوب :
                
                <input type="text" style="width: 60px;" id="mandoub_orders" readonly="" value="{{$num_for_mandoub }}" />
                
                </td>   
                
                <td colspan="">  
               اجمالي قيمه الشحن :
                
                <input type="text" style="width: 60px;" id="total_shipping" readonly="" value="{{$total_for_mndoub }}" />
                
                 </td>
               
                <td colspan=""> الاجمالي </td>
                <td style="color: red;" colspan="2"> <input type="text" style="width: 90px;" id="total_orders" readonly="" value="{{$all_total }}" /> </td>
               
                 <td style="color: red;"> المصروف :<input type="number" value="0" id="fees" name="fees" />  </td>
                 
                   <td style="color: red;"> بدل بنزين :<input type="number" style="width: 90px;"  value="0" id="solar" name="solar" />  </td>
               <td style="color: red; width: 2%;"> <input type="date" name="day_date" value="<?= date('Y-m-d')?>" /> </td>
                <td colspan="2"> <select class="form-control" id="month" name="month">
                        <option value=""> اختر الشهر </option>
                        <option value="1" <?php if(date('m')==1) echo 'selected';?>> يناير </option>
                        <option value="2" <?php if(date('m')==2) echo 'selected';?>> فبراير </option>
                        <option value="3" <?php if(date('m')==3) echo 'selected';?>> مارس </option>
                        <option value="4" <?php if(date('m')==4) echo 'selected';?>> ابريل </option>
                        <option value="5" <?php if(date('m')==5) echo 'selected';?>> مايو </option>
                        <option value="6" <?php if(date('m')==6) echo 'selected';?>> يونيو </option>
                        <option value="7" <?php if(date('m')==7) echo 'selected';?>> يوليو </option>
                        <option value="8" <?php if(date('m')==8) echo 'selected';?>> اغسطس </option>
                        <option value="9" <?php if(date('m')==9) echo 'selected';?>> سبتمبر </option>
                        <option value="10" <?php if(date('m')==10) echo 'selected';?>> اكتوبر </option>
                        <option value="11" <?php if(date('m')==11) echo 'selected';?>> نوفمبر </option>
                        <option value="12" <?php if(date('m')==12) echo 'selected';?>> ديسمبر </option>
                    </select> </td>
                <td> <button type="button" class="btn btn-success form-control" onclick="save_result();"> حفظ </button></td>
            </tr>
        </tfoot>
    </table>
</div>


<div class="modal fade" id="Modal-delivery" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent-delivery">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2> التسليم الي المندوب </h2>  
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <button class="btn btn-sm btn-icon btn-active-color-primary" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                    <!--end::Close-->
                </div>
                <!--begin::Modal body-->
                <div class="modal-body py-4" id="form-load-delivery">

                </div>
              
                <!--end::Modal body-->
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light me-2">
                            الغاء
                        </button>
                        <button form="form-delivery" type="submit" id="submit-delivery" class="btn btn-primary">
                            <span class="indicator-label">اتمام</span>
                        </button>
                    </div>
                </div>
            </div>

            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    
    
    <!-------------------------------------------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="modal fade" id="Modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2><span ></span> تغير حالة الطلب  </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <button class="btn btn-sm btn-icon btn-active-color-primary" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                    <!--end::Close-->
                </div>
                <!--begin::Modal body-->
                <div class="modal-body py-4" id="form-load">

                </div>
                  <input type="hidden" name="row_id" id="row_id"/>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light me-2">
                            الغاء
                        </button>
                        <button form="form" type="submit" id="submit" class="btn btn-primary active2">
                            <span class="indicator-label"> اتمام</span>
                        </button>
                    </div>
                </div>
            </div>

            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

<!---------------------------------------------------------------------------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------------------------------------------->


<script>
   $(document).ready(function() {
    $('#table2').DataTable({
        scrollX: true,
        // Other DataTable options can go here
    });
});
</script>
     @include('Admin.layouts.inc.ajax',['url'=>'orders'])
    
        <script>
        $(document).on('click','.insertDelivery',function (){
            
            
            var id=$(this).attr('data-id');

            var route="{{route('admin.getDeliveryForOrder',':id')}}";

            route=route.replace(':id',id);
            
            

            $('#form-load-delivery').html(loader_form)

            $('#Modal-delivery').modal('show');
            
        

            setTimeout(function (){
                $('#form-load-delivery').load(route)
            },1000)
        })
    </script>
    <script>
        $(document).on('submit',"#form-delivery",function (e) {
            e.preventDefault();

            var id=$('#order_id_delivery').val();

            var route="{{route('admin.insertingDeliveryForOrder',':id')}}";
            route=route.replace(':id',id);

            var formData = new FormData(this);

            var url = $('#form-delivery > form').attr('action');
           $.ajax({
                url: route,
                type: 'POST',
                data: formData,
                beforeSend: function () {


                    $('#submit-delivery').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">{{trans('admin.working')}}</span>').attr('disabled', true);
                    $('#form-load-delivery').append(loader_form)
                    $('#form-load-delivery > form').hide()
                },
                complete: function () {
                },
                success: function (data) {

                    window.setTimeout(function () {
                        $('#submit-delivery').html('{{trans('admin.submit')}}').attr('disabled', false);

                        if (data.code == 200) {
                            toastr.success(data.message)
                            $('#Modal-delivery').modal('hide')
                            $('#form-load-delivery > form').remove()
                            $('#table').DataTable().ajax.reload(null, false);
                        }else {
                            $('#form-load-delivery > .linear-background').hide(loader_form)
                            $('#form-load-delivery > form').show()
                            toastr.error(data.message)
                        }
                    }, 1000);



                },
                error: function (data) {
                    $('#form-load-delivery > .linear-background').hide(loader_form)
                    $('#submit-delivery').html('{{trans('admin.submit')}}').attr('disabled', false);
                    $('#form-load-delivery > form').show()
                    if (data.status === 500) {
                        toastr.error('{{trans('admin.error')}}')
                    }
                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);

                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value)
                                });

                            } else {

                            }
                        });
                    }
                    if (data.status == 421){
                        toastr.error(data.message)
                    }

                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

    </script>
   
     <script>
        $(document).on('click','.changeStatusData',function (){

            var id=$(this).attr('data-id');

            $('#row_id').val(id);


            $('#form-load').html(loader_form)

            $('#Modal').modal('show')

            var url="{{route('admin.changeStatusForOrder',':id')}}";
            url=url.replace(':id',id);
            setTimeout(function (){
                $('#form-load').load(url)
            },1000)


        })
        
        
        
    </script>
    
    
  
    <script>
        $(document).on('click','.active2',function (){
                
                var status = $('#status-convert').val();
              
                var row_id = $('#row_id').val();
                    $.ajax({
                        url: '{{route('admin.change_button')}}',
                        type: 'POST',
                        data: {row_id: row_id,status:status},
                        beforeSend: function () {

                        },
                       complete: function () {
                       },
                       success: function (data) {
                       // alert(data);
                          console.log(data);
                      $('#td'+row_id).html(data);

                        //$('.delivery_value'+valu).val(data);
                       // get_order_value(valu);
                       },

                       error: function (data) {
                 

                       },//end error method


                     });


        })
        
    
    </script>
    
    
    <!----------------------------------------- Total Delivery----------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------------------------------------------------------->
    
    
    <script>
        $(document).on('click','StatusTotalDelivery',function (){

            var id=$(this).attr('data-id');


            $('#form-load').html(loader_form)

            $('#Modal').modal('show')

            var url="{{route('admin.changeStatusForOrder',':id')}}";
            url=url.replace(':id',id);
            setTimeout(function (){
                $('#form-load').load(url)
            },1000)


        })
    </script>
    
    
    
    
    
    
    
    <!-------------------------------------------- not delivery--------------------------------------------------------------------------->
    <!------------------------------------------------------------------------------------------------------------------------------------->
    
    <script>
        $(document).on('click','.StatusNotDelivery',function (){

            var id=$(this).attr('data-id');




            $('#form-load').html(loader_form)

            $('#Modal').modal('show')

            var url="{{route('admin.changeStatusForOrder',':id')}}";
            url=url.replace(':id',id);
            setTimeout(function (){
                $('#form-load').load(url)
            },1000)


        })
    </script>
    
     <!-------------------------------------------- StatusNotDelivery--------------------------------------------------------------------------->
    <!------------------------------------------------------------------------------------------------------------------------------------->
    
    
     <script>
        $(document).on('click','.StatusNotDelivery',function (){

            var id=$(this).attr('data-id');




            $('#form-load').html(loader_form)

            $('#Modal').modal('show')

            var url="{{route('admin.changeStatusForOrder',':id')}}";
            url=url.replace(':id',id);
            setTimeout(function (){
                $('#form-load').load(url)
            },1000)


        })
    </script>
    
    
      <!-------------------------------------------- StatusCancel--------------------------------------------------------------------------->
    <!------------------------------------------------------------------------------------------------------------------------------------->
   
   
    
     <script>
        $(document).on('click','.StatusCancel',function (){

            var id=$(this).attr('data-id');




            $('#form-load').html(loader_form)

            $('#Modal').modal('show')

            var url="{{route('admin.changeStatusForOrder',':id')}}";
            url=url.replace(':id',id);
            setTimeout(function (){
                $('#form-load').load(url)
            },1000)


        })
    </script>
    
    
       <!-------------------------------------------- StatusDelaying--------------------------------------------------------------------------->
    <!------------------------------------------------------------------------------------------------------------------------------------->
   
   
     
     <script>
        $(document).on('click','.StatusDelaying',function (){

            var id=$(this).attr('data-id');




            $('#form-load').html(loader_form)

            $('#Modal').modal('show')

            var url="{{route('admin.changeStatusForOrder',':id')}}";
            url=url.replace(':id',id);
            setTimeout(function (){
                $('#form-load').load(url)
            },1000)


        })
    </script> 
    
    
    <!------------------------------------------------------------------------------------------------------------------------------------------>
    <!------------------------------------------------------------------------------------------------------------------------------------------>
    
    <script>
        $(document).on('click','.StatusPartialDelivery',function (){

            var id=$(this).attr('data-id');




            $('#form-load').html(loader_form)

            $('#Modal').modal('show')
 
            var url="{{route('admin.changeStatusForOrder',':id')}}";
            url=url.replace(':id',id);
            setTimeout(function (){
                $('#form-load').load(url)
            },1000)


        })
    </script>
    
    <!----------------------------------------------------------------------------------------------------------------------------------------------->
    <!------------------------------------------------------------------------------------------------------------------------------------------------>
    <script>
function save_result() {
    var delivery_id = $('.delivery_id').val();
    var all_orders = $('#all_orders').val();
    var mandoub_orders = $('#mandoub_orders').val();
    var total_shipping = $('#total_shipping').val();
    var total_orders = $('#total_orders').val();
    var month = $('#month').val();
    var fees = $('#fees').val();
    var solar = $('#solar').val();
    var selectedValues = [];
    var status = [];
    $('.myCheckboxClass:checked').each(function() {
        selectedValues.push($(this).val());
        status.push($(this).attr('data-status'));
    });

    if (selectedValues.length === 0) {
        alert("من فضلك قم بادخال الاوردرات");
        return;
    }

    if (delivery_id === '' || all_orders === '') {
        alert("من فضلك قم باختيار المندوب");
        return;
    }

    $.ajax({
        url: '{{ route('admin.add_delivery_orders') }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            delivery_id: delivery_id,
            all_orders: all_orders,
            mandoub_orders: mandoub_orders,
            total_shipping: total_shipping,
            total_orders: total_orders,
            selectedValues: selectedValues,
            status: status,
            month :month,
            fees:fees,
            solar:solar
        },
        beforeSend: function () {
            // Optional: Add loading spinner or disable submit button
        },
        complete: function () {
            // Optional: Remove loading spinner or enable submit button
        },
        success: function (data) {
             if (data.code === 200) {
                toastr.success(data.message);
                setTimeout(reloading, 1000);
            } else {
                toastr.error(data.message);
                $('#submit').html('{{ trans('admin.submit') }}').attr('disabled', false);
            }
        },
        error: function (data) {
         
            $('#submit').html('{{ trans('admin.submit') }}').attr('disabled', false);

            if (data.status === 500) {
               toastr.error(data.responseJSON.message);
               console.log(data.message);
            } else if (data.status === 422) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors, function (key, value) {
                    if ($.isPlainObject(value)) {
                        $.each(value, function (key, value) {
                            toastr.error(value);
                        });
                    }
                });
            } else if (data.status === 421) {
                toastr.error(data.message);
            }
        },
       
    });
}
</script>

    
    
