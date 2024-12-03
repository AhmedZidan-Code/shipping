@extends('Trader.layouts.inc.app')
@section('title')
    الرئيسية
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>

@endsection
@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12 mt-3">
            <a href="{{route('trader.trader-orders.index')}}">
            <div class="card mini-stat bg-primary bg-1">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cube-outline float-end"></i>
                    </div>
                    <div class="text-white titels_style">
                        <h6 class="text-uppercase mb-3 font-size-16 text-white">  جميع الطلبات</h6>
                        <h2 class="mb-4 text-white">{{$totalOrders}}</h2>
                        {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span>--}}
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-3">
            <a href="{{route('trader.get_tahseel')}}">
            <div class="card mini-stat bg-primary bg-2">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cube-outline float-end"></i>
                    </div>
                    <div class="text-white titels_style">
                        <h6 class="text-uppercase mb-3 font-size-16 text-white"> الطلبات المحصلة</h6>
                        <h2 class="mb-4 text-white">{{$mohsala}}</h2>
                        {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span>--}}
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-3">
            <a href="{{route('trader.get_hadback')}}">
            <div class="card mini-stat bg-primary bg-3">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cube-outline float-end"></i>
                    </div>
                    <div class="text-white titels_style">
                        <h6 class="text-uppercase mb-3 font-size-16 text-white">المرتجعات</h6>
                        <h2 class="mb-4 text-white">{{$hadback}}</h2>
                        {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span>--}}
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-3">
            <a href="{{route('myOrders.index')}}?status=converted_to_delivery">
            <div class="card mini-stat bg-primary bg-4">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cube-outline float-end"></i>
                    </div>
                    <div class="text-white titels_style">
                        <h6 class="text-uppercase mb-3 font-size-16 text-white">نسبة التسليمات</h6>
                        <h2 class="mb-4 text-white">{{number_format(($mohsala/$totalOrders) * 100 , 1)}} %</h2>
                        {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span>--}}
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-3">
            <a href="{{route('myOrders.index')}}?status=converted_to_delivery">
            <div class="card mini-stat bg-primary bg-5">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cube-outline float-end"></i>
                    </div>
                    <div class="text-white titels_style">
                        <h6 class="text-uppercase mb-3 font-size-16 text-white">الطلبات تحت التنفيذ </h6>
                        <h2 class="mb-4 text-white">{{$converted}}</h2>
                        {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span>--}}
                    </div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-3">
            <a href="{{route('myOrders.index')}}?status=total_delivery_to_customer">
                <div class="card mini-stat bg-primary bg-6">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-buffer float-end"></i>
                        </div>
                        <div class="text-white titels_style">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات مسلمة كليا</h6>
                            <h2 class="mb-4 text-white">{{$total}}</h2>
                            {{--                        <span class="badge bg-danger"> -29% </span> <span class="ms-2">From previous period</span>--}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-3">
            <a href="{{route('myOrders.index')}}?status=partial_delivery_to_customer">
                <div class="card mini-stat bg-primary bg-7">
                    <div class="card-body mini-stat-img ">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline float-end"></i>
                        </div>
                        <div class="text-white titels_style">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات مسلمة جزئيا </h6>
                            <h2 class="mb-4 text-white">{{$partial}}</h2>
                            {{--                        <span class="badge bg-warning"> 0% </span> <span class="ms-2">From previous period</span>--}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-3">
            <a href="{{route('trader.hadback.index')}}">
                <div class="card mini-stat bg-primary bg-8">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-briefcase-check float-end"></i>
                        </div>
                        <div class="text-white titels_style">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات غير مسلمة</h6>
                            <h2 class="mb-4 text-white">{{$notDelivery}}</h2>
                            {{--                        <span class="badge bg-info"> +89% </span> <span class="ms-2">From previous period</span>--}}
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="card">
                <div class="card-header border-bottom-0">
                  <h3>الطلبات</h3>
                </div>
                <div class="card-body pt-0">
                  <div id="chartone" class="chart"></div>
                </div>
              </div>
            </div>
    </div>
    <!-- end row -->



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">اجندة الطلبات </h4>

                    <div class="row">
                        <div id="calendar"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

    <script src="https://washsquadsa.com/admin/plugins/calendar/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"
            integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/ar.min.js"
            integrity="sha512-gVMzWflhCRdT4UPPUzNR9gCPtBZuc77GZxVx2CqSZyv0kEPIISiZEU0hk6Sb/LLSO87j4qXH/m9Iz373K+mufw=="
            crossorigin="anonymous"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#calendar').fullCalendar({
            defaultView: 'month',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            isRTL: true,
            locale: 'ar',
            lang: 'ar',
            editable: false,
            disableDragging: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            events: '{{route('trader.calender')}}',
            eventRender: function (event, element, view) {
                var sup = element.find('.fc-content')
                var con = sup.closest('span');
                var day_title = 'عدد الطلبات';

                sup.html(day_title + "<br>" + event.title + " <br> <br>" + `<button style="display: none" id="${event.ids}" class="click_me btn btn-outline-danger text-white">تفاصيل</button>`);
                //event.title
            }
        });//calender object

        $(document).on('click', '.click_me', function (e) {
            e.preventDefault()
            alert($(this).attr('id'))
        })
    </script>
<script src="https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
<script>
    var myChart = echarts.init(document.getElementById('chartone'));
    option = {
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'shadow'
        },
        textStyle: {
          fontFamily: 'Bahij_Plain'
        }
      },
      grid: {
        top: "9%",
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
      },
      xAxis: [{
        data: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
        axisLabel: {
          textStyle: {
            fontSize: 14,
            fontFamily: 'Bahij_Plain'
          }
        }
      }],
      yAxis: [{
        type: 'value'
      }],
      series: [{
        name: 'الطلبات',
        type: 'bar',
        barWidth: '45%',
        data: [{
            value: 35,
            itemStyle: {
              color: '#69F0AE'
            }
          },
          {
            value: 30,
            itemStyle: {
              color: '#FFAB40'
            }
          },
          {
            value: 25,
            itemStyle: {
              color: '#41C4FF'
            }
          },
          {
            value: 20,
            itemStyle: {
              color: '#536DFE'
            }
          },
          {
            value: 15,
            itemStyle: {
              color: '#FF4081'
            }
          },
          {
            value: 10,
            itemStyle: {
              color: '#26A69A'
            }
          },
          {
            value: 5,
            itemStyle: {
              color: '#D4E157'
            }
          }
        ]
      }]
    };
    myChart.setOption(option);
  </script>

@endsection
