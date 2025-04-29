<div class="row mt-20 px-15" style="justify-content: center; align-items: center;">
    <div class="card card-custom gutter-b" 
        style="border-radius: 10px !important; background-color: #75e6ff; border: solid; border-color: #ffffff; width: 100%;">
        <div class="row m-3">
            <div class="col-md-12">
                <h1 style="padding: 0.5rem !important; margin-bottom: 0px !important; color: #000000; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    WARD {{ $getward->location_name ?? $ward }}
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-10 px-15" style="justify-content: center; align-items: center;">
    <div class="card card-custom" 
        style="width: 100%; border-radius: 10px; background-color: #fcefe3; border: 1px solid #ddd; padding: 1.5rem;">
        
        <h2 style="color: #444; text-align: center;"><b>Patients</b></h2>
        <br/>

        @foreach($bedChunks as $chunk)
            <div class="row mb-4">
                @foreach($chunk as $bed)
                    <div class="col-md-2 mb-3">
                        @include('display.sections.subviews.patientdetails', ['bed' => $bed])
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<div class="row mt-1 px-15">
    <div class="col-md-6">
        <span style="font-size: 14px; color: #555;">{{ \Carbon\Carbon::now()->format('l, j F Y') }}</span>
    </div>
    <div class="col-md-6 text-end">
        <span style="font-size: 14px; color: #555;"><b>Last Updated At:</b> {{ now()->format('d-m-Y, g:i A') }}</span>
    </div>
</div>
