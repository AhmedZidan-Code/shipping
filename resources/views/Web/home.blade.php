@extends('Web.layouts.master')
@section('content')
    <!-- Menu Sidebar Section Start -->
    <div class="body-overlay"></div>
    <!-- Slider Section Start !-->
    <div class="slider-area style-1">
        <div class="slider-wrapper">
            @foreach ($sliders as $slider)
                <!-- single slider start -->
                <div class="single-slider-wrapper">
                    <div class="single-slider" style="background-image: url('{{ asset('storage') . '/' . $slider->cover }}')">
                        <div class="slider-overlay"></div>
                        <div class="container h-100 align-self-center">
                            <div class="row h-100">
                                <div class="col-md-6 align-self-center order-2 order-md-1">
                                    <div class="slider-content-wrapper">
                                        <div class="slider-content">
                                            {{-- <span class="slider-short-title">نحن شركة بوصلة</span> --}}
                                            <h1 class="slider-title">{{ $slider->title }}</h1>
                                            <p class="slider-short-desc">{{ $slider->description }}</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 align-self-center order-1 order-md-2">
                                    <div class="slider-image">
                                        <img src="{{ asset('storage') . '/' . $slider->image }}" alt="feature image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slider end -->
            @endforeach
        </div>
        <!-- Social Profile Start -->
        <div class="container social-share-wrapper">
            <div class="social-share">
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            </div>
        </div>
        <!-- Social Profile End -->
    </div>
    <!-- Slider Section End !-->
    <!-- Feature Area Start-->
    <div class="feature-area style-1">
        <div class="container">
            <div class="feature-area-wrapper">
                <div class="row">
                    @foreach ($features as $feature)
                        <div class="col-md-6 col-lg-3 p-lg-0">
                            <!-- single info-card start -->
                            <div class="info-card ">
                                <div class="divider"></div>
                                <div class="info-card-inner">
                                    <div class="content-wrapper">
                                        <div class="title-wrapper">
                                            <div class="icon">
                                                <img src="{{ asset('storage') . '/' . $feature->image }}" alt="support" />
                                            </div>
                                            <h2 class="title">   {{ $feature->title }}
                                            </h2>
                                        </div>
                                        <div class="content">
                                            <p class="desc"> {{ $feature->description }}
                                            </p>
                                            <!-- <div class="read-more">
                                                                    <a href="service-details.html">
                                                                        <span class="icon">
                                                                            <i class="fa-solid fa-angle-right"></i>
                                                                        </span>
                                                                        عرض المزيد
                                                                    </a>
                                                                </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single info-card End-->
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- Feature Area End !-->
    <!-- About Us Area Start !-->
    <div class="about-us-area style-1 overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-xxl-6 col-xl-5">
                    <div class="about-image-card">
                        <div class="main-img-wrapper">
                            <div class="main-img-inner">
                                <img class="tilt-animate" src="{{ asset('assets/web') }}/images/about/about-card-img.jpg"
                                    alt="about card img" />
                                <div class="img-card-wrapper image-one">
                                    <img src="{{ asset('assets/web') }}/images/icon/tropy.png" alt="about card img" />
                                </div>
                                <div class="img-card-wrapper image-two">
                                    <img src="{{ asset('assets/web') }}/images/icon/track.png" alt="about card img" />
                                </div>
                                <div class="img-card-wrapper image-three">
                                    <h1 class="year">12</h1>
                                    <h6 class="title">Year of<br />Success</h6>
                                </div>
                                <div class="img-card-wrapper image-four">
                                    <img class="tilt-animate"
                                        src="{{ asset('assets/web') }}/images/about/about-card-img-2.jpg"
                                        alt="about card img" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-7">
                    <div class="about-info-card">
                        <div class="about-info-content">
                            <div class="section-title">
                                <span class="short-title">من نحن</span>
                                <h2 class="title">قم بتوسعة أعمالك <span>من </span> خلال <span>حلول ترانسو.</span>
                                </h2>
                            </div>
                            <div class="sub-title">
                                <p>الاحترافية: نحن نوفر خدمة توصيل سريعة واحترافية لضمان وصول طلباتكم في الوقت المحدد.
                                </p>
                            </div>
                            <div class="text">
                                <p>نقدم حلول لوجستية عالمية تناسب كافة احتياجات الشحن الخاصة بك.(ابدأ الشحن). </p>
                            </div>
                            <div class="quote-text">
                                <p>تتبع الطلب: يمكن لعملائنا تتبع طلباتهم عبر تطبيقنا المخصص لمعرفة مكان وصول طلبهم في
                                    الوقت الفعلي.
                                    الجودة والأمان: نحن نولي اهتماماً كبيراً بجودة الخدمة وسلامة الطلبات أثناء عملية
                                    التوصيل.

                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us Area End !-->
    <!-- Video Popup Card section start !-->
    <div class="video-popup-area style-1 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="video-popup-card">
                        <div class="video-popup-image">
                            <img src="{{ asset('assets/web') }}/images/video-popup/popup-img-1.jpg" alt="popup image" />
                        </div>
                        <div class="video-popup-btn">
                            <a href="https://www.youtube.com/watch?v=SZEflIVnhH8" class="mfp-iframe video-play">
                                <i class="fa-solid fa-play" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Popup Card section end !-->

    <!-- counter section start -->
    <div class="counter-up-area style-1 position-relative"
        style="background-image: url('{{ asset('assets/web') }}/images/section-bg/counter-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="counter-card">
                        <div class="counter-item">
                            <div class="counter-title">
                                <h1 class="number">
                                    <span class="counter">90</span>
                                </h1>
                                <p class="title">مخزن</p>
                            </div>
                            <!-- <div class="counter-content">
                                                        <p class="text">accusa mnis iste natus error sit vol uptatem accusa nulla </p>
                                                    </div> -->

                        </div>
                        <div class="counter-item">
                            <div class="counter-title">
                                <h1 class="number">
                                    <span class="counter">230</span>
                                </h1>
                                <p class="title">بائع</p>
                            </div>
                            <!-- <div class="counter-content">
                                                        <p class="text">kccusa mnis iste natus error sit vol uptatem accusa bulla </p>
                                                    </div> -->
                        </div>
                        <div class="counter-item">
                            <div class="counter-title">
                                <h1 class="number">
                                    <span class="counter">500</span> <span>+</span>
                                </h1>
                                <p class="title">طرود ناجحة</p>
                            </div>
                            <!-- <div class="counter-content">
                                                        <p class="text">bccusa mnis iste natus error sit vol uptatem accusa pulla </p>
                                                    </div> -->
                        </div>
                        <div class="counter-item">
                            <div class="counter-title">
                                <h1 class="number">
                                    <span class="counter">10</span> <span>M</span>
                                </h1>
                                <p class="title">مندوب</p>
                            </div>
                            <!-- <div class="counter-content">
                                                        <p class="text">dccusa mnis iste natus error sit vol uptatem accusa culla </p>
                                                    </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- counter section end -->
    <!-- counter shape start -->
    <div class="squre-shape-wrapper">
        <div class="counter-squre-shape"></div>
    </div>
    <!-- counter shape End -->
    <!-- Service Area Start -->
    <div class="service-area style-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center align-items-center">
                        <span class="short-title">مراحل التخزين</span>
                        <h2 class="title">يعتبر <span>التخزين</span><br />جانبًا هامًا جدًا في <span>إدارة المخزون
                                والمواد الغذائية والسلع الأخرى</span></h2>
                        <div class="divider"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="info-card style-two">
                        <div class="overlay_img"
                            style="background-image: url({{ asset('assets/web') }}/images/ebd03a4bebc0dde638ec65fd3aecd307.png);">
                            <h2 class="title">التخزين</h2>
                        </div>

                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="info-card style-two">
                        <div class="overlay_img"
                            style="background-image: url({{ asset('assets/web') }}/images/2e09abd833fbeca67c93bcc6b473aa49.png);">
                            <h2 class="title">التغليف</h2>
                        </div>

                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="#" class="info-card style-two"
                        style="background-image: url('{{ asset('assets/web') }}/images/service/service-item-1.jpg')">
                        <div class="overlay_img">
                            <h2 class="title">شحن</h2>
                        </div>

                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Service Area End -->
    <!-- Process Step Area Start -->
    <div class="process-step-area style-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center align-items-center">
                        <span class="short-title">طرقنا المميزة في التخزين</span>
                        <h2 class="title text-white">خزّن منتجاتك <span>بذكاء </span> مع حلول تخزين
                            <br /><span>ترانسو</span>
                        </h2>
                        <div class="divider"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-5 col-xl-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="process-step">
                                <div class="icon">
                                    <div class="count">
                                        <span>01</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <h2 class="title">توصيل في 12 ساعة</h2>
                                    <p class="desc">توصيل أسرع للشحنات لجميع محافظات مصر بأسعار تناسبك.</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="process-step">
                                <div class="icon">
                                    <div class="count">
                                        <span>03</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <h2 class="title">تخزين احترافي وفريق متخصص</h2>
                                    <p class="desc">مكان مجهز و فريق مدرب لتخزين المنتجات وعملية سلسة بدون تدخل من
                                        التاجر</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="process-step">
                                <div class="icon">
                                    <div class="count">
                                        <span>05</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <h2 class="title">تنظيم المخزون</h2>
                                    <p class="desc">وضع نظام فعال لإدارة المخزون يتضمن تسجيل المداخل والمخرجات</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="align-self-end d-none d-lg-block col-lg-2 col-xl-6">
                    <div class="process-image d-none d-xl-block">
                        <img class="tilt-animate" src="{{ asset('assets/web') }}/images/section-bg/process-img.png"
                            alt="image" />
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-5 col-xl-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="process-step">
                                <div class="icon">
                                    <div class="count">
                                        <span>02</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <h2 class="title">أحدث التقنيات للتخزين

                                    </h2>
                                    <p class="desc">تتبع دقيق لمخزونك من على حسابك ببوسطة من وقت الاستلام لحد
                                        التحصيل.
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="process-step">
                                <div class="icon">
                                    <div class="count">
                                        <span>04</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <h2 class="title">سرعة التحصيل</h2>
                                    <p class="desc">تحصيل في خلال 24 ساعة من وقت وصول الشحنة الى العميل.</p>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <div class="process-step">
                                <div class="icon">
                                    <div class="count">
                                        <span>06</span>
                                    </div>
                                </div>
                                <div class="content">
                                    <h2 class="title">مراقبة الجودة</h2>
                                    <p class="desc">يشمل فحص المنتجات المخزنة بانتظام للتأكد من سلامتها وجودتها</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Process Step Area End -->
    <!-- Appointment shape start -->
    <div class="squre-shape-wrapper">
        <div class="appointment-squre-shape"></div>
    </div>
    <!-- Appointment shape end -->
    <!-- Brand Slider Area Start -->
    <div class="brand-slider-area style-1 background-skye overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="client-logo-slider-wrapper">
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-1.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-2.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-3.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-4.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-5.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-1.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-2.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-3.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-4.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="client-logo-wrapper">
                                <div class="client-logo">
                                    <img src="{{ asset('assets/web') }}/images/white-client-logo/client-5.png"
                                        alt="logo" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Brand Slider Area End -->
    <!-- Latest Posts Area Start -->
    <div class="latest-posts-area style-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center align-items-center">
                        <span class="short-title">ما قمنا به من اجلك</span>
                        <h2 class="title">تعرف علينا في <span>ايجاد</span> حلول <br /><span>التوصيل</span></h2>
                        <div class="divider"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="post-card style-three">
                        <div class="image">
                            <span class="image-overlay"></span>
                            <img src="{{ asset('assets/web') }}/images/blog/01_home_feature_post.jpg" alt="post-1" />
                        </div>
                        <div class="content">

                            <h1 class="title">
                                لدينا القدرة الكافية في تتبع الشحنات
                            </h1>

                            <div class="post-meta">
                                <span>باستخدام أحدث التكنولوجيا، بوسطة تُلبي كافة احتياجاتك اللوجستية.</span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <!-- Single-post-card start -->
                            <div class="post-card style-one">
                                <div class="image">
                                    <img src="{{ asset('assets/web') }}/images/blog/01_home_feature_post.jpg"
                                        alt="post-1" />
                                </div>
                                <div class="content">
                                    <div class="post-meta">
                                        <span><a href="#">أنواع اوردرات مختلفة.</a></span>
                                    </div>
                                    <h2 class="title">
                                        <a href="#">نوفر العديد من حلول التسليم، بما في ذلك التوصيل والتبديل
                                            والإرجاع
                                            وتحصيل النقود. ويشمل ذلك العديد من أشكال الطرود والحزم بما في ذلك الطرود ذات
                                            الأحجام المتعددة أو الضخمة أو المستندات.</a>
                                    </h2>
                                </div>
                            </div>
                            <!-- Single-post-card End-->
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <!-- Single-post-card start -->
                            <div class="post-card style-one">
                                <div class="image">
                                    <img src="{{ asset('assets/web') }}/images/blog/01_home_feature_post.jpg"
                                        alt="post-1" />
                                </div>
                                <div class="content">
                                    <div class="post-meta">
                                        <span><a href="#">إثبات التوصيل.</a></span>
                                    </div>
                                    <h2 class="title">
                                        <a href="#">للتحقق من تسليم الاوردر للعميل الصحيح، يُمكنك استخدام حل
                                            إثبات
                                            التوصيل والذي يُرسل إليك كلمة سر المرة الواحد OTP لتأكيد توصيل الطرد.</a>
                                    </h2>
                                </div>
                            </div>
                            <!-- Single-post-card End-->
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <!-- Single-post-card start -->
                            <div class="post-card style-one">
                                <div class="image">
                                    <img src="{{ asset('assets/web') }}/images/blog/01_home_feature_post.jpg"
                                        alt="post-1" />
                                </div>
                                <div class="content">
                                    <div class="post-meta">
                                        <span><a href="#">نظرة عامة على الأداء.</a></span>
                                    </div>
                                    <h2 class="title">
                                        <a href="#">يُمكنك إلقاء نظرة شاملة حول الإحصائيات الخاصة بتوصيل أعمال،
                                            والمناطق
                                            الجغرافية وتفقد الملخص المالي.</a>
                                    </h2>
                                </div>
                            </div>
                            <!-- Single-post-card End-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
