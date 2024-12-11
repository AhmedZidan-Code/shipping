<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>انشاءئ حساب</title>
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/web/auth/auth') }}/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/auth') }}/css/bootstrap-rtl.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/auth') }}/css/fontawesome-all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/auth') }}/font/flaticon.css">
    <!-- Google Web Fonts -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/css/intlTelInput.css">

    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400..800&display=swap" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/web/auth') }}/style.css">

</head>
<style>
    .iti {
        width: 100%;
    }

    .iti__arrow {
        border: none;
    }
</style>
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script> --}}

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
                <div class="col-lg-8">
                    <div class="fxt-column-wrap justify-content-between">
                        <div class="flex-div">
                            <div class="two_div">
                                <div class="fxt-transformX-L-50 fxt-transition-delay-3">
                                    <a href="login-34.html" class="fxt-logo"><img
                                            src="{{ asset('assets/web/auth') }}/img/logo-2.png" alt="Logo"></a>
                                </div>

                                <div class="fxt-transformX-L-50 fxt-transition-delay-5">
                                    <div class="fxt-middle-content">
                                        <h1 class="fxt-main-title">قم باانشاء حساب للقيام باالشحن المباشر</h1>
                                        <div class="fxt-switcher-description1">إذا لم يكن لديك حساب يمكنك ذلك<a
                                                href="{{ route('web.login') }}" class="fxt-switcher-text ms-2">تسجيل الدخول</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="truck_div">
                                <img src="{{ asset('assets/web/auth') }}/img/delviry_truck2.png" alt="Animated Image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="fxt-column-wrap justify-content-center">
                        <div class="fxt-form">
                            <h2>تسجيل الاشتراك في شركة ترانسو مصر
                            </h2>
                            <form method="POST" id="form">
                                @csrf

                                <div class="form-group">
                                    <label class="label_style">الاسم بالكامل</label>
                                    <input type="text" id="f_name" class="form-control" name="name"
                                        placeholder="الاسم بالكامل" required="required">
                                </div>
                                <div class="form-group">
                                    <label class="label_style">رقم التليفون</label>
                                    <div class="phone_div">
                                        <input id="phone" class="form-control" type="tel" name="phone"
                                            style="width: 100%">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="label_style">البريد الالكتروني</label>
                                    <input type="email" id="email" class="form-control" name="user_name"
                                        placeholder="البريد الالكتروني" required="required">
                                </div>
                                <div class="form-group">
                                    <label class="label_style">كلمة المرور</label>
                                    <input id="password" type="password" class="form-control" name="password"
                                        placeholder="********" required="required">
                                    <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                                </div>
                                <div class="form-group">
                                    <label class="label_style">تأكيد كلمة المرور</label>
                                    <input id="password_confirmation" type="password" class="form-control"
                                        name="password_confirmation" placeholder="********" required="required">
                                    <i toggle="#password_confirmation"
                                        class="fa fa-fw fa-eye toggle-password field-icon"></i>
                                </div>
                                <label class="label_style">اختر القسم</label>
                                <select class="form-control select2" name="category_id"
                                    aria-label="Default select example">
                                    <option selected disabled>القسم</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>

                                <div class="form-group">
                                    <div class="fxt-checkbox-box">
                                        <input id="checkbox1" type="checkbox" name="terms_and_conditions">
                                        <label for="checkbox1" class="ps-4">من فضلك اقرا ووافق علي <a
                                                class="terms-link" href="#">الشروط والاحكام</a></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="fxt-btn-fill" id="submit">انشاء
                                        حساب</button>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/intlTelInput.min.js"></script>

    <script>
        var phoneNumberInput = document.querySelector("#phone");
        var iti = window.intlTelInput(phoneNumberInput, {
            initialCountry: "eg",
            strictMode: true,
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/utils.js",
        });

        $(document).ready(function() {
            $("#submit").on("click", function(e) {
                e.preventDefault();
                clearErrors();
                // Get the formatted phone number from the intl-tel-input instance
                var phoneNumber = iti.getNumber();

                // Serialize the form data
                var formData = $("#form").serializeArray();

                // Re-parse the phone field to include the formatted number
                formData = formData.map(function(field) {
                    if (field.name === "phone") {
                        field.value =
                            phoneNumber; // Replace the phone field value with the formatted number
                    }
                    return field;
                });

                var serializedData = $.param(formData);

                $.ajax({
                    type: "POST",
                    url: "{{ route('doRegister') }}",
                    data: serializedData,
                    success: function(response) {
                        console.log(response);

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

    <!-- Custom Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/web/auth') }}/js/main.js"></script>
    <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
    <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve'
            });
        });
    </script>

</body>

</html>
