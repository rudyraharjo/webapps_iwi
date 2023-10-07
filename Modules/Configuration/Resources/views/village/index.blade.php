@extends('layouts.app')

@section('title', __('configuration::module.village.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('configuration::module.village.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="urlVillage" value="{{ route('village.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('configuration::module.village.sub_title') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger" onclick="ModalVillageAddEdit(this)"
                            data-cmd="addVillage" data-action="{{ route('village.store') }}"><i
                                class="fa fa-save"></i>
                            {{ __('configuration::module.village.btn_create') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="villageTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('configuration::module.village.table_id') }}</th>
                                <th>{{ __('configuration::module.village.table_name') }}</th>
                                <th>{{ __('configuration::module.village.table_district') }}</th>
                                <th>{{ __('configuration::module.village.table_created_at') }}</th>
                                <th>{{ __('configuration::module.village.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('configuration::village.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        
        $('.select2village').select2();

        var tableVillage = $('#villageTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('village.index') }}',
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
                    data: 'district',
                    name: 'district',
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

        $("#formVillage").submit(function(e) {
            e.preventDefault();
            btnLoading();
            $(".btnSubmit").attr('disabled', true);

            const actionURl = $('#formVillage').attr('action');

            $.ajax({
                url: actionURl,
                type: 'POST',
                data: new FormData($(this)[0]),
                processData: false,
                contentType: false,
                success: function success(res) {
                    console.log(res)
                    if (res.success) {
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        });
                        tableVillage.ajax.reload();
                        $('#modalVillageContainer').modal('hide')
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: res.message
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
                    if ($("#village_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('configuration::module.village.modal_btn_update') }}"
                            );
                    } else {
                        $(".btnSubmit").html(
                            `<i class='fas fa-save'></i> {{ __('configuration::module.village.modal_btn_save') }}`);
                    }
                }
            });
        });

        $('#modalVillageContainer').on('hidden.bs.modal', function(e) {
            
            $("#formVillage").trigger("reset");
            $('#formVillage .is-invalid').removeClass('is-invalid');
        });

        function ModalVillageAddEdit(identifier) {

            const cmdVillage = $(identifier).data("cmd");
            const actionVillage = $(identifier).data("action");

            if (cmdVillage == "addVillage") {
                $(".modal-title").html("{{ __('configuration::module.village.modal_title') }}");
                $(".btnSubmit").html(`<i class='fas fa-save'></i> {{ __('configuration::module.village.modal_btn_save') }}`);
            } else if (cmdVillage == "editVillage") {
                $(".modal-title").html("{{ __('configuration::module.village.modal_title_edit') }}");
                $("#village_id").val($(identifier).data("id"));
                $('#district_id').val($(identifier).data("district_id"));
                $('#district_id').trigger('change');
                // $("#province_id").select2("val", "13");
                $("#name").val($(identifier).data("name"));
                $(".btnSubmit").html("<i class='fas fa-save'></i> {{ __('configuration::module.village.modal_btn_update') }}");
            }
            $('#formVillage').attr('action', actionVillage);
            $('#modalVillageContainer').appendTo('body').modal('show');
        }

        function ModalVillageDelete(identifier) {

            const idVillage = $(identifier).data("id");
            const nameVillage = $(identifier).data("name");
            const tokenVillage = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('configuration::module.village.modal_delete_title') }}",
                text: "{{ __('configuration::module.village.modal_delete_text') }} "+ nameVillage + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('configuration::module.village.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: idVillage,
                            _token: tokenVillage
                        },
                        url: actionURl,
                        success: function(res) {
                            
                            if (res.success) {
                                tableVillage.ajax.reload();
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
