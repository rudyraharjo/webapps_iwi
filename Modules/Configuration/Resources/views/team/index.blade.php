@extends('layouts.app')

@section('title', __('configuration::module.team.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('configuration::module.team.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="urlTeam" value="{{ route('team.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('configuration::module.team.sub_title') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger" onclick="ModalAddEdit(this)" data-cmd="addTeam"
                            data-action="{{ route('team.store') }}"><i class="fa fa-save"></i>
                            {{ __('configuration::module.team.btn_create') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="teamTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('configuration::module.team.table_id') }}</th>
                                <th>{{ __('configuration::module.team.table_name') }}</th>
                                <th>{{ __('configuration::module.team.table_display_name') }}</th>
                                <th>{{ __('configuration::module.team.table_description') }}</th>
                                <th>{{ __('configuration::module.team.table_created_at') }}</th>
                                <th>{{ __('configuration::module.team.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('configuration::team.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        var tableTeam = $('#teamTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('team.index') }}',
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

        $("#formTeam").submit(function(e) {
            e.preventDefault();
            btnLoading();
            $(".btnSubmit").attr('disabled', true);

            const actionURl = $('#formTeam').attr('action');

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
                        tableTeam.ajax.reload();
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
                    if ($("#team_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('configuration::module.team.modal_btn_update') }}"
                        );
                    } else {
                        $(".team_id").html(
                            `<i class='fas fa-save'></i> {{ __('configuration::module.team.modal_btn_save') }}`);
                    }
                }
            });
        });

        $('#modalAddEditContainer').on('hidden.bs.modal', function(e) {
            $("#formTeam").trigger("reset");
            $('#formTeam .is-invalid').removeClass('is-invalid');
        });

        $("#name").keyup(function() {
            let Text = convertToSlug($(this).val());
            $("#name").val(Text);
        });
        // });

        function ModalAddEdit(identifier) {

            const cmdTeam = $(identifier).data("cmd");
            const actionTeam = $(identifier).data("action");

            if (cmdTeam == "addTeam") {
                $(".modal-title").html("{{ __('configuration::module.team.modal_title') }}");
                $(".btnSubmit").html(`<i class='fas fa-save'></i> {{ __('configuration::module.team.modal_btn_save') }}`);
            } else if (cmdTeam == "editTeam") {
                $(".modal-title").html("{{ __('configuration::module.team.modal_title_edit') }}");
                $("#team_id").val($(identifier).data("id"));
                $("#name").val($(identifier).data("name"));
                $("#display_name").val($(identifier).data("display_name"));
                $("#description").val($(identifier).data("description"));
                $(".btnSubmit").html("<i class='fas fa-save'></i> {{ __('configuration::module.team.modal_btn_update') }}");
            }
            $('#formTeam').attr('action', actionTeam);
            $('#modalAddEditContainer').appendTo('body').modal('show');
        }

        function ModalDeleteTeam(identifier) {

            const idTeam = $(identifier).data("id");
            const nameTeam = $(identifier).data("name");
            const tokenTeam = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('configuration::module.team.modal_delete_title') }}",
                text: "{{ __('configuration::module.team.modal_delete_text') }} "+ nameTeam + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('configuration::module.team.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: idTeam,
                            _token: tokenTeam
                        },
                        url: actionURl,
                        success: function(res) {
                            if (res.success) {
                                tableTeam.ajax.reload();
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
