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
                    <th>قيمة الوكيل في قاعدة البيانات</th>
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
                            {{ $convertedOrder->agent_value }}
                        </td>
                        <td class="text-nowrap">
                            <input type="number" id="agent-value-{{ $convertedOrder->id }}"
                                class="form-control form-control-sm agent_value" name="delivery_value[]"
                                value="{{ $convertedOrder->agent_value }}" style="width: 70px;"
                                onkeyup="updateCalculations({{ $convertedOrder->id }})"
                                data-order-value="{{ $convertedOrder->order->shipment_value }}">
                        </td>
                        <td class="text-nowrap">{{ $convertedOrder->total }}</td>
                        <td class="text-nowrap">
                            @if ($convertedOrder->order)
                                <input type="number" id="total-value-{{ $convertedOrder->id }}"
                                    class="form-control form-control-sm total_value" name="total_value[]"
                                    value="{{ $convertedOrder->order['total_value'] }}"
                                    onkeyup="updateCalculations({{ $convertedOrder->id }})" style="width: 70px;">
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
        var formDataArray = $('#updateOrdersForm').serializeArray();

        formDataArray.push({
            name: 'agent_id',
            value: $('#agent_id').val()
        }, {
            name: 'all_orders',
            value: $('#orders_count').val()
        }, {
            name: 'mandoub_orders',
            value: $('#orders_count').val()
        }, {
            name: 'total_shipping',
            value: $('#total_delivery_value').val()
        }, {
            name: 'agent_value',
            value: $('#total_shipping').val()
        }, {
            name: 'commission',
            value: $('#commission').val()
        }, {
            name: 'total_orders',
            value: $('#total_orders').val()
        }, {
            name: 'total_from_agent',
            value: $('#total_from_agent').val()
        }, {
            name: 'month',
            value: $('#month').val()
        }, {
            name: 'cheque',
            value: $('#cheque').val()
        }, {
            name: 'cash',
            value: $('#cash').val()
        });

        // Convert the array into a URL-encoded string
        var formData = $.param(formDataArray);


        $.ajax({
            url: '{{ route('admin.add_agent_orders') }}',
            type: 'POST',
            data: formData,
            beforeSend: function() {},
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

    function sumValuesByClass(className) {
        const inputs = document.querySelectorAll(`.${className}`);
        return Array.from(inputs).reduce((sum, input) => sum + (parseFloat(input.value) || 0), 0);
    }

    function updateCalculations(id) {
        let AGENT_VALUE = parseFloat($('#agent-value-' + id).val()) || 0;
        let ORDER_VALUE = parseFloat($('#agent-value-' + id).data('order-value')) || 0;
        let TOTAL_VALUE = $('#total-value-' + id).val(AGENT_VALUE + ORDER_VALUE);
        let totalSum = sumValuesByClass('total_value');
        let totalDelivery = sumValuesByClass('agent_value');
        $('#total_orders').val(totalSum)
        $('#total_shipping').val(totalDelivery);
        $('#total_delivery_value').val(totalDelivery);
    }
</script>
