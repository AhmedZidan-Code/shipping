<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('price.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">
   <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="from_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">التاجر</span>
            </label>

            <select id="trader_id"  name="trader_id" class="form-control">

                <option selected disabled>اختر</option>

                @foreach($traders as $trader)
                    <option value="{{$trader->id}}"  @if($row->trader_id==$trader->id) selected @endif > {{$trader->name}}</option>

                @endforeach
            </select>


        </div>

      


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="from_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">المحافظة</span>
            </label>

            <select id="govern_id"  name="govern_id" class="form-control">

                <option selected disabled>اختر المحافظة</option>

                @foreach($countries as $country)
                    <option @if($row->govern_id==$country->id) selected @endif value="{{$country->id}}" > {{$country->title}}</option>

                @endforeach
            </select>


        </div>
        
          <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">القيمه</span>
            </label>
            <!--end::Label-->
            <input id="value" required type="text" class="form-control form-control-solid" placeholder="" name="value" value="{{$row->value}}"/>
        </div>




    </div>
</form>
<script>
    $('.dropify').dropify();

</script>
