@extends('layouts.app')

@section('title', __('configuration::module.designation.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('configuration::module.designation.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="url" value="{{ route('bp_designation.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('configuration::module.designation.sub_title') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger" onclick="ModalAddEdit(this)" data-cmd="add"
                            data-action="{{ route('bp_designation.store') }}"><i class="fa fa-save"></i>
                            {{ __('configuration::module.designation.btn_create') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="DesignationTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('configuration::module.designation.table_id') }}</th>
                                <th>{{ __('configuration::module.designation.table_name') }}</th>
                                <th>{{ __('configuration::module.designation.table_created_at') }}</th>
                                <th>{{ __('configuration::module.designation.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('configuration::bussines_partner.designation.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        var tableDesignation = $('#DesignationTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('bp_designation.index') }}',
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
                    data: 'created_at',
                    name: 'created_at',
                    width: "200px",
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

        $("#formDesignation").submit(function(e) {
            e.preventDefault();
            btnLoading();
            $(".btnSubmit").attr('disabled', true);

            const actionURl = $('#formDesignation').attr('action');

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
                        tableDesignation.ajax.reload();
                        $('#modalContainer').modal('hide')
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: res.message
                        });

                        for (fname in res.errors) {
                            $('input[name=' + fname + ']').addClass('is-invalid');
                            $('#error-' + fname).html(res.errors[fname]);
                        }

                        setTimeout(function() {
                            $(".btnSubmit").attr('disabled', false);
                        }, 700);
                    }
                },
                error: function error(res) {
                    Toast.fire({
                        icon: 'error',
                        title: res.message
                    });
                    setTimeout(function() {
                        $(".btnSubmit").attr('disabled', false);
                    }, 700);
                },
                complete: function complete() {
                    setTimeout(function() {
                        $(".btnSubmit").attr('disabled', false);
                    }, 700);
                    if ($("#designation_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('configuration::module.designation.modal_btn_update') }}"
                        );
                    } else {
                        $(".btnSubmit").html(
                            `<i class='fas fa-save'></i> {{ __('configuration::module.designation.modal_btn_save') }}`
                        );
                    }
                }
            });
        });

        $('#modalContainer').on('hidden.bs.modal', function(e) {
            $("#formDesignation").trigger("reset");
            $('#formDesignation .is-invalid').removeClass('is-invalid');
        });

        function ModalAddEdit(identifier) {

            const cmd = $(identifier).data("cmd");
            const action = $(identifier).data("action");

            if (cmd == "add") {
                $(".modal-title").html("{{ __('configuration::module.designation.modal_title') }}");
                $(".btnSubmit").html(
                    `<i class='fas fa-save'></i> {{ __('configuration::module.designation.modal_btn_save') }}`);
            } else if (cmd == "edit") {
                $(".modal-title").html("{{ __('configuration::module.designation.modal_title_edit') }}");
                $("#designation_id").val($(identifier).data("id"));
                $("#name").val($(identifier).data("name"));
                $(".btnSubmit").html(
                    "<i class='fas fa-save'></i> {{ __('configuration::module.designation.modal_btn_update') }}");
            }

            $('#formDesignation').attr('action', action);
            $('#modalContainer').appendTo('body').modal('show');
        }

        function ModalDelete(identifier) {

            const id = $(identifier).data("id");
            const name = $(identifier).data("name");
            const token = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('configuration::module.designation.modal_delete_title') }}",
                text: "{{ __('configuration::module.designation.modal_delete_text') }} " + name + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('configuration::module.designation.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: id,
                            _token: token
                        },
                        url: actionURl,
                        success: function(res) {

                            if (res.success) {
                                tableDesignation.ajax.reload();
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
