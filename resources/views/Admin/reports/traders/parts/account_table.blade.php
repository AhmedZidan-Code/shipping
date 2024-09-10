          <h2>{{ $trader->name }}</h2>
          <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>العملية</th>
                      <th>عدد الاوردرات</th>
                      <th>الاجمالي</th>
                      <th>المتبقي</th>
                  </tr>

              <tbody>
                  <tr>
                      <th colspan="2">الاوردرات</th>
                      <th>{{ $count }}</th>
                      <th>{{ $total }}</th>
                      <th>{{ $total }}</th>
                  </tr>
                  @php
                  @endphp
                  @foreach ($paymentOrders as $k=>$payment)
                      @if ($payment['type'] == App\Enums\TransactionType::HADBACK)
                          <tr>
                              <th>{{$k}}</th>
                              <th>دفع كمرتجع</th>
                              <th>{{ $payment['orders_count'] }}</th>
                              <th>{{ $payment['amount'] }}</th>
                              <th>{{ $total = $total - $payment['amount'] }}</th>
                          </tr>
                      @elseif ($payment['type'] == App\Enums\TransactionType::TAHSEEL)
                          <tr>
                              <th>{{$k}}</th>
                              <th> تم الدفع</th>
                              <th>{{ $payment['orders_count'] }}</th>
                              <th>{{ $payment['amount'] }}</th>
                              <th>{{ $total = $total - $payment['amount'] }}</th>
                          </tr>
                      @elseif ($payment['type'] == App\Enums\TransactionType::DEPOSIT)
                          <tr>
                              <th>{{$k}}</th>
                              <th>مقدم</th>
                              <th>{{ $payment['orders_count'] }}</th>
                              <th>{{ $payment['amount'] }}</th>
                              <th>{{ $total = $total + $payment['amount'] }}</th>
                          </tr>
                      @endif
                  @endforeach
                  <tr>
                      <th colspan="2">المتبقي</th>
                      <th colspan="2">{{ $total }}</th>
                  </tr>
              </tbody>
          </table>
