<script src="{{ URL::asset('assets_new/datatable/feather.min.js') }}"></script>
<script src="{{ URL::asset('assets_new/datatable/datatables.min.js') }}"></script>
<link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet" />
<script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

{{-- <style>
    .dataTables_length
    {
        margin-{{get_lang()=='ar'?'right':'left'}}: 10%;
    }
</style> --}}

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ URL::asset('assets_new/js/sweet_alert.js') }}"></script>


<script>
    var loader_form = `<div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>`;
    var newUrl = location.href;


    $('#table thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#example thead');

    if (!window.hasOwnProperty("order")) {
        // order = [
        //     [0, "DESC"]
        // ];

    }
    $(function() {

        var test = $("#table").DataTable({
            processing: true,
            // pageLength: 50,
            paging: true,
            dom: 'Bfrltip',
            bLengthChange: true,
            serverSide: true,
            ajax: newUrl,
            columns: columns,
            // order: [
            //     [0, "asc"]
            // ],
            "language": <?php echo json_encode(datatable_lang()); ?>,

            "drawCallback": function(settings) {
                console.log(settings.json.rowsCount);
                console.log(settings.json.total);
                if (settings.json && settings.json.rowsCount) {
                    $('#rows-count').html(settings.json.rowsCount);
                    $('#total').html(settings.json.total);

                }

                if (settings.json && settings.json.total_sum) {
                    console.log(settings.json.total_sum);

                    $('#total_sum').html(settings.json.total_sum); // Update total sum
                }
                if (settings.json && settings.json.total) {

                    $('#total').html(settings.json.total); // Update total sum
                }

                $('#ahmed').html(settings.json.total2);
                $('#orders_count').html(settings.json.orders_count);
                //do whatever  
            },

            // "language": {
            //     paginate: {
            //         previous: "<i class='simple-icon-arrow-left'></i>",
            //         next: "<i class='simple-icon-arrow-right'></i>"
            //     },
            //     "sProcessing": "جاري التحميل ..",
            //     "sLengthMenu": "اظهار _MENU_ سجل",
            //     "sZeroRecords": "لا يوجد نتائج",
            //     "sInfo": "اظهار _START_ الى  _END_ من _TOTAL_ سجل",
            //     "sInfoEmpty": "لا نتائج",
            //     "sInfoFiltered": "للبحث",
            //     "sSearch": "بحث :    ",
            //     "oPaginate": {
            //         "sPrevious": "السابق",
            //         "sNext": "التالي",
            //     }
            // },
            // buttons: [
            //     'colvis',
            //     'excel',
            //     'print',
            //     'copy',
            //     'csv',
            //     // 'pdf'
            // ],

            searching: true,
            destroy: true,
            info: false,


        });


    });

    $(document).on('click', '#addBtn', function() {
        $('#form-load').html(loader_form)
        $('#operationType').text('{{ trans('admin.add') }}');
        // Use AJAX to handle loading and error checking
        $.ajax({
            url: "{{ Route::has("$url.create") ? route("$url.create") : '' }}",
            type: 'GET',
            success: function(data) {
                $('#Modal').modal('show')
                $('#form-load').html(data); // Load form if request is successful
            },
            error: function(xhr) {
                if (xhr.status === 403) {
                    toastr.error('You are not authorized to perform this action.',
                        'Unauthorized');
                } else {
                    toastr.error(
                        'An error occurred while loading the form. Please try again.',
                        'Error');
                }
            }
        });
    });

    $(document).on('submit', "#form-load > #form", function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        var url = $('#form-load > form').attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function() {


                $('#submit').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                    ' ></span> <span style="margin-left: 4px;">{{ trans('admin.working') }}</span>'
                ).attr('disabled', true);
                $('#form-load').append(loader_form)
                $('#form-load > form').hide()
            },
            complete: function() {},
            success: function(data) {


                window.setTimeout(function() {
                    $('#submit').html('{{ trans('admin.submit') }}').attr('disabled',
                        false);

                    if (data.code == 200) {
                        toastr.success(data.message)
                        $('#Modal').modal('hide')
                        $('#form-load > form').remove()
                        $('#table').DataTable().ajax.reload(null, false);
                    } else {
                        $('#form-load > .linear-background').hide(loader_form)
                        $('#form-load > form').show()
                        toastr.error(data.message)
                    }
                }, 1000);

                get_result();
                $('#Modal').modal('hide');
                $('.overlay-class').hide();

            },
            error: function(data) {


                $('#form-load > .linear-background').hide(loader_form)
                $('#submit').html('{{ trans('admin.submit') }}').attr('disabled', false);
                $('#form-load > form').show()
                if (data.status === 500) {
                    toastr.error('{{ trans('admin.error') }}')
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
                } else {

                    toastr.error(data.message)
                }

            }, //end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });
    $(document).on('click', '.delete', function() {
        var id = $(this).data('id');
        swal.fire({
            title: "{{ trans('admin.submit delete') }}",
            text: "{{ trans('admin.delete text') }}",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{ trans('admin.submit') }}",
            cancelButtonText: "{{ trans('admin.cancel') }}",
            okButtonText: "{{ trans('admin.submit') }}",
            closeOnConfirm: false
        }).then((result) => {
            if (!result.isConfirmed) {
                return true;
            }


            var url = '{{ route("$url.destroy", ':id') }}';
            url = url.replace(':id', id)
            $.ajax({
                url: url,
                type: 'DELETE',
                beforeSend: function() {
                    $('.loader-ajax').show()

                },
                success: function(data) {

                    window.setTimeout(function() {
                        $('.loader-ajax').hide()
                        if (data.code == 200) {
                            toastr.success(data.message)
                            $('#table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error('{{ trans('admin.error') }}')
                        }

                    }, 1000);
                },
                error: function(data) {
                    $('.loader-ajax').hide()
                    if (data.status === 500) {
                        toastr.error('{{ trans('admin.error') }}')
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
                    if (data.status === 403) {
                        toastr.error('You are not authorized to perform this action.',
                            'Unauthorized');
                    }
                }

            });
        });
    });

    $(document).on('click', '.editBtn', function() {
        var id = $(this).data('id');
        $('#operationType').text('تعديل ');
        $('#form-load').html(loader_form)

        var url = "{{ route("$url.edit", ':id') }}";
        url = url.replace(':id', id)

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#Modal').modal('show')
                $('#form-load').html(data); // Load form if request is successful
            },
            error: function(xhr) {
                if (xhr.status === 403) {
                    toastr.error('You are not authorized to perform this action.',
                        'Unauthorized');
                } else {
                    toastr.error(
                        'An error occurred while loading the form. Please try again.',
                        'Error');
                }
            }
        });


    });
</script>
