<div class="modal" id="assignoth-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Assign Staff</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="oncallotherform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">Others</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                     <div class="row mb-3">
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="othperf" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Perfusionist</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="othperf" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignoth-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="othperf" name="othperf">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othperfoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othperfoncallstart" id="othperfoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othperfoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othperfoncallend" id="othperfoncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="othdiet" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Dietitian</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="othdiet" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignoth-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="othdiet" name="othdiet">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othdietoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othdietoncallstart" id="othdietoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othdietoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othdietoncallend" id="othdietoncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="othphysio" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Physiotherapist</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="othphysio" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignoth-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="othphysio" name="othphysio">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othphysiooncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othphysiooncallstart" id="othphysiooncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othphysiooncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othphysiooncallend" id="othphysiooncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="othlab" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Resp Lab</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="cdseccall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignoth-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="othlab" name="othlab">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othlaboncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othlaboncallstart" id="othlaboncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othlaboncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othlaboncallend" id="othlaboncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="othcvt" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">CVT</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="cdmocall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignoth-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="othcvt" name="othcvt">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othcvtoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othcvtoncallstart" id="othcvtoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="othcvtoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="othcvtoncallend" id="othcvtoncallend">
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
                <button type="button" class="btn btn-primary btn-sm font-weight-bold save-ocoth mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>
