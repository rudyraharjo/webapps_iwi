<div id="modalVillageContainer" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-maroon">
                <h5 class="modal-title"></h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="formVillage">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="village_id" id="village_id">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>{{ __('module.village.modal_input_district') }}:</label><span
                                class="required">*</span>
                            <span id="error-province_id" class="invalid-feedback"></span>
                            <select class="form-control select2village select2-danger" name="district_id" id="district_id"
                                style="width: 100%; height:40px;" tabindex="1">
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>{{ __('module.village.modal_input_name') }}:</label><span
                                class="required text-danger">*</span>
                            <input type="text" name="name" id="name" class="form-control" autofocus tabindex="2">
                            <span id="error-name" class="invalid-feedback"></span>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-icon icon-left btn-light mr-2" tabindex="4"
                            data-dismiss="modal">
                            <i class="fas fa-undo"></i>
                            {{ __('module.village.modal_btn_cancel') }}
                        </button>
                        <button type="submit" class="btn btn-icon icon-left btn-danger btnSubmit" tabindex="3">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
