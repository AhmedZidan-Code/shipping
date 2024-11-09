<form id="updateOrdersForm">
    @csrf
    <div class="table-responsive"> <!-- Add this wrapper -->
        <table id="table" class="table table-bordered table-striped align-middle" style="width:100%">
            <thead>
                <tr>
                    <th >#</th>
                    <th >رقم الطلب</th>
                    <th >اسم العميل في الاكسيل</th>
                    <th >رقم العميل في الاكسيل</th>
                    <th >اسم الوكيل</th>
                    <th >المندوب</th>
                    <th >المدينة</th>
                    <th >رقم التليفون</th>
                    <th >العنوان</th>
                    <th >التاجر</th>
                    <th >الاجمالي في الاكسيل</th>
                    <th >الاجمالي في قاعدة البيانات</th>
                    <th >تاريخ الانشاء</th>
                    <th >ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($convertedOrders as $k => $convertedOrder)
                    <tr @if (($convertedOrder->order && $convertedOrder->order['total_value'] != $convertedOrder->total) || !$convertedOrder->order) style="background-color:#f8d7da;" @endif>
                        <td class="text-nowrap">{{ $convertedOrder->id }}</td>
                        <td class="text-nowrap">
                            @if ($convertedOrder->order)
                                <input type="hidden" name="ids[]" value="{{ $convertedOrder->order['id'] ?? '' }}">
                            @endif
                            {{ $convertedOrder->order['id'] ?? ' ' }}
                        </td>
                        <td class="text-nowrap">{{ $convertedOrder->customer_name }}</td>
                        <td class="text-nowrap">{{ $convertedOrder->customer_phone }}</td>
                        <td class="text-nowrap">{{ $convertedOrder->order['customer_name'] ?? ' ' }}</td>
                        <td class="text-nowrap">{{ optional($convertedOrder->order)->delivery->name ?? ' ' }}</td>
                        <td class="text-nowrap">{{ optional($convertedOrder->order)->province->title ?? ' ' }}</td>
                        <td class="text-nowrap">{{ $convertedOrder->order['customer_phone'] ?? ' ' }}</td>
                        <td class="text-break">{{ $convertedOrder->order['customer_address'] ?? ' ' }}</td>
                        <td class="text-nowrap">{{ optional($convertedOrder->order)->trader->name ?? ' ' }}</td>
                        <td class="text-nowrap">{{ $convertedOrder->total }}</td>
                        <td class="text-nowrap">
                            @if ($convertedOrder->order)
                                <input type="number" class="form-control form-control-sm" name="total_value[]"
                                    value="{{ $convertedOrder->order['total_value'] }}">
                            @endif
                        </td>
                        <td class="text-nowrap">{{ $convertedOrder->order['created_at'] ?? ' ' }}</td>
                        <td class="text-break">{{ $convertedOrder->order['notes'] ?? ' ' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <button id="submitBtn" type="button" class="btn btn-primary">تعديل</button>
    </div>
</form>



<script>
    // Optional: Initialize DataTables with scroll options
    $(document).ready(function() {
        $('#table').DataTable({
            scrollX: true,
            scrollY: '500px', // Adjust height as needed
            scrollCollapse: true,
            fixedHeader: true,
            paging: false, // Disable pagination if not needed
            responsive: true
        });
    });
</script>
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
