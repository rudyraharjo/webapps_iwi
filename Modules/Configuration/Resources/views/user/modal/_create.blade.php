<div id="modalAddEditUserContainer" class="modal fade" data-backdrop="static" role="dialog">

    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-maroon">
                <h5 class="modal-title"></h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="formUser">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>{{ __('configuration::module.user.modal_input_name') }}:</label><span
                                class="required text-danger">*</span>
                            <input type="text" name="user_fullname" id="user_fullname" class="form-control" autofocus
                                tabindex="1">
                            <span id="error-user_fullname" class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>{{ __('configuration::module.user.modal_input_email') }}:</label><span
                                class="required text-danger">*</span>
                            <input type="text" name="user_email" id="user_email" class="form-control" tabindex="2" autofocus
                                >
                            <span id="error-user_email" class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>{{ __('configuration::module.user.modal_input_password') }}:</label><span
                                class="required text-danger">*</span>
                            <input type="password" name="password" id="password" class="form-control"
                                autofocus tabindex="3">
                            <span id="error-password" class="invalid-feedback"></span>
                            <div class="custom-control custom-checkbox mt-2">
                                <input type="checkbox" name="showpassword" class="custom-control-input"
                                    id="showpassword" tabindex=5">
                                <label class="custom-control-label" for="showpassword">Show Password</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>{{ __('configuration::module.user.modal_input_conf_password') }}:</label><span
                                class="required text-danger">*</span>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" autofocus tabindex="4">
                            <span id="error-password_confirmation" class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>{{ __('configuration::module.user.modal_input_department') }}:</label><span
                                class="required">*</span>
                            <span id="error-user_team" class="invalid-feedback"></span>
                            <select class="form-control selectric" name="user_team" id="user_team" style="width: 100%;"
                                tabindex="6">
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>{{ __('configuration::module.user.modal_input_role') }}:</label><span
                                class="required">*</span>
                            <span id="error-user_role" class="invalid-feedback"></span>
                            <select class="form-control selectric" name="user_role" id="user_role" style="width: 100%;"
                                tabindex="7">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-icon icon-left btn-light mr-2" tabindex="9"
                            data-dismiss="modal">
                            <i class="fas fa-undo"></i>
                            {{ __('configuration::module.user.modal_btn_cancel') }}
                        </button>
                        <button type="submit" class="btn btn-icon icon-left btn-danger btnSubmit" tabindex="8">
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>
