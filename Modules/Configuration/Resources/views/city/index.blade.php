@extends('layouts.app')

@section('title', __('configuration::module.city.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('configuration::module.city.title') }}</li>
@endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-maroon card-outline">
                <input type="hidden" id="urlCity" value="{{ route('city.index') }}" />
                <div class="card-header">
                    <h3 class="card-title">{{ __('configuration::module.city.sub_title') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger" onclick="ModalCityAddEdit(this)"
                            data-cmd="addCity" data-action="{{ route('city.store') }}"><i
                                class="fa fa-save"></i>
                            {{ __('configuration::module.city.btn_create') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="cityTable" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('configuration::module.city.table_id') }}</th>
                                <th>{{ __('configuration::module.city.table_name') }}</th>
                                <th>{{ __('configuration::module.city.table_province') }}</th>
                                <th>{{ __('configuration::module.city.table_created_at') }}</th>
                                <th>{{ __('configuration::module.city.table_tool') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('configuration::city.modal._create')
@endsection

@section('scripts')
    <!-- DataTables -->
    <script type="text/javascript">
        
        $('.select2city').select2();

        var tableCity = $('#cityTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('city.index') }}',
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
                    data: 'province',
                    name: 'province',
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

        $("#formCity").submit(function(e) {
            e.preventDefault();
            btnLoading();
            $(".btnSubmit").attr('disabled', true);

            const actionURl = $('#formCity').attr('action');

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
                        tableCity.ajax.reload();
                        $('#modalCityContainer').modal('hide')
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
                    if ($("#city_id").val()) {
                        $(".btnSubmit").html(
                            "<i class='fas fa-save'></i> {{ __('configuration::module.city.modal_btn_update') }}"
                            );
                    } else {
                        $(".btnSubmit").html(
                            `<i class='fas fa-save'></i> {{ __('configuration::module.city.modal_btn_save') }}`);
                    }
                }
            });
        });

        $('#modalCityContainer').on('hidden.bs.modal', function(e) {
            
            $("#formCity").trigger("reset");
            $('#formCity .is-invalid').removeClass('is-invalid');
        });

        function ModalCityAddEdit(identifier) {

            const cmdCity = $(identifier).data("cmd");
            const actionCity = $(identifier).data("action");

            if (cmdCity == "addCity") {
                $(".modal-title").html("{{ __('configuration::module.city.modal_title') }}");
                $(".btnSubmit").html(`<i class='fas fa-save'></i> {{ __('configuration::module.city.modal_btn_save') }}`);
            } else if (cmdCity == "editCity") {
                $(".modal-title").html("{{ __('configuration::module.city.modal_title_edit') }}");
                $("#city_id").val($(identifier).data("id"));
                $('#province_id').val($(identifier).data("province_id"));
                $('#province_id').trigger('change');
                // $("#province_id").select2("val", "13");
                $("#name").val($(identifier).data("name"));
                $(".btnSubmit").html("<i class='fas fa-save'></i> {{ __('configuration::module.city.modal_btn_update') }}");
            }
            $('#formCity').attr('action', actionCity);
            $('#modalCityContainer').appendTo('body').modal('show');
        }

        function ModalCityDelete(identifier) {

            const idCity = $(identifier).data("id");
            const nameCity = $(identifier).data("name");
            const tokenCity = $(identifier).data("token");
            const actionURl = $(identifier).data("action");

            Swal.fire({
                title: "{{ __('configuration::module.city.modal_delete_title') }}",
                text: "{{ __('configuration::module.city.modal_delete_text') }} "+ nameCity + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('configuration::module.city.modal_delete_btn_text') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: idCity,
                            _token: tokenCity
                        },
                        url: actionURl,
                        success: function(res) {
                            
                            if (res.success) {
                                tableCity.ajax.reload();
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
