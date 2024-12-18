<form id="updateOrdersForm">
    @csrf
    <div class="table-responsive"> <!-- Add this wrapper -->
        <table id="table" class="table table-bordered table-striped align-middle" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الطلب</th>
                    <th>اسم العميل في الاكسيل</th>
                    <th>رقم العميل في الاكسيل</th>
                    <th>قيمة الوكيل</th>
                    <th>قيمة التوصيل</th>
                    <th>الاجمالي في الاكسيل</th>
                    <th>الاجمالي في قاعدة البيانات</th>
                    <th>تفاصيل</th>
                    <th>اسم العميل في قاعدة البيانات </th>
                    <th>المندوب</th>
                    <th>المدينة</th>
                    <th>رقم التليفون</th>
                    <th>العنوان</th>
                    <th>التاجر</th>
                    <th>تاريخ الانشاء</th>
                    <th>ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $orders_count = 0;
                $total_agent_value = 0;
                $total_delivery_value = 0;
                $total = 0;
                ?>
                @foreach ($convertedOrders as $k => $convertedOrder)
                    <tr
                        @if (!$convertedOrder->order) style="background-color:#f8d7da;" @elseif ($convertedOrder->order && $convertedOrder->order['total_value'] != $convertedOrder->total) style="background-color:#FFFFC2;" @endif>
                        <td class="text-nowrap">{{ $convertedOrder->id }}</td>
                        <td class="text-nowrap">
                            @if ($convertedOrder->order)
                                <?php
                                $orders_count += 1;
                                $total_agent_value += $convertedOrder->agent_value;
                                $total_delivery_value += $convertedOrder->order['delivery_value'];
                                $total += $convertedOrder->total;
                                
                                ?>
                                <input type="hidden" name="ids[]" value="{{ $convertedOrder->order['id'] ?? '' }}">
                            @endif
                            {{ $convertedOrder->order['id'] ?? ' ' }}
                        </td>
                        <td class="text-nowrap">{{ $convertedOrder->customer_name }}</td>
                        <td class="text-nowrap">{{ $convertedOrder->customer_phone }}</td>
                        <td class="text-nowrap">
                            {{-- {{ $convertedOrder->agent_value }} --}}
                            @if ($convertedOrder->agent_value)
                                <input type="number" class="form-control form-control-sm" name="agent_value[]"
                                    value="{{ $convertedOrder->agent_value }}" style="width: 70px;">
                            @endif
                        </td>
                        <td class="text-nowrap">
                            @if ($convertedOrder->order)
                                {{ $convertedOrder->order->delivery_value }}
                            @endif
                        </td>
                        <td class="text-nowrap">{{ $convertedOrder->total }}</td>
                        <td class="text-nowrap">
                            @if ($convertedOrder->order)
                                <input type="number" class="form-control form-control-sm" name="total_value[]"
                                    value="{{ $convertedOrder->order['total_value'] }}" style="width: 70px;">
                                {{-- {{ $convertedOrder->order['total_value'] }} --}}
                            @endif
                        </td>
                        <td class="text-break">
                            <textarea name="agent_details[]" id="" cols="8" rows="2"></textarea>
                        </td>
                        <td class="text-nowrap">{{ $convertedOrder->order['customer_name'] ?? ' ' }}</td>
                        <td class="text-nowrap">{{ optional($convertedOrder->order)->delivery->name ?? ' ' }}</td>
                        <td class="text-nowrap">{{ optional($convertedOrder->order)->province->title ?? ' ' }}</td>
                        <td class="text-nowrap">{{ $convertedOrder->order['customer_phone'] ?? ' ' }}</td>
                        <td class="text-break">{{ $convertedOrder->order['customer_address'] ?? ' ' }}</td>
                        <td class="text-nowrap">{{ optional($convertedOrder->order)->trader->name ?? ' ' }}</td>
                        <td class="text-nowrap">{{ $convertedOrder->order['created_at'] ?? ' ' }}</td>
                        <td class="text-break">{{ $convertedOrder->order['notes'] ?? ' ' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: whitesmoke;">
                    <td style="color: red;" colspan="13">
                        عدد الاوردرات :

                        <input type="text" style="width: 60px;" id="orders_count" readonly=""
                            value="{{ $orders_count }}" />
                        اجمالي الوكيل :

                        <input type="text" style="width: 60px;" id="total_shipping" readonly=""
                            value="{{ $total_agent_value }}" />

                        اجمالي التوصيل :
                        <input type="text" style="width: 90px;" id="total_delivery_value" readonly=""
                            value="{{ $total_delivery_value }}" />
                        العمولة :
                        <input type="text" style="width: 40px;" id="commission" readonly=""
                            value="{{ $total_delivery_value - $total_agent_value }}" />
                        الاجمالي :
                        <input type="text" style="width: 90px;" id="total_orders" readonly=""
                            value="{{ $total }}" />
                        المستلم من الوكيل :
                        <input type="text" style="width: 90px;" id="total_from_agent" readonly=""
                            value="{{ $total - $total_agent_value }}" />
                        نقدي :
                        <input type="number" style="width: 70px;" id="cash" value="" />
                        غير نقدي :
                        <input type="number" style="width: 70px;" id="cheque" value="" />

                    </td>

                    <td style="color: red;" colspan="1"> <input type="date" name="day_date"
                            value="<?= date('Y-m-d') ?>" /> </td>
                    <td colspan="1"> <select class="form-control" id="month" name="month">
                            <option value=""> اختر الشهر </option>
                            <option value="1" <?php if (date('m') == 1) {
                                echo 'selected';
                            } ?>> يناير </option>
                            <option value="2" <?php if (date('m') == 2) {
                                echo 'selected';
                            } ?>> فبراير </option>
                            <option value="3" <?php if (date('m') == 3) {
                                echo 'selected';
                            } ?>> مارس </option>
                            <option value="4" <?php if (date('m') == 4) {
                                echo 'selected';
                            } ?>> ابريل </option>
                            <option value="5" <?php if (date('m') == 5) {
                                echo 'selected';
                            } ?>> مايو </option>
                            <option value="6" <?php if (date('m') == 6) {
                                echo 'selected';
                            } ?>> يونيو </option>
                            <option value="7" <?php if (date('m') == 7) {
                                echo 'selected';
                            } ?>> يوليو </option>
                            <option value="8" <?php if (date('m') == 8) {
                                echo 'selected';
                            } ?>> اغسطس </option>
                            <option value="9" <?php if (date('m') == 9) {
                                echo 'selected';
                            } ?>> سبتمبر </option>
                            <option value="10" <?php if (date('m') == 10) {
                                echo 'selected';
                            } ?>> اكتوبر </option>
                            <option value="11" <?php if (date('m') == 11) {
                                echo 'selected';
                            } ?>> نوفمبر </option>
                            <option value="12" <?php if (date('m') == 12) {
                                echo 'selected';
                            } ?>> ديسمبر </option>
                        </select> </td>
                    <td colspan="1"> <button type="button" class="btn btn-success form-control"
                            onclick="save_result();"> حفظ
                        </button></td>
                </tr>
            </tfoot>
        </table>
    </div>
    {{-- <div class="mt-3">
        <button id="submitBtn" type="button" class="btn btn-primary">تعديل</button>
    </div> --}}
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
<script>
    $(document).ready(function() {
        $('#cheque').on('keyup', function() {
            var totalValue = parseFloat($('#total_from_agent').val()) || 0;
            var chequeValue = parseFloat($(this).val()) || 0;
            var cashValue = parseFloat($('#cash').val()) || 0;

            if (chequeValue + cashValue > totalValue) {
                alert('لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ')
            }

        });
    });
    $(document).ready(function() {
        $('#cash').on('keyup', function() {
            var totalValue = parseFloat($('#total_from_agent').val()) || 0;
            var cashValue = parseFloat($(this).val()) || 0;
            var chequeValue = parseFloat($('#cheque').val()) || 0;

            if (chequeValue + cashValue > totalValue) {
                alert('لابد وأن تكون مجموع قيمتي النقدي وغير النقدي لا تزيد عن قيمة المبلغ')
            }

        });
    });

    function save_result() {
        var delivery_id = $('#agent_id').val();
        var all_orders = $('#orders_count').val();
        var mandoub_orders = $('#orders_count').val();
        var total_shipping = $('#total_delivery_value').val();
        var agent_value = $('#total_shipping').val();
        var commission = $('#commission').val();
        var total_orders = $('#total_orders').val();
        var total_from_agent = $('#total_from_agent').val();
        var month = $('#month').val();
        var cheque = $('#cheque').val();
        var cash = $('#cash').val();
        var idInput = document.querySelectorAll('input[name="ids[]"]');
        var ids = [];
        idInput.forEach(input => ids.push(input.value));

        // var fees = $('#fees').val();
        // var solar = $('#solar').val();
        // var selectedValues = [];
        // var status = [];
        // $('.myCheckboxClass:checked').each(function() {
        //     selectedValues.push($(this).val());
        //     status.push($(this).attr('data-status'));
        // });

        // if (selectedValues.length === 0) {
        //     alert("من فضلك قم بادخال الاوردرات");
        //     return;
        // }

        // if (delivery_id === '' || all_orders === '') {
        //     alert("من فضلك قم باختيار المندوب");
        //     return;
        // }

        $.ajax({
            url: '{{ route('admin.add_agent_orders') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                agent_id: delivery_id,
                all_orders: all_orders,
                mandoub_orders: mandoub_orders,
                total_shipping: total_shipping,
                agent_value: agent_value,
                total_orders: total_orders,
                total_from_agent: total_from_agent,
                month: month,
                commission: commission,
                ids: ids,
                cash: cash,
                cheque: cheque,
                // selectedValues: selectedValues,
                // status: status,
                // fees:fees,
                // solar:solar
            },
            beforeSend: function() {
                // Optional: Add loading spinner or disable submit button
            },
            complete: function() {
                // Optional: Remove loading spinner or enable submit button
            },
            success: function(data) {
                if (data.code === 200) {
                    toastr.success(data.message);
                    setTimeout(reloading, 1000);
                } else {
                    toastr.error(data.message);
                    $('#submit').html('{{ trans('admin.submit') }}').attr('disabled', false);
                }
            },
            error: function(data) {

                $('#submit').html('{{ trans('admin.submit') }}').attr('disabled', false);

                if (data.status === 500) {
                    toastr.error(data.responseJSON.message);
                    console.log(data.message);
                } else if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function(key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function(key, value) {
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
