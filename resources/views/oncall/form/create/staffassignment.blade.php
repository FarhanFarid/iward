<div class="modal" id="assignsa-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Assign Staff</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="oncallsaform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">STAFF ASSIGNMENT</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                    <div class="row mb-3">
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="sawardlocation" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Ward</label>
                                                <div class="border rounded p-2">
                                                    <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="sawardlocation" name="sawardlocation"> 
                                                        <option></option>
                                                        @foreach ($ward as $loc)
                                                            <option value="{{ $loc->location_code }}">
                                                                {{ $loc->location_name }} ({{ $loc->location_code }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="tl" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Team Leader</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="tlam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="tlam" name="tlam">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="tlpm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="tlpm" name="tlpm">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="tloncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="tloncall" name="tloncall">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label for="tloncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="tloncallstart" id="tloncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="tloncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="tloncallend" id="tloncallend">
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="tl" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Incharge</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="iam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="iam" name="iam">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="ipm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="ipm" name="ipm">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="ioncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="ioncall" name="ioncall">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label for="ioncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="ioncallstart" id="ioncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="ioncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="ioncallend" id="ioncallend">
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="med" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Medication</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="medam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="medam" name="medam">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="medpm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="medpm" name="medpm">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="medoncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="medoncall" name="medoncall">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label for="medoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="medoncallstart" id="medoncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="medoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="medoncallend" id="medoncallend">
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="run" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Runner</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="runam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="runam" name="runam">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="runpm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="runpm" name="runpm">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="runoncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="runoncall" name="runoncall">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label for="runoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="runoncallstart" id="runoncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="runoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="runoncallend" id="runoncallend">
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="obs" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Observation Nurse</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="obsam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="obsam" name="obsam">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="obspm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="obspm" name="obspm">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="obsoncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="obsoncall" name="obsoncall">
                                                                <option></option>
                                                                @foreach ($sso as $staffs)
                                                                    <option value="{{ $staffs->id }}">
                                                                        {{ $staffs->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label for="obsoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="obsoncallstart" id="obsoncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="obsoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="datetime-local" name="obsoncallend" id="obsoncallend">
                                                        </div>
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
                <button type="button" class="btn btn-primary btn-sm font-weight-bold save-ocsa mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>
