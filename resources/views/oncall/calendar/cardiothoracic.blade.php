<div class="row mb-3 d-flex align-items-stretch">
    <div class="col-md-12 d-flex flex-column">
        <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
            <div class="d-flex justify-content-center">
                <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">CARDIOTHORACIC</h4>
            </div>
        </div>
        <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
            <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                <div class="row mb-3 justify-content-end">
                    <div class="col-md-2">
                        <input type="date" id="ctcalendardate" class="form-control" placeholder="Select a date">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block assign-ct" type="button" style="width: 80% !important;">Assign On Call</button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="cardiothoracic-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script src="{{ asset('js/oncall/cardiothoracic.js') }}"></script>
@endpush
