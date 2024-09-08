<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('traders.store')}}">
    @csrf
    <div class="row g-4">

        <div class="form-group">
            <label for="name" class="form-control-label">الصورة</label>
            <input type="file" class="dropify" name="logo" data-default-file="" accept="image/*"/>
            <span class="form-text text-muted text-center">مسموح فقط بالصيغ التالية : jpeg , jpg , png , gif , svg , webp , avif</span>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name"
                   value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الهاتف </span>
            </label>
            <!--end::Label-->
            <input id="phone" type="number" class="form-control form-control-solid" placeholder="" name="phone"
                   value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="competent_name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">  اسم المحاسب المختص</span>
            </label>
            <!--end::Label-->
            <input id="competent_name" type="text" class="form-control form-control-solid" placeholder="" name="competent_name"
                   value=""/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="competent_phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> هاتف المحاسب المختص </span>
            </label>
            <!--end::Label-->
            <input id="competent_phone" type="number" class="form-control form-control-solid" placeholder="" name="competent_phone"
                   value=""/>
        </div>




        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="user_name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">  اسم  المستخدم</span>
            </label>
            <!--end::Label-->
            <input id="user_name" type="text" class="form-control form-control-solid" placeholder="" name="user_name"
                   value=""/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="password" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">    كلمة المرور</span>
            </label>
            <!--end::Label-->
            <input id="password" type="password" class="form-control form-control-solid" placeholder="" name="password"
                   value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="fax" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">    الفاكس</span>
            </label>
            <!--end::Label-->
            <input id="fax" type="text" class="form-control form-control-solid" placeholder="" name="fax"
                   value=""/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="category_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">    القسم</span>
            </label>

            <select id="category_id" class="form-control" name="category_id">
                 <option selected disabled> اختر القسم</option>
                @foreach($categories as $category)
                     <option value="{{$category->id}}">{{$category->title}}</option>
                @endforeach

            </select>

        </div>



    </div>
</form>
<script>
    $('.dropify').dropify();

</script>
