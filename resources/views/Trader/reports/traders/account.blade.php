@extends('Trader.layouts.inc.app')
@section('title')
    تقارير التجار
@endsection
@section('css')
@endsection
@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">   كشف حساب</h5>
        </div>

        <div class="card-body" id="table_content">
                      <h2>{{ $trader->name }}</h2>
          <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
              <thead>
                  <tr>
                      <th>#</th>
                      <th> التاريخ </th>
                      <th>العملية</th>
                      <th>عدد الاوردرات</th>
                      <th>الاجمالي</th>
                      <th>المتبقي</th>
                  </tr>

              <tbody>
                  <tr style="background-color: darkgray;">
                      <th colspan="3" style="text-align: center; vertical-align: middle;">الاوردرات</th>
                      <th>{{ $count }}</th>
                      <th>{{ $total }}</th>
                      <th>{{ $total }}</th>
                  </tr>
                  @php
                  @endphp
                  @foreach ($paymentOrders as $k=>$payment)
                  @php ++$k; @endphp
                      @if ($payment['type'] == App\Enums\TransactionType::HADBACK)
                          <tr>
                              <th>{{$k}}</th>
                              <th>{{ $payment['date'] }}</th>
                              <th>دفع كمرتجع</th>
                              <th>{{ $payment['orders_count'] }}</th>
                              <th>{{ $payment['amount'] }}</th>
                              <th>{{ $total = $total - $payment['amount'] }}</th>
                          </tr>
                      @elseif ($payment['type'] == App\Enums\TransactionType::TAHSEEL)
                          <tr>
                              <th>{{$k}}</th>
                              <th>{{ $payment['date'] }}</th>
                              <th> تم الدفع</th>
                              <th>{{ $payment['orders_count'] }}</th>
                              <th>{{ $payment['amount'] }}</th>
                              <th>{{ $total = $total - $payment['amount'] }}</th>
                          </tr>
                      @elseif ($payment['type'] == App\Enums\TransactionType::DEPOSIT)
                          <tr>
                              <th>{{$k}}</th>
                              <th>{{ $payment['date'] }}</th>
                              <th>مقدم</th>
                              <th>{{ $payment['orders_count'] }}</th>
                              <th>{{ $payment['amount'] }}</th>
                              <th>{{ $total = $total + $payment['amount'] }}</th>
                          </tr>
                      @endif
                  @endforeach
                  <tr>
                      <th colspan="3" style="text-align: center; vertical-align: middle;">المتبقي</th>
                      <th colspan="2" style="text-align: center; vertical-align: middle;">{{ $total }}</th>
                  </tr>
              </tbody>
          </table>

        </div>
    </div>
@endsection

