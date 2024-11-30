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
                                <span><a href="mailto:hello@transico.com"><i
                                            class="fa-solid fa-envelope"></i>hello@transico.com</a> </span>
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
                    <div class="col-xl-2 col-lg-2 col-md-6 col-6 d-flex align-items-center">
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
                    <div class="col-xl-6 col-lg-6 col-md-6 col-6 d-flex align-items-center center_div">
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
                        <div class="mobile-menu-bar d-lg-none text-end">
                            <a href="#" class="mobile-menu-toggle-btn"><i class="fal fa-bars"></i></a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6 d-flex align-items-center left_div">
                        <div class="flex_header">
                            <div class="hover_drop">
                                <div class="arrow_div">
                                    <h5>تتبع شحنتك</h5>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#de0019"
                                        class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </div>

                                <div class="box_div">
                                    <h5>تتبع شحنتك</h5>
                                    <div class="search_div">
                                        <form action="{{ route('order.tracking') }}">
                                            @csrf
                                            <input type="number" name="order" class="form-control"
                                                id="exampleFormControlInput1" placeholder="رقم التتبع">
                                            <div class="svg_div">
                                                <button type="submit" style="background-color: #e21b1b;">
                                                    <svg class="svg_search" xmlns="http://www.w3.org/2000/svg"
                                                        width="18" height="18" fill="currentColor"
                                                        class="bi bi-search" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="ref_div">
                                تسجيل الدخول
                            </a>
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
                        </div>

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
                            <span><a href="tel:+123-456-7890"><i
                                        class="fa-solid fa-phone"></i>+123-456-7890</a></span>
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
