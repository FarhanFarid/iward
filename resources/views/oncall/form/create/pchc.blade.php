<div class="modal" id="assignpchc-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Assign Staff</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="oncallpchcform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">PCHC</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                     <div class="row mb-3">
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="pchccons" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Consultant</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="pchccons" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignpchc-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="pchccons" name="pchccons">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchcconsoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchcconsoncallstart" id="pchcconsoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchcconsoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchcconsoncallend" id="pchcconsoncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="pchccardiologist" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Cardiologist</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="pchccardiologist" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignpchc-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="pchccardiologist" name="pchccardiologist">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchccardiooncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchccardiooncallstart" id="pchccardiooncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchccardiooncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchccardiooncallend" id="pchccardiooncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="pchcfirstcall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">First Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="pchcfirstcall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignpchc-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="pchcfirstcall" name="pchcfirstcall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchcfirstoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchcfirstoncallstart" id="pchcfirstoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchcfirstoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchcfirstoncallend" id="pchcfirstoncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="pchcseccall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Second Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="pchcseccall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignpchc-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="pchcseccall" name="pchcseccall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchcseconcallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchcseconcallstart" id="pchcseconcallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchcseconcallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchcseconcallend" id="pchcseconcallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="pchcmocall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">MO On Call</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="pchcmocall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignpchc-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="pchcmocall" name="pchcmocall">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchcmooncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchcmooncallstart" id="pchcmooncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="pchcmooncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="pchcmooncallend" id="pchcmooncallend">
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
                <button type="button" class="btn btn-primary btn-sm font-weight-bold save-ocpchc mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>
