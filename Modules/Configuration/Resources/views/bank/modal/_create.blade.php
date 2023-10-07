<div id="modalContainer" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-maroon">
                <h5 class="modal-title"></h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="formBank">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="bank_id" id="bank_id">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>{{ __('configuration::module.bank.modal_input_code') }}:</label><span class="required text-danger">*</span>
                            <input type="text" name="code" id="code" class="form-control" autofocus tabindex="1">
                            <span id="error-code" class="invalid-feedback"></span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>{{ __('configuration::module.bank.modal_input_name') }}:</label><span class="required text-danger">*</span>
                            <input type="text" name="name" id="name" class="form-control" autofocus tabindex="2">
                            <span id="error-name" class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>{{ __('configuration::module.bank.modal_input_description') }}:</label><span class="required text-danger">*</span>
                            <input type="text" name="description" id="description" class="form-control" autofocus tabindex="3">
                            <span id="error-description" class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-icon icon-left btn-light mr-2" tabindex="5"
                            data-dismiss="modal">
                            <i class="fas fa-undo"></i>
                            {{ __('configuration::module.bank.modal_btn_cancel') }}
                        </button>
                        <button type="submit" class="btn btn-icon icon-left btn-danger btnSubmit"
                            tabindex="4">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
