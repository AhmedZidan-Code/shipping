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
                        <h5 class="menu-sidebar-title">معلومات التواصل </h5>
                        <div class="header-contact-info">
                            <span><i class="fa-solid fa-location-dot"></i>{{ $settings->address }}</span>
                            <span><a href="mailto:hello@transico.com"><i
                                        class="fa-solid fa-envelope"></i>{{ $settings->email }}</a> </span>
                            <span><a href="tel:{{ $settings->phones }}"><i
                                        class="fa-solid fa-phone"></i>{{ $settings->phones }}</a></span>
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
        style="background-image: url('images/section-bg/transportation-logistics.jpg')">
        <div class="page-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-wrapper">
                        <div class="page-heading">
                            <h3 class="page-title">تواصل معنا </h3>
                        </div>
                        <div class="breadcrumb-list">
                            <ul>
                                <li><a href="{{ route('web.home') }}">الرئيسية</a></li>
                                <li class="active"><a href="{{ route('web.contact') }}">تواصل معنا </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End !-->

    <!-- Contact-info Section Start !-->
    <div class="contact-info-area">
        <div class="container">
            <div class="row gx-xl-5">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="icon-card style-four">
                        <div class="icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="content">
                            <h2 class="title">العنوان</h2>
                            <p class="desc">{{ $settings->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="icon-card style-four">
                        <div class="icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="content">
                            <h2 class="title">الموبايل</h2>
                            <p class="desc">{{ $settings->phones }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="icon-card style-four">
                        <div class="icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="content">
                            <h2 class="title">البريد الاليكتروني</h2>
                            <p class="desc">{{ $settings->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact-info Section End -->
    <!-- Contact Form Section Start -->
    <div class="contact-form-area">
        <!-- Submit form Start -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="contact-title">
                        <h2>Send Us A Message</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Comment Form Start -->
                    <div class="comment-respond mt-45">
                        <form action="{{ route('web.send.contact') }}" method="post" class="comment-form"
                            id="contact-form">
                            @csrf
                            <div class="row gx-2">
                                <div class="col-xl-6">
                                    <div class="contacts-name">
                                        <input name="name" type="text" placeholder="Your name*">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="contacts-email">
                                        <input name="email" type="text" placeholder="Your email*">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="contacts-name">
                                        <input name="phone" type="text" placeholder="Your phone">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="contacts-name">
                                        <input name="subject" type="text" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="contacts-message">
                                        <textarea name="message" cols="20" rows="3" placeholder="Start writing your message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="theme-btn" type="submit">Submit Now <spna class="icon"><i
                                                class="fa-solid fa-angle-right"></i></spna></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Comment Form End -->
                </div>
            </div>
        </div>
        <!-- Submit form End -->
    </div>
    <!-- Contact Form Section End -->

    <!-- Map start -->
    <div class="contact-map-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="map-wodget">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d134227.122758292!2d30.94505956364609!3d30.80799207495849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sar!2seg!4v1736169754651!5m2!1sar!2seg"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Map end -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#contact-form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success(response.message);
                        $('#contact-form')[0].reset(); // Reset the form
                    },
                    error: function(xhr) {
                        let response = JSON.parse(xhr.responseText); // Parse the JSON response

                        if (response.errors) {
                            // Iterate over each error
                            Object.values(response.errors).forEach((errArray) => {
                                errArray.forEach((err) => {
                                    toastr.error(err);
                                });
                            });
                        } else {
                            toastr.error('حدث خطأ ما!.');
                        }
                    }
                });
            });
        });
    </script>
@endsection
