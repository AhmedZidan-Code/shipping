@extends('Admin.layouts.inc.app')
@section('title')
    الإعدادات
@endsection
@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />
@endsection

@section('page-title')
    الإعدادات العامة
@endsection

@section('breadCramp')
    breadCramp
@endsection


@section('content')
    <div class="card">
        <div class="card-header ">
            <h5 class="card-title mb-0 flex-grow-1">الاعدادات</h5>


            <form id="form" enctype="multipart/form-data" method="POST" action="{{ route('settings.store') }}">
                @csrf
                <div class="row my-4 g-4">

                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <!--begin::Label-->
                        <label for="app_name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> اسم الموقع</span>
                        </label>
                        <!--end::Label-->
                        <input id="app_name" required type="text" class="form-control form-control-solid"
                            name="app_name" value="{{ $settings->app_name }}" />
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <!--begin::Label-->
                        <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> البريد الاليكتروني</span>
                        </label>
                        <!--end::Label-->
                        <input id="email" type="email" class="form-control form-control-solid" name="email"
                            value="{{ $settings->email }}" />
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <!--begin::Label-->
                        <label for="governorate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> المحافظة</span>
                        </label>
                        <!--end::Label-->
                        <input id="governorate" type="text" class="form-control form-control-solid" name="governorate"
                            value="{{ $settings->governorate }}" />
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <!--begin::Label-->
                        <label for="phones" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> أرقام التليفونات</span>
                        </label>
                        <!--end::Label-->
                        <input id="phones" type="text" class="form-control form-control-solid" name="phones"
                            value="{{ $settings->phones }}" />
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <!--begin::Label-->
                        <label for="address" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> العنوان بالكامل</span>
                        </label>
                        <!--end::Label-->
                        <input id="address" type="text" class="form-control form-control-solid" name="address"
                            value="{{ $settings->address }}" />
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-2">
                        <!--begin::Label-->
                        <label for="lat" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> lat</span>
                        </label>
                        <!--end::Label-->
                        <input id="lat" type="text" class="form-control form-control-solid" name="lat"
                            value="{{ $settings->lat }}" />
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-2">
                        <!--begin::Label-->
                        <label for="lng" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> lng</span>
                        </label>
                        <!--end::Label-->
                        <input id="lng" type="text" class="form-control form-control-solid" name="lng"
                            value="{{ $settings->lng }}" />
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                        <!--begin::Label-->
                        <label for="facebook" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> لينك الفيس بوك</span>
                        </label>
                        <!--end::Label-->
                        <input id="facebook" type="url" class="form-control form-control-solid" name="facebook"
                            value="{{ $settings->facebook }}" />
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                        <!--begin::Label-->
                        <label for="twitter" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> لينك تويتر</span>
                        </label>
                        <!--end::Label-->
                        <input id="twitter" type="url" class="form-control form-control-solid" name="twitter"
                            value="{{ $settings->twitter }}" />
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                        <!--begin::Label-->
                        <label for="linkedin" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1"> لينك لينكد إن</span>
                        </label>
                        <!--end::Label-->
                        <input id="linkedin" type="url" class="form-control form-control-solid" name="linkedin"
                            value="{{ $settings->linkedin }}" />
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                        <!--begin::Label-->
                        <label for="youtube" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">لينك اليوتيوب</span>
                        </label>
                        <!--end::Label-->
                        <input id="youtube" type="url" class="form-control form-control-solid" name="youtube"
                            value="{{ $settings->youtube }}" />
                    </div>


                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <div class="form-group">
                            <label for="name" class="form-control-label fs-6 fw-bold "> اللوجو العلوي </label>
                            <input type="file" class="dropify" name="logo_header"
                                data-default-file="{{ get_file($settings->logo_header) }}" accept="image/*" />
                            <span class="form-text text-muted text-center">مسموح فقط بالصيغ التالية : jpeg , jpg , png ,
                                gif , svg , webp , avif</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <div class="form-group">
                            <label for="name" class="form-control-label fs-6 fw-bold "> اللوجو السفلي </label>
                            <input type="file" class="dropify" name="logo_footer"
                                data-default-file="{{ get_file($settings->logo_footer) }}" accept="image/*" />
                            <span class="form-text text-muted text-center">مسموح فقط بالصيغ التالية : jpeg , jpg , png ,
                                gif , svg , webp , avif</span>
                        </div>
                    </div>




                    <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                        <div class="form-group">
                            <label for="name" class="form-control-label fs-6 fw-bold "> الفيف ايكون </label>
                            <input type="file" class="dropify" name="fave_icon"
                                data-default-file="{{ get_file($settings->fave_icon) }}" accept="image/*" />
                            <span class="form-text text-muted text-center">مسموح فقط بالصيغ التالية : jpeg , jpg , png ,
                                gif , svg , webp , avif</span>
                        </div>
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <!--begin::Label-->
                        <label for="privacy_policy" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">سياسة الخصوصية</span>
                        </label>
                        <!--end::Label-->
                        <textarea name="privacy_policy" >{{ $settings->privacy_policy }}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <!--begin::Label-->
                        <label for="legal" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">  حقوق الملكية الفكرية</span>
                        </label>
                        <!--end::Label-->
                        <textarea name="legal" >{{ $settings->legal }}</textarea>
                    </div>
                    <div class="d-flex flex-column mb-7 fv-row col-sm-12">
                        <!--begin::Label-->
                        <label for="terms_and_condition" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">الشروط والاحكام</span>
                        </label>
                        <!--end::Label-->
                        <textarea name="terms_and_condition" >{{ $settings->terms_and_condition }}</textarea>
                    </div>


                    {{-- @can('التعديل علي الاعدادات العامة') --}}

                    <div class="my-4">
                        <button type="submit" class="btn btn-success"> تعديل</button>
                    </div>

                    {{-- @endcan --}}

                </div>
            </form>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script>
        document.querySelectorAll('textarea').forEach((textarea) => {
            ClassicEditor
                .create(textarea, {
                    toolbar: [
                        'heading', 'bold', 'italic', 'underline', 'strikethrough', 'link',
                        '|', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable',
                        '|', 'undo', 'redo', 'mediaEmbed', 'imageUpload', 'fontColor',
                        'fontBackgroundColor',
                        '|', 'fontSize', 'fontFamily'
                    ],
                    fontSize: {
                        options: [
                            'tiny', 'small', 'default', 'big', 'huge'
                        ],
                        supportAllValues: true
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    },
                    mediaEmbed: {
                        previewsInData: true
                    },
                })
                .then(editor => {
                    editors[textarea.name] = editor; // تخزين المحرر باستخدام اسم الحقل
                })
                .catch(error => {
                    console.error('Error initializing editor:', error);
                });
        });
    </script>

    <script>
        $('.dropify').dropify();
    </script>


    <script>
        // CKEDITOR.replace('privacy');
    </script>
    <script>
        $(document).on('submit', "form#form", function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            var url = $('#form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,

                complete: function() {},
                success: function(data) {

                    window.setTimeout(function() {

                        // $('#product-model').modal('hide')
                        if (data.code == 200) {
                            toastr.success(data.message)
                        } else {
                            toastr.error(data.message)
                        }
                    }, 1000);


                },
                error: function(data) {
                    if (data.status === 500) {
                        toastr.error('there is an error')
                    }

                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);

                        $.each(errors, function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, value) {
                                    toastr.error(value)
                                });

                            } else {

                            }
                        });
                    }
                    if (data.status == 421) {
                        toastr.error(data.message)
                    }

                }, //end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
@endsection
