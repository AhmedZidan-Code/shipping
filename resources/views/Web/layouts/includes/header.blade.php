    <!-- Preloader Start !-->
    <div id="preloader">
        <div id="preloader-status">
            <div class="loading-container">
                <div class="ball1"></div>
                <div class="ball2"></div>
                <div class="ball3"></div>
                <div class="ball4"></div>
            </div>
        </div>
    </div>
    <!-- Preloader End !-->
    <!-- Header Start !-->
    <header class="header-area">
        <!-- Header Top Start -->
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-start justify-content-lg-end ">
                        <div class="header-top-info">
                            <div class="header-contact-info">
                                <span><span class="contact-info-item"><i class="fa-solid fa-location-dot"></i>20,
                                        Bordeshi, New York,US</span></span>
                                @if(trader()->user())
                                    <span>
                                        <a href="mailto:hello@transico.com">
                                            <i class="fa-solid fa-envelope"></i> {{ trader()->user()->user_name }}
                                        </a>
                                    </span>
                                @endif

                            </div>
                            <div class="header-top-btn">
                                <a href="contact.html">Get A Quote</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Top End -->
        <!-- Header Nav Menu Start -->
        <div class="header-menu-area sticky-header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-6 d-flex align-items-center">
                        <div class="logo">
                            <a href="index.html" class="standard-logo">
                                <img src="{{ asset('assets/web') }}/images/logo/logo.png" alt="logo" />
                            </a>
                            <a href="index.html" class="sticky-logo">
                                <img src="{{ asset('assets/web') }}/images/logo/logo-2.png" alt="logo" />
                            </a>
                            <a href="index.html" class="retina-logo">
                                <img src="{{ asset('assets/web') }}/images/logo/logo-2.png" alt="logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-6 col-6 d-flex align-items-center justify-content-end">
                        <div class="menu d-inline-block">
                            <nav id="main-menu" class="main-menu">
                                <ul>
                                    <li class="dropdown active">
                                        <a href="index.html">الرئيسية</a>
                                        <ul>
                                            <li><a href="index.html">الرئيسية1</a></li>
                                            <li><a href="index-2.html">الرئيسية 2</a></li>
                                            <li><a href="index-3.html">الرئيسية 3</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="about.html">من نحن</a></li>
                                    <li class="dropdown">
                                        <a href="service.html">خدمتنا</a>
                                        <ul class="submenu">
                                            <li><a href="service.html">خدمتنا1</a></li>

                                        </ul>
                                    </li>
                                    <li><a href="pricing.html">التخزين</a></li>
                                    <li><a href="pricing.html">التسعير</a></li>

                                    <li><a href="contact.html">تواصل معنا</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Header Button Start !-->
                        <a href="tel:+123-456-7890" class="header-btn">
                            <div class="icon-wrapper">
                                <div class="icon">
                                    <img src="{{ asset('assets/web') }}/images/icon/phone.png" alt="phone" />
                                </div>
                            </div>
                            <div class="content-wrapper">
                                <span class="title">Got A Question?</span>
                                <span class="text">+123 - 456 - 7890</span>
                            </div>
                        </a>
                        <!-- Header Button Start !-->
                        <!-- Mobile Menu Toggle Button Start !-->
                        <div class="mobile-menu-bar d-lg-none text-end">
                            <a href="#" class="mobile-menu-toggle-btn"><i class="fal fa-bars"></i></a>
                        </div>
                        <!-- Mobile Menu Toggle Button End !-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Nav Menu End -->
    </header>
    <!-- Header End !-->
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
                                        class="fa-solid fa-envelope"></i>hello@transico.com</a> </span>
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
