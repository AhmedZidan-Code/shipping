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
                            <h3 class="page-title">Contact Us</h3>
                        </div>
                        <div class="breadcrumb-list">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li class="active"><a href="#">Contact Us</a></li>
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
                            <h2 class="title">Address</h2>
                            <p class="desc">20, Bordeshi, New York, US</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="icon-card style-four">
                        <div class="icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="content">
                            <h2 class="title">Phone</h2>
                            <p class="desc">+123 456 7890</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="icon-card style-four">
                        <div class="icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="content">
                            <h2 class="title">Email</h2>
                            <p class="desc">hello@transco.com</p>
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
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d115860.91759646642!2d89.28780421873043!3d24.84151459710791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fc54e7e81df441%3A0x27133ed921fe73f4!2sBogura!5e0!3m2!1sen!2sbd!4v1684842047185!5m2!1sen!2sbd"
                            style="border:0;" allowfullscreen="" loading="lazy"
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
