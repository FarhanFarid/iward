@extends('layouts.master')

@section('content')

<div class="row mb-2 d-flex align-items-stretch">
    <div class="col-md-12 d-flex flex-column">
        <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #FFF0F5;">
            <div class="row m-3 align-items-center">
                <div class="col-md-10 d-flex justify-content-center">
                    <h4 style="padding: 0.5rem !important; margin-bottom: 0px !important; color: #0f0f0f; padding-left:150px !important;">
                        <span>•</span> WELCOME TO eWARD DASHBOARD <span>•</span>
                    </h4>
                </div>
                <div class="col-md-2 d-flex justify-content-end">
                    <form method="GET" style="width: 100% !important;">
                        <select class="form-select w-auto" data-control="select2" data-placeholder="Select an option" id="wardcode" name="wardcode" onchange="this.form.submit()"> 
                            @foreach ($wardlist as $ward)
                                <option value="{{ $ward->location_code }}" {{ ($selectedWardCode == $ward->location_code) ? 'selected' : '' }}>
                                    {{ $ward->location_name }} ({{ $ward->location_code }})
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
        
        <br/>
    </div>
</div>

<div class="row mb-3 g-4">
    <!-- Hospital Summary Card -->
    <div class="col-md-3 d-flex">
        <div class="card flex-fill text-white" style="background-color: #b7fffa; max-height: 160px;">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-center">
                    <div class="bg-white text-dark px-5 py-2 rounded-pill mb-5">
                        <span style="font-size:14px; font-weight: 600;">Hospital Summary</span>
                    </div>
                </div>
                <div class="text-start text-dark ps-3" style="font-size: 12px; font-weight: 500;">
                    <div>Hospital: <strong >{{$results['Hospital']}}</strong></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div>Cardiology:</div>
                            <ul class="mb-2 ps-3">
                                <li>Total: <strong>{{$results["Cardiology"]}}</strong></li>
                                <li>Adult: <strong>{{$results["Cardiology - Adult"]}}</strong></li>
                                <li>Paeds: <strong>{{$results["Cardiology - Paed"]}}</strong></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div>Cardiothoracic:</div>
                            <ul class="ps-3">
                                <li>Total: <strong>{{$results["Cardiothoracic"]}}</strong></li>
                                <li>Adult: <strong>{{$results["C/Thoracic - Adult"]}}</strong></li>
                                <li>Paeds: <strong>{{$results["C/Thoracic - Paed"]}}</strong></li>
                            </ul>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </div>

    <!-- Total EBM -->
    <div class="col-md-3 d-flex">
        <div class="card flex-fill text-white" style="background-color: #8fb6ff; max-height: 160px;">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-center">
                    <div class="bg-white text-dark px-5 py-2 rounded-pill mb-5">
                        <span style="font-size:14px; font-weight: 600;">Est. Discharge</span>
                    </div>
                </div>
                <div class="text-start text-dark ps-3" style="font-size: 12px; font-weight: 500;">
                    @foreach ($cardData as $card)
                    <div>Today: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['dischargeToday'] }}">0</strong></div>
                    <div>Tommorow: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['dischargeTomorrow'] }}">0</strong></div>
                    <div>3-7 Days: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['discharge3to7'] }}">0</strong></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Administer -->
    <div class="col-md-3 d-flex">
        <div class="card flex-fill text-white" style="background-color: #f6c6ff; max-height: 160px;">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-center">
                    <div class="bg-white text-dark px-5 py-2 rounded-pill mb-5">
                        <span style="font-size:14px; font-weight: 600;">Availability</span>
                    </div>
                </div>
                <div class="text-start text-dark ps-3" style="font-size: 12px; font-weight: 500;">
                    @foreach ($cardData as $card)
                    <div>Total Bed: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['total'] }}">0</strong></div>
                    <div>Occupied: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['occupied'] }}">0</strong></div>
                    <div>Unoccupied: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['total'] - $card['occupied'] - $card['unavailable'] }}">0</strong></div>
                    <div>Unavailable: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['unavailable'] }}">0</strong></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Administered -->
    <div class="col-md-3 d-flex">
        <div class="card flex-fill text-white" style="background-color: #ffe5b4; max-height: 160px;">
            <div class="card-body pt-3">
                <div class="d-flex justify-content-center">
                    <div class="bg-white text-dark px-5 py-2 rounded-pill mb-5">
                        <span style="font-size:14px; font-weight: 600;">Occupancy</span>
                    </div>
                </div>
                <div class="text-start text-dark ps-3" style="font-size: 12px; font-weight: 500;">
                    @foreach ($cardData as $card)
                    <div>Total Inward: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['occupied'] + $card['nursePatients']}}">0</strong></div>
                    <div>Bed: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['occupied'] }}">0</strong></div>
                    <div>Nurse Station: <strong data-kt-countup="true" data-kt-countup-value="{{ $card['nursePatients'] }}">0</strong></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5 mb-3 d-flex align-items-stretch">
    <div class="col-md-12 d-flex flex-column">
        <div class="card card-custom gutter-b flex-grow-1 d-flex flex-column" style="box-shadow: 0px 2px 6px 2px #dcdcdc !important; border-radius: 0px !important; background-color: #F8F8FF;">
            <div class="row">
                <div class="col-md-12 mb-2">
                    {{-- <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #fff0f8;">
                        <div class="row m-3">
                            <div class="col-md-12">
                                <h4 style="padding: 0.5rem !important; margin-bottom: 0px !important; color: black;">
                                    SUMMARY (
                                    @php
                                        $summaryList = [];
                                        foreach ($results as $label => $value) {
                                            $summaryList[] = "$label: $value";
                                        }
                                        echo implode(', &nbsp', $summaryList);
                                    @endphp
                                    )
                                </h4>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <br/> --}}
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="bedmanagement-table" style="width: 100% !important;">
                            <thead class="thead-light">
                                <tr>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Bed No.')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Today')}}</th>
                                    <th style="color: #DB7093; min-width: 200px; text-align: center;  vertical-align: middle;">{{__('Tommorow')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('3-7 Days')}}</th>
                                    <th style="color: #DB7093; min-width: 200px; text-align: center;  vertical-align: middle;">{{__('Total')}}</th>
                                    <th style="color: #DB7093; min-width: 150px; text-align: center;  vertical-align: middle;">{{__('Occupied')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Booked')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Unavailable')}}</th>
                                    <th style="color: #DB7093; min-width: 100px; text-align: center;  vertical-align: middle;">{{__('Current')}}</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 600;">
                                @foreach ($summary as $row)
                                    <tr>
                                        <td>{{ $row['ward'] }}</td>
                                        <td>{{ $row['today'] }}</td>
                                        <td>{{ $row['tomorrow'] }}</td>
                                        <td>{{ $row['next3to7'] }}</td>
                                        <td>{{ $row['total'] }}</td>
                                        <td>{{ $row['occupied'] }}</td>
                                        <td>{{ $row['booked'] }}</td>
                                        <td>{{ $row['unavailable'] }}</td>
                                        <td>{{ $row['currentpatients'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br/>
    </div>
</div>


@endsection