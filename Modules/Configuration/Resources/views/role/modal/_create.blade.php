<div id="modalAddEditContainer" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-maroon">
                <h5 class="modal-title"></h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="formRole">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>{{ __('configuration::module.role.modal_input_name') }}:</label><span class="required text-danger">*</span>
                            <input type="text" name="name" id="name" class="form-control" autofocus tabindex="1">
                            <span id="error-name" class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>{{ __('configuration::module.role.modal_input_display_name') }}:</label>
                            <input type="text" name="display_name" id="display_name" class="form-control" autofocus
                                tabindex="2">
                            <span id="error-display_name" class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>{{ __('configuration::module.role.modal_input_description') }}:</label>
                            <input type="text" name="description" id="description" class="form-control" autofocus
                                tabindex="3">
                            <span id="error-description" class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>{{ __('configuration::module.role.modal_input_permission') }}:</label><span class="required">*</span>
                            <span id="error-permissions" class="invalid-feedback"></span>
                            <select class="form-control selectric" multiple="" name="permissions[]" id="permissions"
                                style="width: 100%;" tabindex="4">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Permissions:</label><span class="required">*</span>
                            <select name="cars" id="cars">
                                <option value="volvo">Volvo</option>
                                <option value="saab">Saab</option>
                                <option value="mercedes">Mercedes</option>
                                <option value="audi">Audi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <div class="icheck-primary">
                                <input type="checkbox" id="createIdPermission" name="perm_create" />
                                <label for="createIdPermission">Create</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class="icheck-primary">
                                <input type="checkbox" id="readIdPermission" name="perm_read" />
                                <label for="readIdPermission">Read</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class="icheck-primary">
                                <input type="checkbox" id="updateIdPermission" name="perm_update" />
                                <label for="updateIdPermission">Update</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class="icheck-primary">
                                <input type="checkbox" id="deleteIdPermission" name="perm_delete" />
                                <label for="deleteIdPermission">Delete</label>
                            </div>
                        </div>
                    </div> --}}
                    <div class="text-right">
                        <button type="button" class="btn btn-icon icon-left btn-light mr-2" tabindex="6"
                            data-dismiss="modal">
                            <i class="fas fa-undo"></i>
                            {{ __('configuration::module.role.modal_btn_cancel') }}
                        </button>
                        <button type="submit" class="btn btn-icon icon-left btn-danger btnSubmit"
                            tabindex="5">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
