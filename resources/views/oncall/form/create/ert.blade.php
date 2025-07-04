<div class="modal" id="assignert-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 50% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Assign Staff</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="oncallertform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">EMERGENCY RESPONSE TEAM</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                    <div class="row mb-3">
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="ertwardlocation" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Ward</label>
                                                <div class="border rounded p-2">
                                                    <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-placeholder="Select an option" id="ertwardlocation" name="ertwardlocation" required> 
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
                                                <label for="io" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Incident Officer</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="ioam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="ioam" name="ioam">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="iopm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="iopm" name="iopm">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="iooncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="iooncall" name="iooncall">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label for="iooncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="date" name="iooncallstart" id="iooncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="iooncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="date" name="iooncallend" id="iooncallend">
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="fw" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Fire Warden</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="fwam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="fwam" name="fwam">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="fwpm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="fwpm" name="fwpm">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="fwoncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="fwoncall" name="fwoncall">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label for="fwoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="date" name="fwoncallstart" id="fwoncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="fwoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="date" name="fwoncallend" id="fwoncallend">
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="fs" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Fire Squad</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="fsam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="fsam" name="fsam">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="fspm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="fspm" name="fspm">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="fsoncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignert-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="fsoncall" name="fsoncall">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label for="fsoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="date" name="fsoncallstart" id="fsoncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="fsoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="date" name="fsoncallend" id="fsoncallend">
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $careprovOptions = '';
                                            foreach ($careprov as $staffs) {
                                                $careprovOptions .= '<option value="' . $staffs->cpid . '">' . $staffs->cpName . '</option>';
                                            }
                                        @endphp

                                        @for ($i = 1; $i <= 4; $i++)
                                            <div class="row mb-5" id="rescue-squad-{{ $i }}" style="{{ $i > 1 ? 'display: none;' : '' }}">
                                                <div class="col-md-12">
                                                    <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Rescue Squad {{ $i }}</label>
                                                    <div class="border rounded p-2">
                                                        <div class="row mt-2">
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignert-modal" data-placeholder="Select an option" id="rsam{{ $i }}" name="rsam{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignert-modal" data-placeholder="Select an option" id="rspm{{ $i }}" name="rspm{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignert-modal" data-placeholder="Select an option" id="rsoncall{{ $i }}" name="rsoncall{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                                <input class="form-control form-control-sm" type="date" name="rsoncallstart{{ $i }}" id="rsoncallstart{{ $i }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date End:</label>
                                                                <input class="form-control form-control-sm" type="date" name="rsoncallend{{ $i }}" id="rsoncallend{{ $i }}">
                                                            </div>
                                                        </div>
                                                        <div class="text-end mt-2">
                                                            @if ($i == 1)
                                                                {{-- Rescue Squad 1: Only + --}}
                                                                <button type="button" class="btn btn-sm btn-success show-next" data-next="2">+</button>
                                                            @elseif ($i >= 2 && $i <= 3)
                                                                {{-- Rescue Squad 2 & 3: + and - --}}
                                                                <button type="button" class="btn btn-sm btn-success show-next" data-next="{{ $i + 1 }}">+</button>
                                                                <button type="button" class="btn btn-sm btn-danger hide-prev" data-prev="{{ $i }}">-</button>
                                                            @elseif ($i == 4)
                                                                {{-- Rescue Squad 4: Only - --}}
                                                                <button type="button" class="btn btn-sm btn-danger hide-prev" data-prev="4">-</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div> 
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm font-weight-bold save-ocert mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>
