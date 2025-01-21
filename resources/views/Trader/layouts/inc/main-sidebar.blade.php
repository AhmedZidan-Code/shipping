<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <!-- App Search-->
            <ul class="metismenu list-unstyled">
                <li>
                    <form class="app-search d-none d-lg-block">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="position-relative">
                            <input type="text" id="myInput" onkeyup="myFunction()" class="form-control"
                                placeholder="ابحث هنا ..." onchange="SearchP($(this))">
                            <span class="fa fa-search"></span>
                        </div>
                    </form>
                </li>
            </ul>
            <ul class="metismenu list-unstyled " id="side-menu">

                <!-- <div id="SearchArea">-->
                {{--              @can('عرض الرئيسية') --}}
                <li>
                    <a href="{{ route('trader.index') }}" class="waves-effect">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>

                {{--                <li> --}}
                {{--                    <a href="{{ route('myOrders.index') }}" class="waves-effect"> --}}
                {{--                        <i class="fas fa-shipping-fast"></i> --}}
                {{--                        <span>طلباتي</span> --}}
                {{--                    </a> --}}
                {{--                </li> --}}
                {{--                @endcan --}}




                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-shipping-fast"></i>
                        <span>  طلباتي </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('myOrders.index')}}?status=new"><i class="mdi mdi-album"></i>
                                <span> الطلبات الجديدة</span></a></li>
                        <li><a href="{{route('myOrders.index')}}?status=converted_to_delivery"><i class="mdi mdi-album"></i>
                                <span>    الطلبات المحولة  للمناديب </span></a></li>
                        <li><a href="{{route('myOrders.index')}}?status=total_delivery_to_customer"><i class="mdi mdi-album"></i> <span>   طلبات مسلمة كليا </span></a>
                        </li>
                        <li><a href="{{route('myOrders.index')}}?status=partial_delivery_to_customer"><i class="mdi mdi-album"></i> <span>   طلبات مسلمة جزئيا </span></a>
                        </li>
                        <li><a href="{{route('myOrders.index')}}?status=not_delivery"><i class="mdi mdi-album"></i> <span>   طلبات  غير مسلمة  </span></a>
                        </li>


                        <li><a href="{{route('myOrders.index')}}?status=cancel"><i class="mdi mdi-album"></i> <span>   طلبات   تم الالغاء  </span></a>
                        </li>   <li><a href="{{route('myOrders.index')}}?status=collection"><i class="mdi mdi-album"></i> <span>   طلبات   التحصيل  </span></a>
                        </li>   <li><a href="{{route('myOrders.index')}}?status=paid"><i class="mdi mdi-album"></i> <span>   طلبات   تم الدفع  </span></a>
                        </li>   <li><a href="{{route('myOrders.index')}}?status=under_implementation"><i class="mdi mdi-album"></i> <span>   طلبات   تحت التنفيذ  </span></a>
                        </li>

                    </ul>
                </li> --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-shipping-fast"></i>
                        <span> الطلبات </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('trader.trader-orders.index') }}"><i class="mdi mdi-album"></i>
                                <span> طلبات التاجر</span></a></li>
                        <li><a href="{{ route('trader.orders.index') }}"><i class="mdi mdi-album"></i>
                                <span> طلبات بوصله</span></a></li>
                        <li><a href="{{ route('trader.deliveryConvertedOrders.index') }}"><i class="mdi mdi-album"></i>
                                <span> الطلبات المحولة للمناديب </span></a></li>
                        <!--
                                <li><a href="{{ route('trader.totalDeliveryOrders.index') }}"><i class="mdi mdi-album"></i> <span>   طلبات مسلمة كليا </span></a>
                                </li>
                                <li><a href="{{ route('trader.partialDeliveryOrders.index') }}"><i class="mdi mdi-album"></i> <span>   طلبات مسلمة جزئيا </span></a>
                                </li>
                                <li><a href="{{ route('trader.notDeliveryOrders.index') }}"><i class="mdi mdi-album"></i> <span>   طلبات  غير مسلمة  </span></a>

                                </li>

                                <li><a href="{{ route('trader.cancel_orders.index') }}"><i class="mdi mdi-album"></i> <span>   طلبات  تم الالغاء </span></a>
                                </li>
                                 -->


                        <li><a href="{{ route('trader.Tahseel.index') }}"><i class="mdi mdi-album"></i> <span> طلبات قيد
                                    التحصيل </span></a>
                        <li><a href="{{ route('trader.hadback.index') }}"><i class="mdi mdi-album"></i> <span> طلبات قيد
                                    المرتجعات </span></a>
                        <li><a href="{{ route('trader.delayedOrders.index') }}"><i class="mdi mdi-album"></i> <span>
                                    الطلبات
                                    المؤجله </span></a>
                        </li>

                        <!--
                                <li><a href="{{ route('trader.collection_orders.index') }}"><i class="mdi mdi-album"></i>
                                        <span> طلبات التحصيل</span></a></li>
                                <li><a href="{{ route('trader.paid_orders.index') }}"><i class="mdi mdi-album"></i> <span>طلبات تم الدفع </span></a>
                                </li>
                                -->
                        <li class="mm-active"><a href="{{ route('trader.shipping_on_messanger.index') }}"><i
                                    class="mdi mdi-album"></i>
                                <span> الشحن علي الراسل </span></a></li>
                        <li><a href="{{ route('trader.under_implementation_orders.index') }}"><i
                                    class="mdi mdi-album"></i>
                                <span>طلبات تحت التنفيذ </span></a>
                        </li>



                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-buffer"></i>
                        <span> الحسابات </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <!--
                        <li><a href="{{ route('collection_orders.index') }}"><i class="mdi mdi-album"></i>
                                <span> التحصيل</span></a></li>
                        <li><a href="{{ route('paid_orders.index') }}"><i class="mdi mdi-album"></i> <span>الدفع </span></a>
                        </li>
                        
                        -->
                        <li><a href="{{ route('trader.get_tahseel') }}"><i class="mdi mdi-album"></i> <span> تحصيلات
                                </span></a>
                        <li><a href="{{ route('trader.get_hadback') }}"><i class="mdi mdi-album"></i> <span> مرتجعات
                                </span></a>
                        <li><a href="{{ route('trader.trader_account') }}"><i class="mdi mdi-album"></i> <span> كشف حساب
                                </span></a>
                    </ul>
                </li>

                <!--</div>-->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

<script>
    function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("side-menu");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>
