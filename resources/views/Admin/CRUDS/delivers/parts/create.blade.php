<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('delivers.store')}}">
    @csrf
    <div class="row g-4">

        <div class="form-group">
            <label for="name" class="form-control-label">الصورة</label>
            <input type="file" class="dropify" name="image" data-default-file="" accept="image/*"/>
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
            <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">البريد الالكتروني</span>
            </label>
            <!--end::Label-->
            <input id="email" type="email" class="form-control form-control-solid" placeholder="" name="email"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone1" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الهاتف الاول</span>
            </label>
            <!--end::Label-->
            <input id="phone1" type="number" class="form-control form-control-solid" placeholder="" name="phone1"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone2" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الهاتف الثاني</span>
            </label>
            <!--end::Label-->
            <input id="phone2" type="number" class="form-control form-control-solid" placeholder="" name="phone2"
                   value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="whatsapp" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">  الواتساب</span>
            </label>
            <!--end::Label-->
            <input id="whatsapp" type="text" class="form-control form-control-solid" placeholder="" name="whatsapp"
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
            <label for="user_name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> طريقه استحقاق الراتب</span>
            </label>
            <!--end::Label-->
            @php $type_paid = array(1=>'راتب شهري'
            ,2=>'راتب شهري وعموله',
            3=>'عموله فقط') @endphp
            <select name="type_paid" class="form-control">
            <option value=""> اختر</option>
            @foreach($type_paid as $key=>$value)
            
            <option value="{{ $key }}"> {{ $value }} </option>
            @endforeach
            </select>
       </div>
       
       
       <div class="d-flex flex-column mb-7 fv-row col-sm-6">
             <label for="password" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> المرتب </span>
            </label>
            <input id="salary" type="text" class="form-control form-control-solid" placeholder="" name="salary"  value="0"/>
                  
        </div>
        
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
             <label for="password" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> العموله </span>
            </label>
            <input id="commission" type="text" class="form-control form-control-solid" placeholder="" name="commission"  value="0"/>
                  
        </div>
        
       
       
       


    </div>
</form>
<script>
    $('.dropify').dropify();

</script>
