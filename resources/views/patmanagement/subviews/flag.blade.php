<div class="modal" id="patientflag-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 30% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Add Patient's Flag</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="patientflagform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">Patient Details</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                   <div class="row mt-5 mb-3">
                                        <div class="col-md-12 px-5">
                                            <label for="mrn" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">MRN:</label>
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="mrn" id="mrn" readonly>
                                        </div>
                                   </div>
                                   <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <label for="name" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Patient's Name:</label>
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="name" id="name" readonly>
                                        </div>
                                    </div>
                                    <div class="row mt-5 mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="row mb-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">Nil by Mouth</span>
                                                    <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                        <input class="form-check-input" type="checkbox" name="nbm" id="nbm" value="1"/>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-8">
                                                    <textarea class="form-control form-control-sm" name="nbm_remark" id="nbm_remark" maxlength="50" rows="2"></textarea>
                                                    <small id="nbm_remark_count" class="text-muted">0 / 50</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="row mb-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">Remarks</span>
                                                    <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                        <input class="form-check-input" type="checkbox" name="fasting" id="fasting" value="1"/>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-8">
                                                    <textarea class="form-control form-control-sm" name="fasting_remark" id="fasting_remark" maxlength="50" rows="2"></textarea>
                                                    <small id="fasting_remark_count" class="text-muted">0 / 50</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="row mb-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold">Procedure</span>
                                                    <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                        <input class="form-check-input" type="checkbox" name="procedure" id="procedure" value="1"/>
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="procedure_remark_wrapper" style="display: none;">
                                                <!-- Initial Input Group -->
                                                <div class="row mb-2 procedure_remark_group align-items-center">
                                                    <div class="col-md-8 d-flex align-items-center gap-2 flex-wrap">
                                                        <input class="form-control form-control-sm procedure_remark_input" type="text" name="procedure_remark[0]" maxlength="50" placeholder="Enter procedure">
                                                        <div class="form-check form-switch d-flex align-items-center">
                                                            <input class="form-check-input me-1" type="checkbox" name="financial_switch[0]" value="1">
                                                            <label class="form-check-label ms-1">Financial Clearance</label>
                                                        </div>
                                                        <button type="button" class="btn btn-light btn-sm add-procedure-btn" title="Add">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                        <small class="text-muted count-label ms-2">0 / 50</small>
                                                    </div>
                                                </div>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Fall Risk</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="fallrisk" id="fallrisk" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Refer Heart Failure</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="heartfailure" id="heartfailure" value="1" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Refer Respiratory</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="respi" id="respi" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Refer Nephrology</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="nephro" id="nephro" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Refer Neurology</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="neuro" id="neuro" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Refer Gastrology</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="gastro" id="gastro" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Refer ENT</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="ent" id="ent" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Infectious Disease</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="infdisease" id="infdisease" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">DIL/DNR</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="dildnr" id="dildnr" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 px-5">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">High Risk</span>
                                                <label class="form-check form-switch form-check-custom form-check-solid m-0">
                                                    <input class="form-check-input" type="checkbox" name="highrisk" id="highrisk" value="1"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm font-weight-bold save-patientflag mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>