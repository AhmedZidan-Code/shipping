<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
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

                {{-- @can('عرض الرئيسية') --}}
                <li>
                    <a href="{{ route('admin.index') }}" class="waves-effect">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>
                {{-- @endcan --}}

                @can('عرض تصنيفات التجار')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('categories.index') }}">
                            <i class="fa fa-list"></i>
                            <span>تصنيفات التجار</span>
                        </a>
                    </li>
                @endcan

                @can('عرض بيانات المناديب')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fa fa-shipping-fast"></i>
                            <span> المناديب </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('delivers.index') }}"><i class="mdi mdi-album"></i>
                                    <span> بيانات المناديب</span></a></li>
                            @can('عرض طلبات المناديب')
                                <li><a href="{{ route('deliversReports.index') }}"><i class="mdi mdi-album"></i>
                                        <span>طلبات المناديب</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('عرض بيانات التجار')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fa fa-industry"></i>
                            <span> التجار </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('traders.index') }}"><i class="mdi mdi-album"></i>
                                    <span> بيانات التجار</span></a></li>
                            @can('عرض طلبات التجار')
                                <li><a href="{{ route('tradersReports.index') }}"><i class="mdi mdi-album"></i>
                                        <span>طلبات التجار</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany(['عرض المحافظات', 'عرض المدن', 'عرض أسعار الشحن'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-buffer"></i>
                            <span> اعدادات المناطق </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('عرض المحافظات')
                                <li><a href="{{ route('countries.index') }}"><i class="mdi mdi-album"></i>
                                        <span> المحافظات</span></a></li>
                            @endcan
                            @can('عرض المدن')
                                <li><a href="{{ route('provinces.index') }}"><i class="mdi mdi-album"></i>
                                        <span>المدن</span></a></li>
                            @endcan
                            @can('عرض أسعار الشحن')
                                <li><a href="{{ route('price.index') }}"><i class="mdi mdi-album"></i>
                                        <span>اسعار الشحن</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany(['عرض الطلبات', 'عرض الطلبات المحولة للمناديب', 'عرض طلبات قيد التحصيل', 'عرض الطلبات المؤجلة',
                    'عرض الشحن عالراسل', 'عرض طلبات تحت التنفيذ'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fa fa-shipping-fast"></i>
                            <span> الطلبات </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('عرض طلبات بوصلة')
                                <li><a href="{{ route('orders.index') }}"><i class="mdi mdi-album"></i>
                                        <span> طلبات بوصله</span></a></li>
                            @endcan
                            @can('عرض الطلبات المحولة للمناديب')
                                <li><a href="{{ route('deliveryConvertedOrders.index') }}"><i class="mdi mdi-album"></i>
                                        <span> الطلبات المحولة للمناديب </span></a></li>
                            @endcan
                            @can('عرض طلبات قيد التحصيل')
                                <li><a href="{{ route('Tahseel.index') }}"><i class="mdi mdi-album"></i>
                                        <span> طلبات قيد التحصيل </span></a></li>
                            @endcan
                            @can('عرض طلبات قيد المرتجعات')
                                <li><a href="{{ route('hadback.index') }}"><i class="mdi mdi-album"></i> <span> طلبات قيد
                                            المرتجعات </span></a>
                                @endcan
                                @can('عرض الطلبات المؤجلة')
                                <li><a href="{{ route('delayedOrders.index') }}"><i class="mdi mdi-album"></i>
                                        <span> الطلبات المؤجله </span></a></li>
                            @endcan
                            @can('عرض الشحن عالراسل')
                                <li><a href="{{ route('shipping_on_messanger.index') }}"><i class="mdi mdi-album"></i>
                                        <span> الشحن علي الراسل </span></a></li>
                            @endcan
                            @can('عرض طلبات تحت التنفيذ')
                                <li><a href="{{ route('under_implementation_orders.index') }}"><i class="mdi mdi-album"></i>
                                        <span>طلبات تحت التنفيذ </span></a></li>
                            @endcan
                            @can('إنشاء طلبات بوصلة')
                                <li><a href="{{ route('import.excel') }}"><i class="mdi mdi-album"></i> <span>
                                            رفع الطلبات اكسيل </span></a>
                                @endcan

                        </ul>
                    </li>
                @endcanany

                @can('عرض يومية الطلبات')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fa fa-file"></i>
                            <span> التقارير </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('todayOrdersReports.index') }}"><i class="mdi mdi-album"></i>
                                    <span>يومية الطلبات</span></a></li>
                        </ul>
                    </li>
                @endcan

                @can('عرض المستخدمين')
                    <li>
                        <a href="{{ route('admins.index') }}" class="waves-effect">
                            <i class="mdi mdi-ufo"></i>
                            <span>المستخدمين</span>
                        </a>
                    </li>
                @endcan

                @can('عرض الأدوار')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('roles.index') }}">
                            <i class="fa fa-tasks"></i>
                            <span>الادوار</span>
                        </a>
                    </li>
                @endcan

                @can('عرض الإعدادت العامة')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('settings.index') }}">
                            <i class="fa fa-cog"></i>
                            <span>الاعدادات العامة</span>
                        </a>
                    </li>
                @endcan

                @can('عرض سجل عمليات النظام')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('activities.index') }}">
                            <i class="fa fa-history"></i>
                            <span> سجل عمليات النظام</span>
                        </a>
                    </li>
                @endcan

                @canany(['عرض التحصيلات', 'عرض المرتجعات', 'عرض حسابات المندوب', 'عرض تقرير تنفيذات المندوب'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-buffer"></i>
                            <span> الحسابات </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('عرض التحصيلات')
                                <li><a href="{{ route('admin.get_tahseel') }}"><i class="mdi mdi-album"></i>
                                        <span>تم كتحصيل</span></a></li>
                            @endcan
                            @can('عرض المرتجعات')
                                <li><a href="{{ route('admin.get_hadback') }}"><i class="mdi mdi-album"></i>
                                        <span>تم كمرتجع</span></a></li>
                            @endcan
                            @can('عرض حسابات المندوب')
                                <li><a href="{{ route('mandoubReports.index') }}"><i class="mdi mdi-album"></i>
                                        <span>حسابات المندوب</span></a></li>
                            @endcan
                            @can('عرض تقرير تنفيذات المندوب')
                                <li><a href="{{ route('admin.mandoub_orders') }}"><i class="mdi mdi-album"></i>
                                        <span>تقرير تنفيذات المندوب</span></a></li>
                            @endcan
                            @can('عرض الخزينة')
                                <li><a href="{{ route('mandoub-salary.index') }}"><i class="mdi mdi-album"></i>
                                        <span>تقرير الرواتب الشهرية</span></a></li>
                            @endcan
                            @can('عرض الخزينة')
                                <li><a href="{{ route('treasury.index') }}"><i class="mdi mdi-album"></i>
                                        <span>الخزينة</span></a></li>
                            @endcan
                            @can('عرض الخزينة')
                                <li><a href="{{ route('daily-treasury.index') }}"><i class="mdi mdi-album"></i>
                                        <span>يومية الخزينة</span></a></li>
                            @endcan
                            @can('عرض الخزينة')
                                <li><a href="{{ route('detailed') }}"><i class="mdi mdi-album"></i>
                                        <span>تفاصيل يومية الخزينة</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['عرض تسديدات الوكلاء'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-buffer"></i>
                            <span> الوكلاء </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('agents.index') }}"><i class="mdi mdi-album"></i>
                                    <span> الوكلاء</span></a></li>
                            <li><a href="{{ route('agent-price.index') }}"><i class="mdi mdi-album"></i>
                                    <span> أسعار شحن الوكلاء</span></a></li>
                            <li><a href="{{ route('agent.import.excel') }}"><i class="mdi mdi-album"></i>
                                    <span>مقارنة الوكلاء</span></a></li>
                            <li><a href="{{ route('agent-payments.index') }}"><i class="mdi mdi-album"></i>
                                    <span>تسديدات الوكلاء</span></a></li>
                        </ul>
                    </li>
                @endcan
                @canany(['عرض الاعدادات الإدارية', 'عرض المصروفات'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-buffer"></i>
                            <span> الاعدادات الادارية </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('عرض الاعدادات الإدارية')
                                <li><a href="{{ route('administrative-settings.index') }}"><i class="mdi mdi-album"></i>
                                        <span> الاعدادات الادارية </span></a></li>
                            @endcan
                            @can('عرض المصروفات')
                                <li><a href="{{ route('expenses.index') }}"><i class="mdi mdi-album"></i>
                                        <span>المصروفات</span></a></li>
                            @endcan

                            @can('عرض الرصيد الافتتاحي')
                                <li><a href="{{ route('opening-balance.index') }}"><i class="mdi mdi-album"></i>
                                        <span>الرصيد الافتتاحي</span></a></li>
                            @endcan

                        </ul>
                    </li>
                @endcanany
                @can('عرض تقارير أرصدة التجار')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-buffer"></i>
                            <span> تقارير أرصدة التجار </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('trader-accounts.index') }}"><i class="mdi mdi-album"></i>
                                    <span> كشف حساب تاجر</span></a></li>
                            <li><a href="{{ route('traders-debt.index') }}"><i class="mdi mdi-album"></i>
                                    <span>مديونية التجار</span></a></li>
                        </ul>
                    </li>
                @endcan

                @can('عرض تسديدات التجار')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-buffer"></i>
                            <span> تسديدات التجار </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('trader-payments.index') }}"><i class="mdi mdi-album"></i>
                                    <span>تسديدات التجار</span></a></li>
                        </ul>
                    </li>
                @endcan
                @can('عرض تسديدات التجار')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-buffer"></i>
                            <span>  تقارير الارباح </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('company-profits.index') }}"><i class="mdi mdi-album"></i>
                                    <span> تقرير الربح العام</span></a></li>
                            <li><a href="{{ route('delivery-profits.index') }}"><i class="mdi mdi-album"></i>
                                    <span> تقرير ربح المناديب</span></a></li>
                            <li><a href="{{ route('trader-profits.index') }}"><i class="mdi mdi-album"></i>
                                    <span> تقرير ربح التجار</span></a></li>
                        </ul>
                    </li>
                @endcan
                                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-buffer"></i>
                            <span>   إدارة الموقع </span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('sliders.index') }}"><i class="mdi mdi-album"></i>
                                    <span>  السلايدر</span></a></li>
                            <li><a href="{{ route('features.index') }}"><i class="mdi mdi-album"></i>
                                    <span>  السمات</span></a></li>
                            <li><a href="{{ route('static-pages.index') }}"><i class="mdi mdi-album"></i>
                                    <span>  الصفحات الثابتة</span></a></li>
                            <li><a href="{{ route('services.index') }}"><i class="mdi mdi-album"></i>
                                    <span> الخدمات</span></a></li>
                            <li><a href="{{ route('processes.index') }}"><i class="mdi mdi-album"></i>
                                    <span>العمليات</span></a></li>
                            <li><a href="{{ route('videos.index') }}"><i class="mdi mdi-album"></i>
                                    <span>الفيديوهات</span></a></li>
                            <li><a href="{{ route('statistics.index') }}"><i class="mdi mdi-album"></i>
                                    <span>الاحصائيات</span></a></li>
                            <li><a href="{{ route('contacts.index') }}"><i class="mdi mdi-album"></i>
                                    <span>رسائل التواصل</span></a></li>
                        </ul>
                    </li>
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
