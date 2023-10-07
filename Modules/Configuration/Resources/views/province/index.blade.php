@extends('layouts.app')

@section('title', __('configuration::module.province.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('configuration::module.province.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="urlProvince" value="{{ route('province.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('configuration::module.province.sub_title') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger" onclick="ModalProvinceAddEdit(this)"
                            data-cmd="addProvince" data-action="{{ route('province.store') }}"><i
                                class="fa fa-save"></i>
                            {{ __('configuration::module.province.btn_create') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="provinceTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('configuration::module.province.table_id') }}</th>
                                <th>{{ __('configuration::module.province.table_name') }}</th>
                                <th>{{ __('configuration::module.province.table_created_at') }}</th>
                                <th>{{ __('configuration::module.province.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('configuration::province.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        var tableProvince = $('#provinceTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('province.index') }}',
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

        $("#formProvince").submit(function(e) {
            e.preventDefault();
            btnLoading();
            $(".btnSubmit").attr('disabled', true);

            const actionURl = $('#formProvince').attr('action');

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
                        tableProvince.ajax.reload();
                        $('#modalProvinceContainer').modal('hide')
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
                    if ($("#province_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('configuration::module.province.modal_btn_update') }}"
                            );
                    } else {
                        $(".btnSubmit").html(
                            `<i class='fas fa-save'></i> {{ __('configuration::module.province.modal_btn_save') }}`);
                    }
                }
            });
        });

        $('#modalProvinceContainer').on('hidden.bs.modal', function(e) {
            
            $("#formProvince").trigger("reset");
            $('#formProvince .is-invalid').removeClass('is-invalid');
        });

        function ModalProvinceAddEdit(identifier) {

            const cmdProvince = $(identifier).data("cmd");
            const actionProvince = $(identifier).data("action");

            if (cmdProvince == "addProvince") {
                $(".modal-title").html("{{ __('configuration::module.province.modal_title') }}");
                $(".btnSubmit").html(`<i class='fas fa-save'></i> {{ __('configuration::module.province.modal_btn_save') }}`);
            } else if (cmdProvince == "editProvince") {
                $(".modal-title").html("{{ __('configuration::module.province.modal_title_edit') }}");
                $("#province_id").val($(identifier).data("id"));
                $("#name").val($(identifier).data("name"));
                $(".btnSubmit").html("<i class='fas fa-save'></i> {{ __('configuration::module.province.modal_btn_update') }}");
            }
            $('#formProvince').attr('action', actionProvince);
            $('#modalProvinceContainer').appendTo('body').modal('show');
        }

        function ModalProvinceDelete(identifier) {

            const idProvince = $(identifier).data("id");
            const nameProvince = $(identifier).data("name");
            const tokenProvince = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('configuration::module.province.modal_delete_title') }}",
                text: "{{ __('configuration::module.province.modal_delete_text') }} "+ nameProvince + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('configuration::module.province.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: idProvince,
                            _token: tokenProvince
                        },
                        url: actionURl,
                        success: function(res) {
                            
                            if (res.success) {
                                tableProvince.ajax.reload();
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
