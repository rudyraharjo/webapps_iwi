@extends('layouts.app')

@section('title', __('configuration::module.role.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('configuration::module.role.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="urlPermission" value="{{ route('role.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('configuration::module.role.sub_title') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger" onclick="ModalAddEdit(this)" data-cmd="add"
                            data-action="{{ route('role.store') }}"><i class="fa fa-plus-circle"></i>
                            {{ __('configuration::module.role.btn_create') }}</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="roleTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('configuration::module.role.table_id') }}</th>
                                <th>{{ __('configuration::module.role.table_name') }}</th>
                                <th>{{ __('configuration::module.role.table_display_name') }}</th>
                                <th>{{ __('configuration::module.role.table_description') }}</th>
                                <th>{{ __('configuration::module.role.table_created_at') }}</th>
                                <th>{{ __('configuration::module.role.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('configuration::role.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        var tableRole = $('#roleTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('role.index') }}',
            columns: [{
                    data: 'id',
                    name: 'id',
                    className: "text-left",
                    width: "40px"
                },
                {
                    data: 'name',
                    name: 'name',
                    className: "text-left"
                },
                {
                    data: 'display_name',
                    name: 'display_name',
                    className: "text-left"
                },
                {
                    data: 'description',
                    name: 'description',
                    className: "text-left"
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    className: "text-left"
                },
                {
                    data: 'tools',
                    className: "text-center",
                    width: "80px",
                    orderable: false,
                    searchable: false,
                },
            ],
        });

        $("#formRole").submit(function(e) {
            btnLoading();
            $(".btnSubmit").attr('disabled', true);
            e.preventDefault();
            const actionURl = $('#formRole').attr('action');

            $.ajax({
                url: actionURl,
                type: 'POST',
                data: new FormData($(this)[0]),
                processData: false,
                contentType: false,
                success: function success(res) {
                    if (res.success) {
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        });
                        tableRole.ajax.reload();
                        $('#modalAddEditContainer').modal('hide')
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'These credentials do not match our records'
                        });
                        for (fname in res.errors) {
                            $('input[name=' + fname + ']').addClass('is-invalid');
                            $('#error-' + fname).html(res.errors[fname]);
                        }
                    }
                },
                error: function error(res) {
                    Toast.fire({
                        icon: 'error',
                        title: res.message
                    });
                },
                complete: function complete() {
                    setTimeout(function() {
                        $(".btnSubmit").attr('disabled', false);
                    }, 700);
                    if ($("#role_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('configuration::module.role.modal_btn_update') }}");
                    } else {
                        $(".btnSubmit").html(
                            `<i class='fas fa-save'></i> {{ __('configuration::module.role.modal_btn_save') }}`);
                    }
                }
            });
        });

        $('#modalAddEditContainer').on('hidden.bs.modal', function(e) {
            $("#formRole").trigger("reset");
            $("#role_id").val("");
            $('#formRole .is-invalid').removeClass('is-invalid');
        });

        $("#name").keyup(function() {
            let Text = convertToSlug($(this).val());
            $("#name").val(Text);
        });
        // });

        function ModalAddEdit(identifier) {

            const cmd = $(identifier).data("cmd");
            const action = $(identifier).data("action");

            if (cmd == "add") {
                $('.selectric').selectric();
                $(".modal-title").html("{{ __('configuration::module.role.modal_title') }}");
                $(".btnSubmit").html(`<i class='fas fa-save'></i> {{ __('configuration::module.role.modal_btn_save') }}`);

            } else if (cmd == "edit") {
                $('.selectric').selectric('destroy');
                $(".modal-title").html("{{ __('configuration::module.role.modal_title_edit') }}");
                $("#role_id").val($(identifier).data("id"));
                $("#name").val($(identifier).data("name"));
                $("#display_name").val($(identifier).data("display_name"));
                $("#description").val($(identifier).data("description"));
                $(".btnSubmit").html("<i class='fas fa-save'></i> {{ __('configuration::module.role.modal_btn_update') }}");

                const listPermissions = $(identifier).data("permissions");

                let arrListPermissions = [];
                if (listPermissions != null || listPermissions != undefined) {
                    if (listPermissions.length > 0) {
                        listPermissions.forEach(function(v) {
                            // console.log(v);
                            arrListPermissions.push(v);
                        });
                    }
                }


                $('#permissions').val(arrListPermissions).selectric('refresh');

            }
            $('#formRole').attr('action', action);
            $('#modalAddEditContainer').appendTo('body').modal('show');
        }

        function ModalDeleteRole(identifier) {

            const idRole = $(identifier).data("id");
            const nameRole = $(identifier).data("name");
            const tokenPermission = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('configuration::module.role.modal_delete_title') }}",
                text: "{{ __('configuration::module.role.modal_delete_text') }} "+ nameRole + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('configuration::module.role.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: idRole,
                            _token: tokenPermission
                        },
                        url: actionURl,
                        success: function(res) {
                            if (res.success) {
                                tableRole.ajax.reload();
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                });
                            }
                        },
                        error: function(res) {
                            Toast.fire({
                                icon: 'error',
                                title: res.statusText
                            });
                        }
                    });
                }
            })

        }

        function convertToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        }
    </script>
@endsection
