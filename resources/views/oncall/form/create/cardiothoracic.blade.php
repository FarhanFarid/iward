<div class="modal" id="assignct-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Assign Staff</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="oncallcardiothoracicform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #def7ff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">CARDIOTHORACIC</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                    <div class="row mb-3">
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Consultant</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="ctconsultant" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignct-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="ctconsultant" name="ctconsultant">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallstartcons" id="oncallstartcons">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallendcons" id="oncallendcons">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">First Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignct-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="ctfirstcall" name="ctfirstcall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallstartfirst" id="oncallstartfirst">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallendfirst" id="oncallendfirst">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Second Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignct-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="ctsecondcall" name="ctsecondcall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallstartsec" id="oncallstartsec">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallendsec" id="oncallendsec">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Third Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignct-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="ctthirdcall" name="ctthirdcall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallstartthird" id="oncallstartthird">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallendthird" id="oncallendthird">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">ICU Duty (AM)</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignct-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="cticuam" name="cticuam">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallstarticuam" id="oncallstarticuam">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallendicuam" id="oncallendicuam">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">ICU Duty (PM)</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignct-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="cticupm" name="cticupm">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallstarticupm" id="oncallstarticupm">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="indication" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="oncallendicupm" id="oncallendicupm">
                                                    </div>
                                                </div>
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
                <button type="button" class="btn btn-primary btn-sm font-weight-bold save-occt mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>







