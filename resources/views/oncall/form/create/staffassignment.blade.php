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
                                                    <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="sawardlocation" name="sawardlocation" required> 
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
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="tlpm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="tlpm" name="tlpm">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="tloncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="tloncall" name="tloncall">
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
                                                            <label for="tloncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="date" name="tloncallstart" id="tloncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="tloncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="date" name="tloncallend" id="tloncallend">
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

                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="row mb-5" id="incharge-{{ $i }}" style="{{ $i > 1 ? 'display: none;' : '' }}">
                                                <div class="col-md-12">
                                                    <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Incharge {{ $i }}</label>
                                                    <div class="border rounded p-2">
                                                        <div class="row mt-2">
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="iam{{ $i }}" name="iam{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="ipm{{ $i }}" name="ipm{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="ioncall{{ $i }}" name="ioncall{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM Staff Remark:</label>
                                                                <input class="form-control form-control-sm" type="text" name="iamremark{{ $i }}" id="iamremark{{ $i }}">

                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM Staff Remark:</label>
                                                                <input class="form-control form-control-sm" type="text" name="ipmremark{{ $i }}" id="ipmremark{{ $i }}">

                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call Staff Remark:</label>
                                                                <input class="form-control form-control-sm" type="text" name="ioncallremark{{ $i }}" id="ioncallremark{{ $i }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                                <input class="form-control form-control-sm" type="date" name="ioncallstart{{ $i }}" id="ioncallstart{{ $i }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date End:</label>
                                                                <input class="form-control form-control-sm" type="date" name="ioncallend{{ $i }}" id="ioncallend{{ $i }}">
                                                            </div>
                                                        </div>
                                                        <div class="text-end mt-2">
                                                            @if ($i == 1)
                                                                <button type="button" class="btn btn-sm btn-success show-next-incharge" data-next="2">+</button>
                                                            @elseif ($i >= 2 && $i <= 5)
                                                                <button type="button" class="btn btn-sm btn-success show-next-incharge" data-next="{{ $i + 1 }}">+</button>
                                                                <button type="button" class="btn btn-sm btn-danger hide-prev-incharge" data-prev="{{ $i }}">-</button>
                                                            @elseif ($i == 6)
                                                                <button type="button" class="btn btn-sm btn-danger hide-prev-incharge" data-prev="6">-</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        @for ($i = 1; $i <= 4; $i++)
                                            <div class="row mb-5" id="medication-{{ $i }}" style="{{ $i > 1 ? 'display: none;' : '' }}">
                                                <div class="col-md-12">
                                                    <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Medication {{ $i }}</label>
                                                    <div class="border rounded p-2">
                                                        <div class="row mt-2">
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="medam{{ $i }}" name="medam{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="medpm{{ $i }}" name="medpm{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="medoncall{{ $i }}" name="medoncall{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                                <input class="form-control form-control-sm" type="date" name="medoncallstart{{ $i }}" id="medoncallstart{{ $i }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date End:</label>
                                                                <input class="form-control form-control-sm" type="date" name="medoncallend{{ $i }}" id="medoncallend{{ $i }}">
                                                            </div>
                                                        </div>
                                                        <div class="text-end mt-2">
                                                            @if ($i == 1)
                                                                <button type="button" class="btn btn-sm btn-success show-next-medication" data-next="2">+</button>
                                                            @elseif ($i < 4)
                                                                <button type="button" class="btn btn-sm btn-success show-next-medication" data-next="{{ $i + 1 }}">+</button>
                                                                <button type="button" class="btn btn-sm btn-danger hide-prev-medication" data-prev="{{ $i }}">-</button>
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-danger hide-prev-medication" data-prev="4">-</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        @for ($i = 1; $i <= 6; $i++)
                                            <div class="row mb-5" id="runner-{{ $i }}" style="{{ $i > 1 ? 'display: none;' : '' }}">
                                                <div class="col-md-12">
                                                    <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Runner {{ $i }}</label>
                                                    <div class="border rounded p-2">
                                                        <div class="row mt-2">
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="runam{{ $i }}" name="runam{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="runpm{{ $i }}" name="runpm{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                                <select class="form-select form-select-sm select2-field" data-control="select2" data-dropdown-parent="#assignsa-modal" data-placeholder="Select an option" id="runoncall{{ $i }}" name="runoncall{{ $i }}">
                                                                    <option></option>
                                                                    {!! $careprovOptions !!}
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                                <input class="form-control form-control-sm" type="date" name="runoncallstart{{ $i }}" id="runoncallstart{{ $i }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date End:</label>
                                                                <input class="form-control form-control-sm" type="date" name="runoncallend{{ $i }}" id="runoncallend{{ $i }}">
                                                            </div>
                                                        </div>
                                                        <div class="text-end mt-2">
                                                            @if ($i == 1)
                                                                <button type="button" class="btn btn-sm btn-success show-next-runner" data-next="2">+</button>
                                                            @elseif ($i < 6)
                                                                <button type="button" class="btn btn-sm btn-success show-next-runner" data-next="{{ $i + 1 }}">+</button>
                                                                <button type="button" class="btn btn-sm btn-danger hide-prev-runner" data-prev="{{ $i }}">-</button>
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-danger hide-prev-runner" data-prev="6">-</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                        {{-- <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="obs" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Observation Nurse</label>
                                                <div class="border rounded p-2">
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="obsam" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">AM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="obsam" name="obsam">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="obspm" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">PM:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="obspm" name="obspm">
                                                                <option></option>
                                                                @foreach ($careprov as $staffs)
                                                                    <option value="{{ $staffs->cpid }}">
                                                                        {{ $staffs->cpName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="obsoncall" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">On Call:</label>
                                                            <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#assignsa-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="obsoncall" name="obsoncall">
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
                                                            <label for="obsoncallstart" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date Start:</label>
                                                            <input class="form-control form-control-sm" type="date" name="obsoncallstart" id="obsoncallstart">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="obsoncallend" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Date end:</label>
                                                            <input class="form-control form-control-sm" type="date" name="obsoncallend" id="obsoncallend">
                                                        </div>
                                                    </div>       
                                                </div>
                                            </div>
                                        </div> --}}
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
