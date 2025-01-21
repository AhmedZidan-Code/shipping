<!doctype html>
<html class="no-js" lang="">


<!-- Mirrored from affixtheme.com/html/xmee/demo-rtl/login-34.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 24 Nov 2024 09:03:27 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>تسجيل الدخول</title>
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/web/auth') }}/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/auth') }}/css/bootstrap-rtl.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/auth') }}/css/fontawesome-all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/auth') }}/font/flaticon.css">
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400..800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/auth') }}/style.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div id="preloader" class="preloader">
        <div class='inner'>
            <div class='line1'></div>
            <div class='line2'></div>
            <div class='line3'></div>
        </div>
    </div>
    <section class="fxt-template-animation fxt-template-layout34"
        data-bg-image="{{ asset('assets/web/auth') }}/img/elements/bg1.png">
        <div class="fxt-shape">
            <div class="fxt-transformX-L-50 fxt-transition-delay-1">
                <img src="{{ asset('assets/web/auth') }}/img/elements/shape1.png" alt="Shape">
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="fxt-column-wrap justify-content-between">

                        <div class="flex-div">

                            <div class="two_div">
                                <div class="fxt-transformX-L-50 fxt-transition-delay-3">
                                    <a href="login-34.html" class="fxt-logo"><img
                                            src="{{ asset('assets/web/auth') }}/img/logo-2.png" alt="Logo"></a>
                                </div>

                                <div class="fxt-transformX-L-50 fxt-transition-delay-5">
                                    <div class="fxt-middle-content">
                                        <h1 class="fxt-main-title">قم بتسجيل الدخول لإعادة الشحن المباشر</h1>
                                        <div class="fxt-switcher-description1">إذا لم يكن لديك حساب يمكنك ذلك<a
                                                href="register-34.html" class="fxt-switcher-text ms-2">انشي حساب</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="truck_div">
                                <img src="{{ asset('assets/web/auth') }}/img/drive2.png" alt="Animated Image">
                            </div>
                        </div>




                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="fxt-column-wrap justify-content-center">
                        <div class="fxt-form">
                            <h2>تسجيل الدخول إلى حسابك</h2>
                            <form method="POST" id="form">
                                @csrf
                                <div class="form-group">
                                    <input type="email" id="user_name" class="form-control" name="user_name"
                                        placeholder="البريد الالكتروني  " required="required">

                                </div>

                                <div class="form-group">
                                    <input id="password" type="password" class="form-control" name="password"
                                        placeholder="********" required="required">
                                    <i toggle="#password"
                                        class="fa fa-fw fa-eye toggle-password field-icon log_eye"></i>
                                </div>
                                <div class="form-group">
                                    <div class="fxt-switcher-description2 text-right">
                                        <a href="forgot-password-34.html" class="fxt-switcher-text">استعادة
                                            كلمة المرور</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="fxt-btn-fill" id="submit">تسجيل الدخول</button>
                                </div>
                            </form>
                        </div>
                        <div class="fxt-style-line">
                            <span>او تواصل معنا من خلال</span>
                        </div>
                        <ul class="fxt-socials">
                            <li class="fxt-google">
                                <a href="#" title="google"><i class="fab fa-google-plus-g"></i></a>
                            </li>
                            <li class="fxt-apple">
                                <a href="#" title="apple"><i class="fab fa-apple"></i></a>
                            </li>
                            <li class="fxt-facebook">
                                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- jquery-->
    <script src="{{ asset('assets/web/auth') }}/js/jquery.min.js"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/web/auth') }}/js/bootstrap.min.js"></script>
    <!-- Imagesloaded js -->
    <script src="{{ asset('assets/web/auth') }}/js/imagesloaded.pkgd.min.js"></script>
    <!-- Validator js -->
    <script src="{{ asset('assets/web/auth') }}/js/validator.min.js"></script>
    <!-- Custom Js -->
    <script src="{{ asset('assets/web/auth') }}/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#submit").on("click", function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('doLogin') }}",
                    data: $('#form').serialize(),
                    success: function(response) {

                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.href = response.redirect_url;
                        }, 1000);

                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            console.log(errors);
                            $.each(errors, function(field, messages) {
                                var $input = $(`[name="${field}"]`);
                                $input.addClass("is-invalid");
                                if (!$input.next(".invalid-feedback")
                                    .length) {
                                    $input.after(
                                        `<div class="invalid-feedback">${messages[0]}</div>`
                                    );
                                } else {
                                    $input.next(".invalid-feedback")
                                        .html(messages[0]);
                                }
                            });
                        }

                        if (xhr.status === 405) {
                            toastr.error(xhr.responseJSON.message);

                        }
                    }
                });

            });

            function clearErrors() {
                // Remove previous error messages
                $(".form-control").removeClass("is-invalid");
                $(".invalid-feedback").remove();
            }
        });
    </script>
</body>


<!-- Mirrored from affixtheme.com/html/xmee/demo-rtl/login-34.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 24 Nov 2024 09:03:32 GMT -->

</html>
