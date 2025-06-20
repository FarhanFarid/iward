<div class="modal" id="assigncd-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Assign Staff</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="oncallcardiologyform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">CARDIOLOGY</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                     <div class="row mb-3">
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="cdcons" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Consultant</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="cdcons" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assigncd-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="cdcons" name="cdcons">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdconsoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdconsoncallstart" id="cdconsoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdconsoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdconsoncallend" id="cdconsoncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="cdcardiologist" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Cardiologist</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="cdcardiologist" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assigncd-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="cdcardiologist" name="cdcardiologist">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdcardiooncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdcardiooncallstart" id="cdcardiooncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdcardiooncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdcardiooncallend" id="cdcardiooncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="cdfirstcall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">First Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="cdfirstcall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assigncd-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="cdfirstcall" name="cdfirstcall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdfirstoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdfirstoncallstart" id="cdfirstoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdfirstoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdfirstoncallend" id="cdfirstoncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="cdseccall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Second Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="cdseccall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assigncd-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="cdseccall" name="cdseccall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdseconcallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdseconcallstart" id="cdseconcallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdseconcallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdseconcallend" id="cdseconcallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="cdmocall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">MO On Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="cdmocall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assigncd-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="cdmocall" name="cdmocall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdmooncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdmooncallstart" id="cdmooncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdmooncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdmooncallend" id="cdmooncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="cdepcall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Consultant EP On Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="cdepcall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assigncd-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="cdepcall" name="cdepcall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdeponcallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdeponcallstart" id="cdeponcallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="cdeponcallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="cdeponcallend" id="cdeponcallend">
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
                <button type="button" class="btn btn-primary btn-sm font-weight-bold save-occd mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>
