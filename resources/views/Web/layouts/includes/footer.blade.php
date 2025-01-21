    <!-- Newsletter Section Start-->
    <div class="subscribe-form-area style-1">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Newsletter Section Start !-->
                    <div class="subscribe-area">
                        <div class="shape-bg">
                            <img src="{{ asset('assets/web') }}/images/section-bg/subscribe-form-bg.png" alt="shape" />
                        </div>
                        <div class="triangle-shape"></div>
                        <div class="subscribe-inner-area">
                            <div class="content-wrapper">
                                <h4 class="short-title">Get regular updates</h4>
                                <h2 class="subscribe-title">Get Newsletter</h2>
                                <p class="text">Ut enim ad minim veniam, quis nostruyd</p>
                            </div>
                            <div class="subscribe-form-wrapper">
                                <div class="subscribe-form-widget">
                                    <form>
                                        <div class="mc4wp-form-fields">
                                            <div class="single-field">
                                                <input type="email" placeholder="Your email here" />
                                            </div>
                                            <button class="submit-btn" type="submit"><i
                                                    class="fa-solid fa-envelope"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Newsletter Section End !-->
                </div>
            </div>
        </div>
    </div>
    <footer class="footer bg-light-black">
        <div class="footer-sec">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <div class="footer-widget-info">
                                <div class="footer-logo">
                                    <a href="index.html"><img src="{{ asset('storage/uploads/' . $settings->logo_footer) }}"
                                            alt="Footer Logo" /></a>
                                </div>
                                <div class="footer-widget-contact">
                                    <div class="footer-contact">
                                        <ul>
                                            <li>
                                                <div class="contact-icon">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                </div>
                                                <div class="contact-text">
                                                    <span>{{ $settings->address }}</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="contact-icon">
                                                    <i class="fa-light fa-envelope"></i>
                                                </div>
                                                <div class="contact-text">
                                                    <a
                                                        href="mailto:hello@transico.com"><span>{{ $settings->email }}</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="contact-icon">
                                                    <i class="fa-solid fa-phone"></i>
                                                </div>
                                                <div class="contact-text">
                                                    <span>{{ $settings->phones }}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="social-profile">
                                    <a href="{{ $settings->facebook ?? '#' }}" target="_blank"><i
                                            class="fa-brands fa-facebook-f"></i></a>
                                    <a href="{{ $settings->twitter ?? '#' }}" target="_blank"><i
                                            class="fa-brands fa-twitter"></i></a>
                                    <a href="{{ $settings->linkedin ?? '#' }}" target="_blank"><i
                                            class="fa-brands fa-linkedin-in"></i></a>
                                    <a href="{{ $settings->youtube ?? '#' }}" target="_blank"><i
                                            class="fa-brands fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-lg-3 col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="footer-widget widget_nav_menu">
                                    <h2 class="footer-widget-title">Links</h2>
                                    <ul class="menu">
                                        <li><a href="{{ route('web.home') }}">الرئيسية</a></li>
                                        <li><a href="{{ route('web.about') }}">من نحن </a></li>
                                        <li><a href="{{ route('web.contact') }}">تواصل معنا</a></li>
                                        <li><a href="{{ route('order.tracking') }}">تتبع الشحنه</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="footer-widget widget_nav_menu">
                                    <h2 class="footer-widget-title">Help</h2>
                                    <ul>
                                        <li><a href="#">Marketing</a></li>
                                        <li><a href="#">Warehouse</a></li>
                                        <li><a href="#">Air Freight</a></li>
                                        <li><a href="#">Sea Freight</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2 class="footer-widget-title">Recent Posts</h2>
                            <div class="widget_latest_post">
                                <ul>
                                    <li>
                                        <div class="latest-post-thumb">
                                            <img src="{{ asset('assets/web') }}/images/blog/r1.jpg" alt="">
                                        </div>
                                        <div class="latest-post-desc">
                                            <span class="latest-post-meta">January 13, 2023</span>
                                            <h3 class="latest-post-title"><a href="blog-details.html">Acadian Non
                                                    Emergency Transportation</a>
                                            </h3>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="latest-post-thumb">
                                            <img src="images/blog/r2.jpg" alt="">
                                        </div>
                                        <div class="latest-post-desc">
                                            <span class="latest-post-meta">January 13, 2023</span>
                                            <h3 class="latest-post-title"><a href="blog-details.html">Can You
                                                    Transport
                                                    Furniture In Uber</a>
                                            </h3>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-2 col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2 class="footer-widget-title">Instagram Links</h2>
                            <div class="widget-instagram-feed">
                                <div class="single-instagram-feed">
                                    <img src="{{ asset('assets/web') }}/images/instagram/instagram-1.jpg"
                                        alt="instagram photo" />
                                </div>
                                <div class="single-instagram-feed">
                                    <img src="{{ asset('assets/web') }}/images/instagram/instagram-2.jpg"
                                        alt="instagram photo" />
                                </div>
                                <div class="single-instagram-feed">
                                    <img src="{{ asset('assets/web') }}/images/instagram/instagram-3.jpg"
                                        alt="instagram photo" />
                                </div>
                                <div class="single-instagram-feed">
                                    <img src="{{ asset('assets/web') }}/images/instagram/instagram-4.jpg"
                                        alt="instagram photo" />
                                </div>
                                <div class="single-instagram-feed">
                                    <img src="{{ asset('assets/web') }}/images/instagram/instagram-5.jpg"
                                        alt="instagram photo" />
                                </div>
                                <div class="single-instagram-feed">
                                    <img src="{{ asset('assets/web') }}/images/instagram/instagram-6.jpg"
                                        alt="instagram photo" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="copyright-text">
                            <p>Designed with love &copy; <a href="https://boomdevs.com/">BoomDevs</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="footer-bottom-menu">
                            <ul>
                                <li>
                                    <a href="#">Terms & Conditions</a>
                                </li>
                                <li>
                                    <a href="#">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="#">Legal</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bg">
            <img src="{{ asset('assets/web') }}/images/section-bg/footer-map-shape.png" alt="footer image" />
        </div>
    </footer>
    <!--- End Footer !-->
    <!-- Scroll Up Section Start -->
    <div id="scrollTop" class="scrollup-wrapper">
        <div class="scrollup-btn">
            <i class="fa-regular fa-angle-up"></i>
        </div>
    </div>
