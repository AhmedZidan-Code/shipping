@extends('Admin.layouts.inc.app')
@section('title')
    المصروفات
@endsection
@section('css')
@endsection
@section('content')
    <form action="{{ route('expenses.index') }}">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="delivery_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> اختر المندوب </span>

                </label>
                <select id="delivery_data" class="delivery_data" name="delivery_id" style="width: 100%;">
                    <option selected disabled>- ابحث عن المندوب</option>
                </select>
            </div>
            <div class="col-md-3 ">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ البداية </span>

                </label>
                <input type="date" id="fromDate" value="{{ request('fromDate') }}" name="fromDate"
                    class="showBonds form-control">

            </div>
            <div class="col-md-3">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> تاريخ النهاية </span>

                </label>
                <input type="date" id="toDate" value="{{ request('toDate') }}" name="toDate"
                    class="showBonds form-control">
            </div>

            <div class="d-flex flex-column mb-7 fv-row col-sm-3">
                <!--begin::Label-->
                <label for="expense_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> فئةالصرف</span>
                </label>
                <select class="form-control" id='expense_id' name="expense_id">
                    <option selected disabled>- ابحث عن فئةالصرف</option>
                    @foreach ($expensesTypes as $type)
                        <option value="{{ $type->id }}"> {{ $type->title }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>

    </form>


    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> المصروفات</h5>

            @can('إنشاء المصروفات')
                <div>
                    <button id="addBtn" class="btn btn-primary">اضافة المصروفات</button>
                </div>
            @endcan

        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>المندوب</th>
                        <th>قيمة المصروف</th>
                        <th> فئة الصرف</th>
                        <th> تاريخ الصرف</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr style="text-align: center;">
                        <td colspan="3">الاجمالي</td>
                        <td colspan="4" id="total"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="modal fade" id="Modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content" id="modalContent">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2><span id="operationType"></span> اعدادات </h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <button class="btn btn-sm btn-icon btn-active-color-primary" type="button" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                    <!--end::Close-->
                </div>
                <!--begin::Modal body-->
                <div class="modal-body py-4" id="form-load">

                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light me-2">
                            الغاء
                        </button>
                        <button form="form" type="submit" id="submit" class="btn btn-primary">
                            <span class="indicator-label">اتمام</span>
                        </button>
                    </div>
                </div>
            </div>

            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
@endsection
@section('js')
    <script>
        var columns = [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'delivery',
                name: 'delivery'
            },
            {
                data: 'value',
                name: 'value'
            },
            {
                data: 'expense_category',
                name: 'expense_category'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];
    </script>
    @include('Admin.layouts.inc.ajax', ['url' => 'expenses'])
    <script>
        (function() {
            $("#delivery_data").select2({
                placeholder: 'Channel...',
                // width: '350px',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.getDeliveries') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
        })();
        $('#Modal').on('shown.bs.modal', function(event) {
            $(document).ready(function() {

                setTimeout(function() {
                    $(".delivery_data").select2({
                        placeholder: 'Channel...',
                        dropdownParent: $('#Modal'),
                        // width: '350px',
                        allowClear: true,
                        ajax: {
                            url: '{{ route('admin.getDeliveries') }}',
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    term: params.term || '',
                                    page: params.page || 1
                                }
                            },
                            cache: true
                        }
                    });
                }, 1500);

            });
        });
    </script>
@endsection
