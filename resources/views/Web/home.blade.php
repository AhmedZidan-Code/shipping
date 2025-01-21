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
                                        <img src="{{ asset('storage') . '/' . $slider->image ?? '' }}"
                                            alt="feature image" />
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
                <a href="{{ $settings->youtube }}"><i class="fa-brands fa-youtube"></i></a>
                <a href="{{ $settings->linkedin }}"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="{{ $settings->twitter }}"><i class="fa-brands fa-twitter"></i></a>
                <a href="{{ $settings->facebook }}"><i class="fa-brands fa-facebook-f"></i></a>
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
                                                <img src="{{ asset('storage') . '/' . $feature->image ?? '' }}"
                                                    alt="support" />
                                            </div>
                                            <h2 class="title"> {{ $feature->title }}
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
                            <img src="{{ asset('storage') . '/' . $video->image ?? '' }}" alt="popup image" />
                        </div>
                        <div class="video-popup-btn">
                            <a href="{{ asset('storage') . '/' . $video->video ?? '' }}" class="mfp-iframe video-play">
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
                        @foreach ($statistics as $statistic)
                            <div class="counter-item">
                                <div class="counter-title">
                                    <h1 class="number">
                                        <span class="counter">{{ $statistic->value }}</span>
                                    </h1>
                                    <p class="title">{{ $statistic->title }}</p>
                                </div>
                                <!-- <div class="counter-content">
                                                                                    <p class="text">accusa mnis iste natus error sit vol uptatem accusa nulla </p>
                                                                                </div> -->

                            </div>
                        @endforeach

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
                @foreach ($processes as $process)
                    <div class="col-md-6 col-lg-4">
                        <a href="#" class="info-card style-two">
                            <div class="overlay_img"
                                style="background-image: url({{ asset('storage') . '/' . $process->image ?? '' }});">
                                <h2 class="title">{{ $process->title }}</h2>
                            </div>

                        </a>
                    </div>
                @endforeach

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
                        @foreach ($services as $k => $service)
                            @if (++$k % 2 != 0)
                                <div class="col-12">
                                    <div class="process-step">
                                        <div class="icon">
                                            <div class="count">
                                                <span>0{{ ++$k }}</span>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h2 class="title">{{ $service->title }}</h2>
                                            <p class="desc">{{ $service->description }}</p>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endforeach
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
                        @foreach ($services as $k => $service)
                            @if (++$k % 2 == 0)
                                <div class="col-12">
                                    <div class="process-step">
                                        <div class="icon">
                                            <div class="count">
                                                <span>0{{ ++$k }}</span>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h2 class="title">{{ $service->title }}

                                            </h2>
                                            <p class="desc">{{ $service->description }}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        @endforeach
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
