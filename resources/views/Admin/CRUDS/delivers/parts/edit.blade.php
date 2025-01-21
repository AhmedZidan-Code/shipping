<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('delivers.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">



        <div class="form-group">
            <label for="name" class="form-control-label">الصورة</label>
            <input type="file" class="dropify" name="image" data-default-file="{{get_file($row->image)}}" accept="image/*"/>
            <span class="form-text text-muted text-center">مسموح فقط بالصيغ التالية : jpeg , jpg , png , gif , svg , webp , avif</span>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name"
                   value="{{$row->name}}"/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">البريد الالكتروني</span>
            </label>
            <!--end::Label-->
            <input id="email" type="email" class="form-control form-control-solid" placeholder="" name="email"
                   value="{{$row->email}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone1" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الهاتف الاول</span>
            </label>
            <!--end::Label-->
            <input id="phone1" type="number" class="form-control form-control-solid" placeholder="" name="phone1"
                   value="{{$row->phone1}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone2" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الهاتف الثاني</span>
            </label>
            <!--end::Label-->
            <input id="phone2" type="number" class="form-control form-control-solid" placeholder="" name="phone2"
                   value="{{$row->phone2}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="whatsapp" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">  الواتساب</span>
            </label>
            <!--end::Label-->
            <input id="whatsapp" type="text" class="form-control form-control-solid" placeholder="" name="whatsapp"
                   value="{{$row->whatsapp}}"/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="user_name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">  اسم  المستخدم</span>
            </label>
            <!--end::Label-->
            <input id="user_name" type="text" class="form-control form-control-solid" placeholder="" name="user_name"
                   value="{{$row->user_name}}"/>
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
            
            <option value="{{ $key }}" <?php if($key == $row->type_paid) echo 'selected' ;?>  > {{ $value }} </option>
            @endforeach
            </select>
           
        </div>
        
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
             <label for="password" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> المرتب </span>
            </label>
            <input id="salary" type="text" class="form-control form-control-solid" placeholder="" name="salary"  value="{{$row->salary}}"/>
                  
        </div>
        
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
             <label for="password" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> العموله </span>
            </label>
            <input id="commission" type="text" class="form-control form-control-solid" placeholder="" name="commission"  value="{{$row->commission}}"/>
                  
        </div>



    </div>
</form>
<script>
    $('.dropify').dropify();

</script>
