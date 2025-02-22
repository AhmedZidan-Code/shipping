@extends('Admin.layouts.inc.app')
@section('title')
    المرتجعات
@endsection
@section('css')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('trader-payments.index') }}">

        <div class="row mb-3">

            <div class="d-flex flex-column mb-7 fv-row col-sm-4">
                <!--begin::Label-->
                <label for="agent_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> الوكيل</span>
                </label>
                <select id='agent_id' name="agent_id" style='width: 200px;'>
                    <option selected value="0">- ابحث عن الوكيل</option>
                </select>
            </div>

            <div class="col-md-4 ">
                <label for="fromDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> من تاريخ </span>

                </label>
                <input type="date" id="fromDate" value="{{ request('fromDate') }}" name="fromDate"
                    class="showBonds form-control">

            </div>
            <div class="col-md-4">
                <label for="toDate" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                    <span class="required mr-1"> إلى تاريخ </span>

                </label>
                <input type="date" id="toDate" value="{{ request('toDate') }}" name="toDate"
                    class="showBonds form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary my-4">بحث</button>
            </div>
        </div>

    </form>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"> تسديدات الوكلاء</h5>

            <div>
                <button id="addBtn" class="btn btn-primary">اضافة تسديد</button>
            </div>

        </div>
        <div class="card-body">
            <table id="table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الوكيل</th>
                        <th> التاريخ</th>
                        <th> النوع</th>
                        <th>المبلغ</th>
                        <th>نقدي</th>
                        <th>غير نقدي</th>
                        <th>ملاحظات</th>
                        <th>الاجراءات</th>
                    </tr>

            </table>

        </div>
        <div class="modal fade" id="Modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content" id="modalContent">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2><span id="operationType"></span> تسديدات الوكلاء </h2>
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
                    data: 'agent.name',
                    name: 'agent.name'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'cash',
                    name: 'cash'
                },
                {
                    data: 'cheque',
                    name: 'cheque'
                },
                {
                    data: 'notes',
                    name: 'notes'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
        </script>
        @include('Admin.layouts.inc.ajax', ['url' => 'agent-payments'])

        <script>
            $(document).on('change', '.showBonds', function() {
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                var agent_id = $('#agent_id').val();

                var url = "{{ route('agent-payments.index') }}";
                url = url + "?-=-";
                if (fromDate != null) {
                    url = url + "&&fromDate=" + fromDate;
                }
                if (toDate != null) {
                    url = url + "&&toDate=" + toDate;
                }
                if (agent_id != null) {
                    url = url + "&&agent_id=" + agent_id;
                }
                // window.location.href = url;
            })
        </script>

        <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
        <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

        <script>
            (function() {

                $("#agent_id").select2({
                    placeholder: 'Channel...',
                    // width: '350px',
                    allowClear: true,
                    ajax: {
                        url: '{{ route('admin.getAgents') }}',
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
                        $("#trader_modal_id").select2({
                            placeholder: 'Channel...',
                            allowClear: true,
                            dropdownParent: $('#Modal'), // Attach the dropdown to the modal
                            ajax: {
                                url: '{{ route('admin.getAgents') }}',
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    return {
                                        term: params.term || '',
                                        page: params.page || 1
                                    };
                                },
                                cache: true
                            }
                        });
                    }, 1500); //// 2000 milliseconds = 2 seconds

                });
            });
        </script>
    @endsection
