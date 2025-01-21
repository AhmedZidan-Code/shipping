@extends('Admin.layouts.inc.app')
@section('title')
    الرئيسية
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
@endsection
@section('content')
    <div class="row">
    
     <div class="col-xl-3 col-sm-6">
            <a href="{{ route('orders.index') }}">
                <div class="card mini-stat bg-primary" style="background-color: red;">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon" style="">
                            <i class="mdi mdi-cube-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> new Day</h6>
                           
                            <h2 class="mb-4 text-white">{{ $daynewOrders }}</h2>
                            {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="#">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cube-outline float-end"></i>
                        </div>
                        <div class="text-white">
                         @php $totalOrders2 = $newOrders +  $convertedOrders  + $tahseel + $notDelivery +$asTahseel + $asHadback @endphp
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">جميع الطلبات</h6>
                            <h2 class="mb-4 text-white">{{ $totalOrders2 }}</h2>
                            {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('orders.index') }}">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cube-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">الطلبات الجديدة</h6>
                           
                            <h2 class="mb-4 text-white">{{ $newOrders }}</h2>
                            {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>
            </a>

        </div>
        
        
           
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('deliveryConvertedOrders.index') }}">

                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-buffer float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">الطلبات محولة للمناديب</h6>
                            <h2 class="mb-4 text-white">{{ $convertedOrders }}</h2>
                            {{--                        <span class="badge bg-danger"> -29% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>
            </a>

        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('totalDeliveryOrders.index') }}">

                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> نسبه التحصيلات  </h6>
                            <h2 class="mb-4 text-white">
                                {{ $totalOrders2 > 0 ? number_format(($asTahseel / $totalOrders2) * 100, 1) : 0 }} %</h2>
                            {{--                        <span class="badge bg-warning"> 0% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>

            </a>

        </div>
        
         <div class="col-xl-3 col-sm-6">
            <a href="{{ route('totalDeliveryOrders.index') }}">

                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> نسبه المرتحعات </h6>
                            <h2 class="mb-4 text-white">
                                {{ $totalOrders2 > 0 ? number_format(($asHadback / $totalOrders2) * 100, 1) : 0 }} %</h2>
                            {{--                        <span class="badge bg-warning"> 0% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>

            </a>

        </div>
        
        
         <div class="col-xl-3 col-sm-6">
            <a href="{{ route('totalDeliveryOrders.index') }}">

                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">  نسبه التنفيذات </h6>
                            <h2 class="mb-4 text-white">
                            
                            @php $hadback_act= ($asHadback - $canceled ) + $asTahseel @endphp
                                {{ $totalOrders2 > 0 ? number_format(($hadback_act / $totalOrders2) * 100, 1) : 0 }} %</h2>
                            {{--                        <span class="badge bg-warning"> 0% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>

            </a>

        </div>
        
        
        {{-- <div class="col-xl-3 col-sm-6">
            <a href="{{ route('partialDeliveryOrders.index') }}">

                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-briefcase-check float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">طلبات مسلمة جزئيا </h6>
                            <h2 class="mb-4 text-white">{{ $partial }}</h2>
                        </div>
                    </div>
                </div>
            </a>

        </div> --}}
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('Tahseel.index') }}">

                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">طلبات قيد التحصيل</h6>
                            <h2 class="mb-4 text-white">{{ $tahseel }}</h2>
                            {{--                        <span class="badge bg-warning"> 0% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>

            </a>

        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('hadback.index') }}">
                <div class="card mini-stat bg-primary"> 
                    <div class="card-body mini-stat-img">  
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cancel float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات قيد المرتجعات</h6>
                            <h2 class="mb-4 text-white">{{ $notDelivery }}</h2>
                            {{--                        <span class="badge bg-info"> +89% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('admin.get_tahseel') }}">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-currency-usd float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات كتحصيل</h6> 
                            <h2 class="mb-4 text-white">{{ $asTahseel }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('admin.get_hadback') }}">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cancel float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات كمرتجع</h6> 
                            <h2 class="mb-4 text-white">{{ $asHadback }}</h2>
                            {{--                        <span class="badge bg-info"> +89% </span> <span class="ms-2">From previous period</span> --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">اجندة الطلبات الجديدة</h4>

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
            events: '{{ route('admin.calender') }}',
            eventRender: function(event, element, view) {
                var sup = element.find('.fc-content')
                var con = sup.closest('span');
                var day_title = 'عدد الطلبات';

                sup.html(day_title + "<br>" + event.title + " <br> <br>" +
                    `<button style="display: none" id="${event.ids}" class="click_me btn btn-outline-danger text-white">تفاصيل</button>`
                );
                //event.title
            }
        }); //calender object

        $(document).on('click', '.click_me', function(e) {
            e.preventDefault()
            alert($(this).attr('id'))
        })
    </script>
@endsection
