<div class="row mt-20 px-15" style="justify-content: center; align-items: center;">
    <div class="card card-custom gutter-b" 
        style="border-radius: 10px !important; background-color: #75e6ff; border: solid; border-color: #ffffff; width: 100%;">
        <div class="row m-3">
            <div class="col-md-12">
                <h1 style="padding: 0.5rem !important; margin-bottom: 0px !important; color: #000000; display: flex; align-items: center; justify-content: center; gap: 10px;">
                   WARD {{$getward->location_name}}
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="row mt-10 px-15" style="justify-content: center; align-items: center;">
    <div class="card card-custom" 
        style="width: 100%; min-height: 300px; border-radius: 10px; background-color: #fcefe3; border: 1px solid #ddd; padding: 1.5rem;">
        
        <h2 style="color: #444; text-align: center;"><b>Patients</b></h2>
        <br/>
        <!-- Table Start -->
        <div class="table-responsive">
            <table class="table table-bordered" style="background-color: #ffffff; border-radius: 8px;">
                <thead style="background-color: #FFB6C1;">
                    <tr>
                        <th style="text-align: center;">Bed</th>
                        <th style="text-align: center;">MRN</th>
                        <th style="text-align: center;">EP Doctor</th>
                        <th style="text-align: center;">LOS</th>
                        <th style="text-align: center;">ICON</th>
                        <th style="text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody style="background-color: #FFF0F5;">
                    @foreach($bedlist as $bed)
                        <tr>
                            <td style="text-align: center;">{{$bed['bedno']}}</td>
                            
                            @if (isset($bed['patdemo']))
                                <td style="text-align: center;">{{$bed['mrn']}}</td>
                            @else
                                <td style="text-align: center;">-</td>
                            @endif

                            @if (isset($bed['patdemo']))
                                <td style="text-align: center;">{{$bed['patdemo']['epiDoc']}}</td>
                            @else
                                <td style="text-align: center;">-</td>
                            @endif

                            @if (isset($bed['patdemo']))
                                <td style="text-align: center;">2 days</td>
                            @else
                                <td style="text-align: center;">-</td>
                            @endif

                            <td style="text-align: center;">-</td>

                            @if (isset($bed['patdemo']))
                                <td style="text-align: center;">Occupied</td>
                            @else
                                <td style="text-align: center;">Unoccupied</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mt-1" style="justify-content: left; align-items: left;">
    <div class="row">
        <span style="text-align: right; font-size: 14px; color: #555;" > {{ \Carbon\Carbon::now()->format('l, j F Y') }} </span>
    </div>
    <div class="row">
        <span style="text-align: right; font-size: 14px; color: #555;" ><b>Last Updated At :</b> 05-02-2025, 3:08 PM </span>
    </div>
</div>
