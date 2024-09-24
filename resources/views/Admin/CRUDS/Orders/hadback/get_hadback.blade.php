@extends('Trader.layouts.inc.app')
@section('title')
    المدفوع كمرتجع
@endsection
@section('css')
@endsection
@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> عرض المدفوع كمرتجع</h5>


        </div>
         
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                   style="width:100%">
                <thead>
                <tr>
                 
                    <th>#</th>
                    <th>الحالة</th>
                    <th>المندوب</th>
                    <th>اسم العميل</th>
                    <th>المحافظة</th>
                  
                    <th>رقم تليفون العميل</th>
                    <th>وقت التسليم</th>
                    <th>عدد القطع داخل الشحنة</th>
                    <th>قيمة الشحنة</th>
                    
                     <th> الملاحظات </th>
                    <th>قيمة التوصيل</th>
                    
                   
                    <th>تاريخ التحويل</th>
                    <th> تاريخ الانشاء</th>
                    
                </tr>
             <tfoot>
                <tr style="background: whitesmoke;">
                <td> </td>
                 
                 
                    <td> </td>
                     <td> </td>
                      <td> </td>
                       <td> </td>
                 <td> </td>
                         <td> المجموع </td>
                  <td id="ahmed"> </td>
                       
                 
                  <td> </td>
                   <td> </td>
                  
                    <td> </td>
                     <td> </td>
                      <td> </td>
                     
                
                
                </tr>
                
                
                </tfoot>
            </table>
            
            
            
        </div>
    </div>

@endsection
@section('js')




    <script>
        var columns = [
        
           
            {data: 'id', name: 'id'},
            {data: 'status', name: 'status'},
            {data: 'delivery_id', name: 'delivery_id'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'province.title', name: 'province.title'},
            
            {data: 'customer_phone', name: 'customer_phone'},
            {data: 'delivery_time', name: 'delivery_time'},
            {data: 'shipment_pieces_number', name: 'shipment_pieces_number'},
            {data: 'shipment_value', name: 'shipment_value'},
            
             {data: 'notes', name: 'notes'},
            {data: 'delivery_ratio', name: 'delivery_ratio'},
          
            {data: 'converted_date', name: 'converted_date'},
            {data: 'created_at', name: 'created_at'},
            
        ];
        
       

    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'hadback'])

    


    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>

    <script>

        (function () {

            $("#trader_id").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{route('admin.getTraders')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
        })();

    </script>




@endsection
