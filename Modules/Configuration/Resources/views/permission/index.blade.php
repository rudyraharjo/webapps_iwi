@extends('layouts.app')

@section('title', __('configuration::module.permission.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('configuration::module.permission.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="urlPermission" value="{{ route('permission.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('configuration::module.permission.sub_title') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger" onclick="ModalPermissionAddEdit(this)"
                            data-cmd="addPermission" data-action="{{ route('permission.store') }}"><i
                                class="fa fa-save"></i>
                            {{ __('configuration::module.permission.btn_create') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="permissionTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('configuration::module.permission.table_id') }}</th>
                                <th>{{ __('configuration::module.permission.table_name') }}</th>
                                <th>{{ __('configuration::module.permission.table_display_name') }}</th>
                                <th>{{ __('configuration::module.permission.table_description') }}</th>
                                <th>{{ __('configuration::module.permission.table_created_at') }}</th>
                                <th>{{ __('configuration::module.permission.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('configuration::permission.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        var tablePermission = $('#permissionTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('permission.index') }}',
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
            // order: [[ 4, "desc" ]]
        });

        // $(document).ready(function() {

        $("#formPermission").submit(function(e) {
            e.preventDefault();
            btnLoading();
            $(".btnSubmit").attr('disabled', true);

            const actionURl = $('#formPermission').attr('action');

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
                        tablePermission.ajax.reload();
                        $('#modalPermissionContainer').modal('hide')
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
                    if ($("#permission_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('configuration::module.permission.modal_btn_update') }}"
                            );
                    } else {
                        $(".btnSubmit").html(
                            `<i class='fas fa-save'></i> {{ __('configuration::module.permission.modal_btn_save') }}`);
                    }
                }
            });
        });

        $('#modalPermissionContainer').on('hidden.bs.modal', function(e) {
            
            $("#formPermission").trigger("reset");
            $('#formPermission .is-invalid').removeClass('is-invalid');
        });

        $("#name").keyup(function() {
            let Text = convertToSlug($(this).val());
            $("#name").val(Text);
        });
        // });

        function ModalPermissionAddEdit(identifier) {

            const cmdPermission = $(identifier).data("cmd");
            const actionPermission = $(identifier).data("action");

            if (cmdPermission == "addPermission") {
                $(".modal-title").html("{{ __('configuration::module.permission.modal_title') }}");
                $(".btnSubmit").html(`<i class='fas fa-save'></i> {{ __('configuration::module.permission.modal_btn_save') }}`);
            } else if (cmdPermission == "editPermission") {
                $(".modal-title").html("{{ __('configuration::module.permission.modal_title_edit') }}");
                $("#permission_id").val($(identifier).data("id"));
                $("#name").val($(identifier).data("name"));
                $("#display_name").val($(identifier).data("display_name"));
                $("#description").val($(identifier).data("description"));
                $(".btnSubmit").html("<i class='fas fa-save'></i> {{ __('configuration::module.permission.modal_btn_update') }}");
            }
            $('#formPermission').attr('action', actionPermission);
            $('#modalPermissionContainer').appendTo('body').modal('show');
        }

        function ModalPermissionDelete(identifier) {

            const idPermission = $(identifier).data("id");
            const namePermission = $(identifier).data("name");
            const tokenPermission = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('configuration::module.permission.modal_delete_title') }}",
                text: "{{ __('configuration::module.permission.modal_delete_text') }} "+ namePermission + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('configuration::module.permission.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: idPermission,
                            _token: tokenPermission
                        },
                        url: actionURl,
                        success: function(res) {
                            
                            if (res.success) {
                                tablePermission.ajax.reload();
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
