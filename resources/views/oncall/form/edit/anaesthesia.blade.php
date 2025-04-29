<div class="modal" id="updateanaes-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;">Update Staff</h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="las la-times text-dark fs-2"></i>
                </div>
            </div>
            <div class="modal-body">
                <form id="updateoncallanaesform">
                    @csrf
                    <div class="row mb-3 d-flex align-items-stretch">
                        <div class="col-md-12 d-flex flex-column">
                            <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #def7ff; margin: 0 !important; padding: 0 !important;">
                                <div class="d-flex justify-content-center">
                                    <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">ANAESTHESIA</h4>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                                <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                                    <div class="row mb-3">
                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <label for="updateanaesstaff" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Staff Details</label>
                                                <div class="d-flex border">
                                                    <div class="col-md-8 p-2">
                                                        <label for="updateanaesstaff" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Name:</label>
                                                        <select class="form-select form-select-sm" data-control="select2" data-dropdown-parent="#updateanaes-modal" data-dropdown-parent="body" data-placeholder="Select an option" id="updateanaesstaff" name="updateanaesstaff">
                                                            <option></option>
                                                            @foreach ($sso as $staffs)
                                                                <option value="{{ $staffs->id }}">
                                                                    {{ $staffs->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 p-2">
                                                        <label for="updateanaesoncalldate" class="form-check-label" style="color: black; font-weight: 700; font-size: 10px;">Oncall Date:</label>
                                                        <input class="form-control form-control-sm" type="datetime-local" name="updateanaesoncalldate" id="updateanaesoncalldate" readonly>
                                                        <input class="form-control form-control-sm" type="hidden" name="ocanaesid" id="ocanaesid">
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
                <button type="button" class="btn btn-primary btn-sm font-weight-bold update-ocanaes mt-2">{{__('SAVE')}}</button>
                <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">{{ __('CLOSE') }}</button>
            </div>
        </div>
    </div>
</div>