@extends('layouts.app')

@section('title', __('configuration::module.district.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('configuration::module.district.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="urlDistrict" value="{{ route('district.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('configuration::module.district.sub_title') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger" onclick="ModalDistrictAddEdit(this)"
                            data-cmd="addDistrict" data-action="{{ route('district.store') }}"><i
                                class="fa fa-save"></i>
                            {{ __('configuration::module.district.btn_create') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="districtTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('configuration::module.district.table_id') }}</th>
                                <th>{{ __('configuration::module.district.table_name') }}</th>
                                <th>{{ __('configuration::module.district.table_city') }}</th>
                                <th>{{ __('configuration::module.district.table_created_at') }}</th>
                                <th>{{ __('configuration::module.district.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('configuration::district.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        
        $('.select2district').select2();

        var tableDistrict = $('#districtTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('district.index') }}',
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
                    data: 'city',
                    name: 'city',
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

        $("#formDistrict").submit(function(e) {
            e.preventDefault();
            btnLoading();
            $(".btnSubmit").attr('disabled', true);

            const actionURl = $('#formDistrict').attr('action');

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
                        tableDistrict.ajax.reload();
                        $('#modalDistrictContainer').modal('hide')
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
                    if ($("#district_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('configuration::module.district.modal_btn_update') }}"
                            );
                    } else {
                        $(".btnSubmit").html(
                            `<i class='fas fa-save'></i> {{ __('configuration::module.district.modal_btn_save') }}`);
                    }
                }
            });
        });

        $('#modalDistrictContainer').on('hidden.bs.modal', function(e) {
            
            $("#formDistrict").trigger("reset");
            $('#formDistrict .is-invalid').removeClass('is-invalid');
        });

        function ModalDistrictAddEdit(identifier) {

            const cmdDistrict = $(identifier).data("cmd");
            const actionDistrict = $(identifier).data("action");

            if (cmdDistrict == "addDistrict") {
                $(".modal-title").html("{{ __('configuration::module.district.modal_title') }}");
                $(".btnSubmit").html(`<i class='fas fa-save'></i> {{ __('configuration::module.district.modal_btn_save') }}`);
            } else if (cmdDistrict == "editDistrict") {
                $(".modal-title").html("{{ __('configuration::module.district.modal_title_edit') }}");
                $("#district_id").val($(identifier).data("id"));
                $('#city_id').val($(identifier).data("city_id"));
                $('#city_id').trigger('change');
                // $("#province_id").select2("val", "13");
                $("#name").val($(identifier).data("name"));
                $(".btnSubmit").html("<i class='fas fa-save'></i> {{ __('configuration::module.district.modal_btn_update') }}");
            }
            $('#formDistrict').attr('action', actionDistrict);
            $('#modalDistrictContainer').appendTo('body').modal('show');
        }

        function ModalDistrictDelete(identifier) {

            const idDistrict = $(identifier).data("id");
            const nameDistrict = $(identifier).data("name");
            const tokenDistrict = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('configuration::module.district.modal_delete_title') }}",
                text: "{{ __('configuration::module.district.modal_delete_text') }} "+ nameDistrict + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('configuration::module.district.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: idDistrict,
                            _token: tokenDistrict
                        },
                        url: actionURl,
                        success: function(res) {
                            
                            if (res.success) {
                                tableDistrict.ajax.reload();
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
