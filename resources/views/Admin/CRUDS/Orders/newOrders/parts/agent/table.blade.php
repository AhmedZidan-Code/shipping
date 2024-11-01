    <form id="updateOrdersForm">
        @csrf
        <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th> اسم العميل في الاكسيل</th>
                    <th>اسم العميل</th>
                    <th>المندوب</th>
                    <th>المدينة</th>
                    <th> رقم التليفون</th>
                    <th> العنوان </th>
                    <th>التاجر</th>
                    <th>الاجمالي في الاكسيل</th>
                    <th> الاجمالي في قاعدة البيانات</th>
                    <th> تاريخ الانشاء</th>
                    <th>ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($convertedOrders as $convertedOrder)
                    <tr @if ($convertedOrder->total_value != $convertedOrder->excel_total)
                        style="background-color:#f8d7da;"
                    @endif>
                        <td>
                            <input type="hidden" name="ids[]" value="{{ $convertedOrder->id }}">
                            {{ $convertedOrder->id }}
                        </td>
                        <td>{{ $convertedOrder->excel_name }}</td>
                        <td>{{ $convertedOrder->customer_name }}</td>
                        <td>{{ $convertedOrder->delivery->name }}</td>
                        <td>{{ $convertedOrder->province->title }}</td>
                        <td>{{ $convertedOrder->customer_phone }}</td>
                        <td>{{ $convertedOrder->customer_address }}</td>
                        <td>{{ $convertedOrder->trader->name }}</td>
                        <td>{{ $convertedOrder->excel_total }}</td>
                        <td><input type="number" name="total_value[]" value="{{ $convertedOrder->total_value }}"></td>
                        <td>{{ $convertedOrder->created_at }}</td>
                        <td>{{ $convertedOrder->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button id="submitBtn" type="button" class="btn btn-primary">تعديل</button>
        </div>
    </form>
    <script>

        $(document).ready(function() {
            $('#submitBtn').on('click', function(e) {
                e.preventDefault();
                console.log('omar pero');
                
                var formData = $('#updateOrdersForm').serialize(); 

                $.ajax({
                    url: "{{ route('agent.orders-update-value') }}",  
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#submitBtn').prop('disabled', true); //    
                    },
                    success: function(response) {
                            toastr.success(response.message);
                    },
                    error: function(xhr) {
                        // في حال حدوث خطأ
                        var errorMessage = 'An error occurred while processing the request';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.error(errorMessage);
                        } else {
                            alert(errorMessage);
                        }
                    },
                    complete: function() {
                        $('#submitBtn').prop('disabled', false); // 
                    }
                });
            });
        });
    </script>