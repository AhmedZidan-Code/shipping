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
@extends('Admin.layouts.inc.app')
@section('title')
    عرض تنفيذات المندوب
@endsection
@section('css')
@endsection
@section('content')
    <div class="card-body table-responsive">
        <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
            <thead>
                <tr style="background-color: black;">

                    <th style="background-color: black;">رقم الاوردر</th>
                    <th style="background-color: black;">الحالة</th>

                    <th style="background-color: black;">اسم العميل</th>

                    <th style="background-color: black;">عنوان العميل</th>
                    <th style="background-color: black;">رقم تليفون العميل</th>
                    <th style="background-color: black;">التاجر</th>
                    <th style="background-color: black;">الاجمالي</th>
                    <th style="background-color: black;">المحصل (جزئي)</th>

                </tr>
            </thead>
            <tbody>
                @php
                    $x = 1;
                    $all_total = 0;
                    $total_for_mndoub = 0;
                    $num_for_mandoub = 0;
                    $arr = [
                        'converted_to_delivery' => 'محول الي مندوب',
                        'partial_delivery_to_customer' => 'تسليم جزئي',
                        'not_delivery' => 'عدم استلام',
                        'total_delivery_to_customer' => 'تم التسليم',
                        'collection' => 'تحصيل',
                        'delaying' => 'مؤجل',
                        'cancel' => 'ملغي',
                        'under_implementation' => 'تحت  التنفيذ',
                        'shipping_on_messanger' => 'الشحن علي الراسل',
                        'new' => 'جديد',
                        'paid' => 'تم الدفع',
                    ];
                @endphp
                @foreach ($records as $row)
                    @php $x++ @endphp

                    <tr>

                        <td>{{ $row->order_id }}</td>
                        @if ($row->status == 'new')
                            <td> <button class="btn btn-info insertDelivery"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @elseif($row->status == 'converted_to_delivery')
                            <td> <button class="btn btn-primary changeStatusData"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @elseif($row->status == 'total_delivery_to_customer')
                            <td> <button class="btn btn-success StatusTotalDelivery"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @elseif($row->status == 'shipping_on_messanger')
                            <td> <button class="btn btn-success StatusShippingOnMessanger"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @elseif($row->status == 'not_delivery')
                            <td> <button class="btn btn-danger StatusNotDelivery"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @elseif($row->status == 'cancel')
                            <td> <button class="btn btn-danger StatusCancel"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @elseif($row->status == 'delaying')
                            <td> <button class="btn btn-warning StatusDelaying"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @elseif($row->status == 'partial_delivery_to_customer')
                            <td> <button class="btn btn-warning StatusPartialDelivery"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @else
                            <td> <button class="btn btn-info info"
                                    data-id= '{{ $row->id }}'>{{ $arr[$row->status] ?? '' }}</button> </td>
                        @endif

                        <td>{{ $row->customer_name }}</td>

                        <td>{{ $row->customer_address }}</td>
                        <td>{{ $row->customer_phone }}</td>
                        <td>{{ $row->name }}</td>
                        <td> {{ $row->total_value }}</td>
                        <td> {{ $row->partial_value }}</td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endsection
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            scrollX: true,
            // Other DataTable options can go here
        });
    });
</script>
