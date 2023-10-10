@extends('layouts.app')

@section('title', __('humanresource::hr.employee.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('humanresource::hr.employee.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="urlUser" value="{{ route('hr.employee.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('humanresource::hr.employee.sub_title') }}</h3>
                    <div class="card-tools">
                        <button 
                            type="button" 
                            class="btn btn-danger" onclick="ModalAddEdit(this)" data-cmd="add"
                            data-action="{{ route('employee.store') }}"><i class="fa fa-plus-circle"></i>
                            {{ __('humanresource::hr.employee.btn_create') }}</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="userTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('humanresource::hr.employee.table_id') }}</th>
                                <th>{{ __('humanresource::hr.employee.table_name') }}</th>
                                <th>{{ __('humanresource::hr.employee.table_email') }}</th>
                                <th>{{ __('humanresource::hr.employee.table_nik') }}</th>
                                <th>{{ __('humanresource::hr.employee.table_created_at') }}</th>
                                <th>{{ __('humanresource::hr.employee.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('humanresource::hr.employee.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        var tableUser = $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('hr.employee.index') }}',
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
                    data: 'email',
                    name: 'email',
                    className: "text-left"
                },
                {
                    data: 'nik',
                    name: 'nik',
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

        $("#formUser").submit(function(e) {
            btnLoading();
            $(".btnSubmit").attr('disabled', true);
            $('#formUser .is-invalid').removeClass('is-invalid');
            e.preventDefault();
            const actionURl = $('#formUser').attr('action');

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
                        tablehr.employee.ajax.reload();
                        $('#modalAddEditUserContainer').modal('hide')
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
                    if ($("#user_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('humanresource::hr.employee.modal_btn_update') }}"
                        );
                    } else {
                        $(".btnSubmit").html(
                            `<i class='fas fa-save'></i> {{ __('humanresource::hr.employee.modal_btn_update') }}`
                        );
                    }
                }
            });
        });

        $('#modalAddEditUserContainer').on('hidden.bs.modal', function(e) {
            $("#formUser").trigger("reset");
            $("#role_id").val("");
            $('#formUser .is-invalid').removeClass('is-invalid');
        });

        $('#showpassword').click(function() {
            $(this).is(':checked') ? $('#password').attr('type', 'text') : $('#password').attr('type',
                'password');
        });

        function ModalAddEdit(identifier) {
            const cmd = $(identifier).data("cmd");
            const action = $(identifier).data("action");

            if (cmd == "add") {
                // alert("asdf")
                $('.selectric').selectric();
                $(".modal-title").html("{{ __('humanresource::hr.employee.modal_title') }}");
                $(".btnSubmit").html(
                    `<i class='fas fa-save'></i> {{ __('humanresource::hr.employee.modal_btn_save') }}`);
            } else if (cmd == "edit") {
                $('.selectric').selectric('destroy');
                $(".modal-title").html("{{ __('humanresource::hr.employee.modal_title_edit') }}");
                $("#user_id").val($(identifier).data("id"));
                $("#user_fullname").val($(identifier).data("name"));
                $("#user_email").val($(identifier).data("email"));

                let roleSplit = null;
                let role = $(identifier).data("role");

                if (role) {
                    roleSplit = role.split(",");
                }
                $('#role').val(roleSplit).selectric('refresh');
                // $("#role").select2().select2('val',roleSplit);

                $(".btnSubmit").html(
                    "<i class='fas fa-save'></i> {{ __('humanresource::hr.employee.modal_btn_update') }}");

            }
            $('#formUser').attr('action', action);
            $('#modalAddEditUserContainer').appendTo('body').modal('show');
        }

        function ModalDeleteUser(identifier) {

            const idUser = $(identifier).data("id");
            const nameUser = $(identifier).data("name");
            const tokenUser = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('humanresource::hr.employee.modal_delete_title') }}",
                text: "{{ __('humanresource::hr.employee.modal_delete_text') }} " + nameUser + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('humanresource::hr.employee.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: idUser,
                            _token: tokenUser
                        },
                        url: actionURl,
                        success: function(res) {
                            if (res.success) {
                                tablehr.employee.ajax.reload();
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
    </script>
@endsection
