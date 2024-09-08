@extends('Delivery.layouts.inc.app')
@section('title')
    الرئيسية
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>

@endsection
@section('content')

    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <a href="{{route('myCurrentOrders.index')}}">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cube-outline float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white">الطلبات الحالية</h6>
                            <h2 class="mb-4 text-white">{{$currant}}</h2>
                            {{--                        <span class="badge bg-info"> +11% </span> <span class="ms-2">From previous period</span>--}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{route('myEndOrders.index')}}?status=total_delivery_to_customer">
                <div class="card mini-stat bg-primary">
                    <div class="card-body mini-stat-img">
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-buffer float-end"></i>
                        </div>
                        <div class="text-white">
                            <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات مسلمة كليا</h6>
                            <h2 class="mb-4 text-white">{{$total}}</h2>
                            {{--                        <span class="badge bg-danger"> -29% </span> <span class="ms-2">From previous period</span>--}}
                        </div>
                    </div>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <a href="{{route('myEndOrders.index')}}?status=partial_delivery_to_customer">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-tag-text-outline float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات مسلمة جزئيا</h6>
                        <h2 class="mb-4 text-white">{{$partial}}</h2>
                        {{--                        <span class="badge bg-warning"> 0% </span> <span class="ms-2">From previous period</span>--}}
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6">
        <a href="{{route('myEndOrders.index')}}?status=not_delivery">
            <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-briefcase-check float-end"></i>
                    </div>
                    <div class="text-white">
                        <h6 class="text-uppercase mb-3 font-size-16 text-white"> طلبات غير مسلمة </h6>
                        <h2 class="mb-4 text-white">{{$notDelivery}}</h2>
                        {{--                        <span class="badge bg-info"> +89% </span> <span class="ms-2">From previous period</span>--}}
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">اجندة الطلبات الحالية</h4>

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
            events: '{{route('delivery.calender')}}',
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

@endsection
