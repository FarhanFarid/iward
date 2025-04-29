<div class="row mb-3 d-flex align-items-stretch">
    <div class="col-md-12 d-flex flex-column">
        <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
            <div class="d-flex justify-content-center">
                <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">EMERGENCY RESPONSE TEAM</h4>
            </div>
        </div>
        <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
            <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                <div class="row mb-3 justify-content-end">
                    <div class="col-md-2">
                        <input type="date" id="ertcalendardate" class="form-control" placeholder="Select a date">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" data-control="select2" data-placeholder="Select an option" id="ertlocation" name="ertlocation"> 
                            <option></option>
                            @foreach ($ward as $loc)
                                <option value="{{ $loc->location_code }}">
                                    {{ $loc->location_name }} ({{ $loc->location_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block assign-ert" type="button" style="width: 80% !important;">Assign On Call</button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="ert-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script src="{{ asset('js/oncall/ert.js') }}"></script>
@endpush