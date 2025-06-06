@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12 mb-2">
        <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #FFF0F5;">
            <div class="row m-3">
                <div class="col-md-12">
                    <h4 style="padding: 0.5rem !important; margin-bottom: 0px !important; color: #0f0f0f; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <span>•</span> PATIENT MANAGEMENT <span>•</span>
                    </h4>
                </div>
            </div>
        </div>
        <br/>
        <div class="card card-custom gutter-b mt-3" style="border-radius: 0px !important; background-color: #f5f5f5;">
            <div class="card-body py-3 px-4">
                <h4 class="text-center fw-bold fs-4 mb-4" style="color: #333;"><u>Legend</u></h4>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/fallrisk-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600;">Fall Risk</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/inf-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Infectious Disease</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/discharge-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Discharge Today</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/dnr-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">DNR/DIL</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/ent-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Refer ENT</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/hf-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Refer Heart Failure</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/gastro-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Refer Gastrology</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/monitor-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Monitor</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/nearby-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Nearby</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/nephro-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Refer Nephrology</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/neuro-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Refer Neurology</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/resp-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">Refer Respiratory</span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <img src="{{ asset('media/logo/highrisk-logo.png') }}" class="w-50px me-2">
                        <span style="font-weight: 600">High Risk</span>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="row mb-3 d-flex align-items-stretch">
                <div class="col-md-12 d-flex flex-column">
                    <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #77dfff; margin: 0 !important; padding: 0 !important;">
                        <div class="d-flex justify-content-center">
                            <h4 class="text-center" style="padding: 0.5rem !important; margin: 0 !important; color: #000000;">Patient List</h4>
                        </div>
                    </div>
                    <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important;">
                        <div class="card-body flex-grow-1" style="padding: 0.75rem !important;">
                            <div class="row mb-5">
                                <div class="col-md-3 px-5">
                                    <select class="form-select" data-control="select2" data-placeholder="Select an option" id="patmanagelocation" name="patmanagelocation"> 
                                        <option></option>
                                        @foreach ($ward as $loc)
                                            <option value="{{ $loc->location_code }}">
                                                {{ $loc->location_name }} ({{ $loc->location_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="patient-table" style="width: 100% !important;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Bed')}}</th>
                                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('MRN')}}</th>
                                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Episode')}}</th>
                                                    <th style="color: #DB7093; min-width: 200px; text-align: center;  vertical-align: middle;">{{__('Name')}}</th>
                                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Admission Date')}}</th>
                                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loading-overlay">
    <div class="loading-icon"></div>
</div>
@include('patmanagement.subviews.flag')
@endsection

@push('script')
    <script>
        var config = {
                routes: {
                    patient : {
                            getWardPatientList: "{{ route('patmanagement.getwardpatientlist') }}",
                            savePatientFlag: "{{ route('patmanagement.savepatientflag') }}",
                            getPatientFlag: "{{ route('patmanagement.getpatientflag') }}",
                        },
                    },         
                };
    </script>
    <script src="{{ asset('js/patientmanagement/manage.js') }}"></script>
@endpush