<div class="modal" id="assignanaes-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Assign Staff</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="oncallanaesform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">ANAESTHESIA</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                     <div class="row mb-3">
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="anaescons" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Consultant</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="anaescons" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignanaes-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="anaescons" name="anaescons">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="anaesconsoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="anaesconsoncallstart" id="anaesconsoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="anaesconsoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="anaesconsoncallend" id="anaesconsoncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="anaessr" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">SR</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="anaessr" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignanaes-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="anaessr" name="anaessr">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="anaessroncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="anaessroncallstart" id="anaessroncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="anaessroncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="anaessroncallend" id="anaessroncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="anaessricu" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">SR ICU</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="anaessricu" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignanaes-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="anaessricu" name="anaessricu">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="anaessricuoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="anaessricuoncallstart" id="anaessricuoncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="anaessricuoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="anaessricuoncallend" id="anaessricuoncallend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="anaesmo" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">MO</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-6 p-2">
                                                        <label for="anaesmo" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignanaes-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="anaesmo" name="anaesmo">
                                                            <option></option>
                                                            @foreach ($careprov as $staffs)
                                                                <option value="{{ $staffs->cpid }}">
                                                                    {{ $staffs->cpName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="anaesmooncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                        <input class="form-control form-control-sm" type="date" name="anaesmooncallstart" id="anaesmooncallstart">
                                                    </div>
                                                    <div class="col-md-3 p-2">
                                                        <label for="anaesmooncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                        <input class="form-control form-control-sm" type="date" name="anaesmooncallend" id="anaesmooncallend">
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
                <button type="button" class="btn btn-primary btn-sm font-weight-bold save-ocanaes mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>
