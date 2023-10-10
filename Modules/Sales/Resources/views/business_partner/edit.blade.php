@extends('layouts.app')

@section('title', __('sales::business_partner.business_partner.title'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ __('sales::business_partner.business_partner.title') }}</li>
@endsection

@section('css')
    <style>
        #fixed-column-right-action {
            position: fixed;
            transition: top 0.3s ease;
            right: 0;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <form method="post" action="{{ route('business_partner.update', ['id' => $businesspartners->id]) }}">
        {{ csrf_field() }}
        <input type="hidden" name="currency_id" value="1" />
        <input type="hidden" name="shipment_id" value="1" />
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('message_failed'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        {{ Session::get('message_failed') }}
                    </div>
                @endif

                @if (Session::has('message_success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        {{ Session::get('message_success') }}
                    </div>
                @endif
                @if (Session::has('destroy_success'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        {{ Session::get('destroy_success') }}
                    </div>
                @endif

                <div class="card card-maroon card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('sales::business_partner.business_partner.form_title') }}</h3> &nbsp;
                        <span style="color: red; font-size: x-small;"><b>* Wajib di Isi </b></span>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                {{ __('sales::business_partner.business_partner.form_input_category') }}
                                <span style="color: red; font-size: x-small;"><b>*</b></span>
                            </label>
                            <div class="col-sm-10">
                                <select class="form-control selectric" name="category_id" id="category_id"
                                    style="width: 100%;" tabindex="1">
                                    @foreach ($bpcategories as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('category_id') ? (old('category_id') == $value->id ? 'selected' : '') : ($businesspartners->category_id == $value->id ? 'selected' : '') }}>
                                            {{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                {{ __('sales::business_partner.business_partner.form_input_old_code') }}
                                <span style="color: red; font-size: x-small;"><b>*</b></span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="old_code" id="old_code"
                                    value="{{ old('old_code') ? old('old_code') : ($businesspartners->old_code ? $businesspartners->old_code : '') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                {{ __('sales::business_partner.business_partner.form_input_group') }}
                                <span style="color: red; font-size: x-small;"><b>*</b></span>
                            </label>
                            <div class="col-sm-10">
                                <select class="form-control selectric" name="business_partner_group_id"
                                    id="business_partner_group_id" style="width: 100%;">
                                    @foreach ($bpgroups as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('business_partner_group_id') == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                {{ __('sales::business_partner.business_partner.form_input_title') }}
                                <span style="color: red; font-size: x-small;"><b>*</b></span>
                            </label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select class="form-control" id="title_id" name="title_id" required>
                                            @foreach ($titles as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('title_id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" name="name"
                                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        value="{{ old('name') ? old('name') : ($businesspartners->name ? $businesspartners->name : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                {{ __('sales::business_partner.business_partner.form_input_province') }}
                                <span style="color: red; font-size: x-small;"><b>*</b></span>
                            </label>
                            <div class="col-sm-10">
                                <select class="form-control selectric" name="province_id" id="business_partner_group_id"
                                    style="width: 100%;">
                                    @foreach ($provinces as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('business_partner_group_id') == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-maroon card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('sales::business_partner.business_partner.form_title') }}</h3> &nbsp;
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                {{ __('sales::business_partner.business_partner.form_input_email') }}
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="email" id="email"
                                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    value="{{ old('email') ? old('email') : ($businesspartners->email ? $businesspartners->email : '') }}">
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Phone 1
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="phone01" id="phone01"
                                    class="form-control {{ $errors->has('phone01') ? ' is-invalid' : '' }}"
                                    value="{{ old('phone01') ? old('phone01') : ($businesspartners->phone_01 ? $businesspartners->phone_01 : '') }}">
                                <span class="invalid-feedback">{{ $errors->first('phone01') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Phone 2
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="phone02" id="phone02"
                                    class="form-control {{ $errors->has('phone02') ? ' is-invalid' : '' }}"
                                    value="{{ old('phone02') ? old('phone02') : ($businesspartners->phone02 ? $businesspartners->phone02 : '') }}">
                                <span class="invalid-feedback">{{ $errors->first('phone02') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Nomor HP
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="handphone" id="handphone"
                                    class="form-control {{ $errors->has('handphone') ? ' is-invalid' : '' }}"
                                    value="{{ old('handphone') ? old('handphone') : ($businesspartners->handphone ? $businesspartners->handphone : '') }}">
                                <span class="invalid-feedback">{{ $errors->first('handphone') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
                <a href="{{ route('business_partner.index') }}" class="btn btn-secondary mb-3"><i
                        class="fa fa-back"></i>
                    {{ __('sales::business_partner.business_partner.form_btn_cancel') }}
                </a>
                <button type="submit" class="btn btn-danger mb-3"><i class="fa fa-save"></i>
                    {{ __('sales::business_partner.business_partner.form_btn_save') }}
                </button>
            </div>

            {{-- <div class="col-md-3" id="fixed-column-right-action">
            <div class="card card-maroon card-outline">
                <div class="card-header">
                    <button type="button" class="btn btn-danger btn-block" onclick="ModalAddEdit(this)" data-cmd="add"
                        data-action="{{ route('business_partner.store') }}"><i class="fa fa-save"></i>
                        {{ __('sales::business_partner.business_partner.form_btn_save') }}
                    </button>

                </div>
            </div>
        </div> --}}
        </div>
    </form>
@endsection

@section('scripts')

    <script type="text/javascript">
        $("#formBusinessPartner").submit(function(e) {
            e.preventDefault();
            btnLoading();
            $(".btnSubmit").attr('disabled', true);

            const actionURl = $('#formBusinessPartner').attr('action');

            // $.ajax({
            //     url: actionURl,
            //     type: 'POST',
            //     data: new FormData($(this)[0]),
            //     processData: false,
            //     contentType: false,
            //     success: function success(res) {
            //         if (res.success) {
            //             Toast.fire({
            //                 icon: 'success',
            //                 title: res.message
            //             });
            //             tableBusinessPartnerTable.ajax.reload();
            //             $('#modalContainer').modal('hide')
            //         } else {
            //             Toast.fire({
            //                 icon: 'error',
            //                 title: 'These credentials do not match our records'
            //             });
            //             for (fname in res.errors) {
            //                 $('input[name=' + fname + ']').addClass('is-invalid');
            //                 $('#error-' + fname).html(res.errors[fname]);
            //             }
            //         }
            //     },
            //     error: function error(res) {
            //         Toast.fire({
            //             icon: 'error',
            //             title: res.message
            //         });
            //     },
            //     complete: function complete() {
            //         setTimeout(function() {
            //             $(".btnSubmit").attr('disabled', false);
            //         }, 700);
            //         if ($("#business_partner_id").val()) {
            //             $(".btnSubmit").html(
            //                 "<i class='fas fa-save'></i> {{ __('sales::business_partner.business_partner.modal_btn_update') }}"
            //             );
            //         } else {
            //             $(".btnSubmit").html(
            //                 `<i class='fas fa-save'></i> {{ __('sales::business_partner.business_partner.modal_btn_save') }}`
            //             );
            //         }
            //     }
            // })

        });

        // document.addEventListener('DOMContentLoaded', function() {
        //     let fixedColumn = document.getElementById('fixed-column-right-action');

        //     window.addEventListener('scroll', function() {
        //         const scrollPosition = window.scrollY || window.pageYOffset;
        //         const customTop = 130;
        //         fixedColumn.style.transition = 'top 0.3s ease';

        //         if (scrollPosition > 0) {
        //             fixedColumn.style.top = 65 + 'px';
        //         } else if (scrollPosition < 65) {
        //             fixedColumn.style.top = customTop + 'px';
        //         }
        //     });
        // });
    </script>
@endsection
