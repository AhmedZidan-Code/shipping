@extends('Web.layouts.master')
@section('styles')
@endsection
@section('content')
    <!-- Menu Sidebar Section Start -->
    <div class="menu-sidebar-area">
        <div class="menu-sidebar-wrapper">
            <div class="menu-sidebar-close">
                <button class="menu-sidebar-close-btn" id="menu_sidebar_close_btn">
                    <i class="fal fa-times"></i>
                </button>
            </div>
            <div class="menu-sidebar-content">
                <div class="menu-sidebar-logo">
                    <a href="index.html">
                        <img src="{{ asset('assets/web') }}/images/logo/logo-2.png" alt="logo" />
                    </a>
                </div>
                <div class="mobile-nav-menu"></div>
                <div class="menu-sidebar-content">
                    <div class="menu-sidebar-single-widget">
                        <h5 class="menu-sidebar-title">Contact Info</h5>
                        <div class="header-contact-info">
                            <span><i class="fa-solid fa-location-dot"></i>20, Bordeshi, New York, US</span>
                            <span><a href="mailto:hello@transico.com"><i
                                        class="fa-solid fa-envelope"></i>hello@transico.com</a>
                            </span>
                            <span><a href="tel:+123-456-7890"><i class="fa-solid fa-phone"></i>+123-456-7890</a></span>
                        </div>
                        <div class="social-profile">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu Sidebar Section Start -->
    <div class="body-overlay"></div>

    <!-- Page Header Start !-->
    <div class="page-breadcrumb-area page-bg"
        style="background-image: url('{{ asset('assets/web') }}/images/section-bg/transportation-logistics.jpg')">
        <div class="page-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-wrapper">
                        <div class="page-heading">
                            <h3 class="page-title">من نحن</h3>
                        </div>
                        {{-- <div class="breadcrumb-list">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li class="active"><a href="#">About</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End !-->

    <!-- About Us Area start !-->
    <div class="about-us-area style-2 overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-xxl-6 col-xl-5">
                    <div class="about-image-card style-two">
                        <div class="main-img-wrapper">
                            <div class="main-img-inner">
                                <img class="tilt-animate"
                                    src="{{ asset('assets/web') }}/images/about/about-card-2-img-1.jpg"
                                    alt="about card img" />
                                <div class="img-card-wrapper image-three">
                                    <h1 class="year">7k</h1>
                                    <h6 class="title">Product<br />Delivered</h6>
                                </div>
                                <div class="img-card-wrapper image-four">
                                    <img src="{{ asset('assets/web') }}/images/shape/about-image-card-2-img-2.png"
                                        alt="about card img" />
                                </div>
                                <div class="img-card-wrapper image-five">
                                    <img class="tilt-animate" src="{{ asset('storage') . '/' . $about->image }}"
                                        alt="about card img" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-7">
                    <div class="about-info-card style-two ">
                        <div class="about-info-content">
                            <div class="section-title">
                                <span class="short-title">عن بوصلة</span>
                                <h2 class="title"> <span>{{ $about->title }}</span></h2>
                            </div>
                            <div class="text">
                                <p>{{ $about->description }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us Area End !-->
    <!-- Counter Up Area Start -->
    <div class="counter-up-area style-3 position-relative background-blue"
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
                                {{-- <div class="counter-content">
                                <p class="text">accusa mnis iste natus error sit vol uptatem accusa nulla </p>
                            </div> --}}

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Counter Up Area End -->
    <!-- FAQ Area Start -->
    <div class="faq-area style-3">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="section-title">
                        <span class="short-title">Frequently Asked Questions</span>
                        <h2 class="title">The <span>Progressive</span> & <span>Flexible </span> <br>Transport coverage
                        </h2>
                        <p class="text mt-30">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                            eu fugi atmnis ist met, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                            when the musics over turn off the light</p>
                    </div>

                    <nav>
                        <ul class="nav-tab mb-30" id="nav-tab" role="tablist">
                            <li class="active" id="nav-tab1" data-bs-toggle="tab" data-bs-target="#nav-tab1_item"
                                role="tab" aria-controls="nav-tab1_item" aria-selected="true">Our Mission</li>
                            <li class="" id="nav-tab2" data-bs-toggle="tab" data-bs-target="#nav-tab2_item"
                                role="tab" aria-controls="nav-tab2_item" aria-selected="false">Our Vission</li>
                            <li class="" id="nav-tab3" data-bs-toggle="tab" data-bs-target="#nav-tab3_item"
                                role="tab" aria-controls="nav-tab3_item" aria-selected="false">Our Principle</li>
                        </ul>
                    </nav>
                    <div class="tab-content tab-content-wrapper" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-tab1_item" role="tabpanel"
                            aria-labelledby="nav-tab1" tabindex="0">
                            <div class="row">
                                <div class="col-lg-7 col-sm-6 order-sm-1 order-2">
                                    <p>Evsed do eiusmod tempor incididunt ut lab ore when the musics over turn</p>
                                    <p>Kobita off the light when the musics over turn off the light said by JIm Morrison
                                        tumi sopno charini
                                        hoye khobor nio pa.</p>
                                </div>
                                <div class="col-lg-5 col-sm-6 order-sm-2 order-1">
                                    <div class="image">
                                        <img src="{{ asset('assets/web') }}/images/about/attractive.jpg"
                                            alt="attractive" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-tab2_item" role="tabpanel" aria-labelledby="nav-tab2"
                            tabindex="0">
                            <div class="row">
                                <div class="col-lg-7 col-sm-6 order-sm-1 order-2">
                                    <p>Mvsed do eiusmod tempor incididunt ut lab ore when the musics over turn</p>
                                    <p>Yobita off the light when the musics over turn off the light said by JIm Morrison
                                        tumi sopno charini
                                        hoye khobor nio da.</p>
                                </div>
                                <div class="col-lg-5 col-sm-6 order-sm-2 order-1">
                                    <div class="image">
                                        <img src="{{ asset('assets/web') }}/images/about/our-vission.jpg"
                                            alt="vission" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-tab3_item" role="tabpanel" aria-labelledby="nav-tab3"
                            tabindex="0">
                            <div class="row">
                                <div class="col-lg-7 col-sm-6 order-sm-1 order-2">
                                    <p>Dvsed do eiusmod tempor incididunt ut lab ore when the musics over turn</p>
                                    <p>Qobita off the light when the musics over turn off the light said by JIm Morrison
                                        tumi sopno charini
                                        hoye khobor nio la.</p>
                                </div>
                                <div class="col-lg-5 col-sm-6 order-sm-2 order-1">
                                    <div class="image">
                                        <img src="{{ asset('assets/web') }}/images/about/principle.jpg"
                                            alt="principle" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="video-popup-card style-three">
                        <div class="video-popup-image">
                            <img src="{{ asset('assets/web') }}/images/about/04_about_faq.jpg" alt="popup image">
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
    <!-- FAQ Area End -->


    <!-- Team Member Area Start -->
    <div class="team-slider-area style-1 overflow-hidden">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center align-items-center mb-70">
                        <span class="short-title">Team Members</span>
                        <h2 class="title">The <span>Best</span> & <span>Skilled </span>People <br>Together</h2>
                        <div class="divider"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="team-member-slider-wrapper" id="team_slider_wrapper">
                    @foreach ($members as $member)
                        <div>
                            <div class="team-member-card">
                                <div class="image">
                                    <img src="{{ asset('storage') . '/' . $member->image }}" alt="team-member" />
                                </div>
                                <div class="content-wrapper">
                                    <div class="content">
                                        <h2 class="title">{{ $member->name }}</h2>
                                        <p class="desc">{{ $member->job_title }}</p>
                                    </div>
                                    <div class="social">
                                        <a href="{{ $member->facebook_profile }}"><i
                                                class="fa-brands fa-facebook-f"></i></a>
                                        <a href="{{ $member->twitter_profile }}"><i class="fa-brands fa-twitter"></i></a>
                                        <a href="{{ $member->linkedin_profile }}"><i
                                                class="fa-brands fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- Team Member Area End -->
    <!-- Testimonial Area Start -->
    <div class="testimonial-slider-area style-1 overflow-hidden background-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 pr-0">
                    <div class="section-title mb-50">
                        <span class="short-title">Testimonials</span>
                        <h2 class="title">What <span>Clients</span> Say <br /> About<span>Us </span></h2>
                        <p class="text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                            fugiatmnis iste natus error sit voluptatem accusa mnis</p>
                    </div>
                    <div class="testimonial-slider-arrow">
                        <button type='button' class="testimonial-arrow-btn" id="trigger_testimonial_prev"><i
                                class='fa-solid fa-angle-left'></i></button>
                        <button type='button' class="testimonial-arrow-btn" id="trigger_testimonial_next"><i
                                class='fa-solid fa-angle-right'></i></button>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 p-0">
                    <div class="testimonial-slider-wrapper" id="testimonial_two">
                        <div>
                            <div class="testimonial-card style-two">
                                <div class="icon">
                                    <img src="{{ asset('assets/web') }}/images/icon/testimonial-quotation-2.png"
                                        alt="testimonial" />
                                </div>
                                <div class="content-wrapper">
                                    <div class="content">
                                        <p class="text">
                                            Kenim ad minim veniam quis nostrud exe rcitati oen ullamco labor is nisi ut
                                            aliq uip ex ea comm odo
                                            cons equa uis aute
                                            iruoesre trud exeon ulla
                                        </p>
                                    </div>
                                    <div class="meta-user">
                                        <div class="user-info">
                                            <div class="image">
                                                <img src="{{ asset('assets/web') }}/images/testimonial/closse-up.png"
                                                    alt="user" />
                                            </div>
                                            <div class="info">
                                                <h2>Mike Peter</h2>
                                                <p>Journalist</p>
                                            </div>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('assets/web') }}/images/icon/testimonial-quotation.png"
                                                alt="testimonial" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="testimonial-card style-two">
                                <div class="icon">
                                    <img src="{{ asset('assets/web') }}/images/icon/testimonial-quotation-2.png"
                                        alt="testimonial" />
                                </div>
                                <div class="content-wrapper">
                                    <div class="content">
                                        <p class="text">
                                            Kenim ad minim veniam quis nostrud exe rcitati oen ullamco labor is nisi ut
                                            aliq uip ex ea comm odo
                                            cons equa uis aute
                                            iruoesre trud exeon ulla
                                        </p>
                                    </div>
                                    <div class="meta-user">
                                        <div class="user-info">
                                            <div class="image">
                                                <img src="{{ asset('assets/web') }}/images/testimonial/meta-user.png"
                                                    alt="user" />
                                            </div>
                                            <div class="info">
                                                <h2>Jewel Khan</h2>
                                                <p>Traveller</p>
                                            </div>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('assets/web') }}/images/icon/testimonial-quotation.png"
                                                alt="testimonial" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="testimonial-card style-two">
                                <div class="icon">
                                    <img src="{{ asset('assets/web') }}/images/icon/testimonial-quotation-2.png"
                                        alt="testimonial" />
                                </div>
                                <div class="content-wrapper">
                                    <div class="content">
                                        <p class="text">
                                            Kenim ad minim veniam quis nostrud exe rcitati oen ullamco labor is nisi ut
                                            aliq uip ex ea comm odo
                                            cons equa uis aute
                                            iruoesre trud exeon ulla
                                        </p>
                                    </div>
                                    <div class="meta-user">
                                        <div class="user-info">
                                            <div class="image">
                                                <img src="{{ asset('assets/web') }}/images/testimonial/pleasant-meta.png"
                                                    alt="user" />
                                            </div>
                                            <div class="info">
                                                <h2>Nayna Eva</h2>
                                                <p>Traveller</p>
                                            </div>
                                        </div>
                                        <div class="icon">
                                            <img src="{{ asset('assets/web') }}/images/icon/testimonial-quotation.png"
                                                alt="testimonial" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial Area End -->

    <!-- Brand Logo Area Start -->
    <div class="brand-area style-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center align-items-center mb-50">
                        <span class="short-title">Partners</span>
                        <h2 class="title">We Worked with<br /><span>Top </span> <span>Brands</span> </h2>
                        <div class="divider"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="client-wrapper">
                        <div class="client-logo-wrapper style-two">
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_1.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_2.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_3.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_4.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_5.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_6.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_5.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_4.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_3.png"
                                    alt="logo" />
                            </div>
                            <div class="client-logo">
                                <img src="{{ asset('assets/web') }}/images/client-partner/04_about_client_2.png"
                                    alt="logo" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Brand Logo Area End -->
@endsection
