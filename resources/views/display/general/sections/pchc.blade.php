<div class="card card-custom gutter-b mt-5" style="border-radius: 10px !important; background-color: #FFFFF0; border: solid; border-color: #ffffff; width: 100%; height: 200px">
    <div class="row mt-2">
        {{-- <h3 style="color: #000000; display: flex; align-items: center; justify-content: center;"><b>PCHC</b></h3>
        <hr style="width: 50%; color: #333333; margin: auto; height: 3px; border: none; background-color: #333333;"> --}}
        <div style="background-color: #ffffbe; padding: 10px; border-radius: 10px; text-align: center; width: 80%;">
            <h1 style="color: #4b4b13; margin: 0;"><b>PCHC</b></h1>
        </div>
    </div>
    <div class="row mt-3 px-2">
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#6f5813; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>Consultant &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['consultant'] }}
            </span>
        </div>
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#6f5813; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>Cardiologist &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['cardiologist'] }}
            </span>
        </div>
    </div>
    <div class="row mt-1 px-2">
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#6f5813; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>1st Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['firstcall'] }}
            </span>
        </div>
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#6f5813; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>2nd Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['secondcall'] }}
            </span>
        </div>
    </div>
    <div class="row mt-1 px-2">
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#6f5813; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>MO Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['mo'] }}
            </span>
        </div>
        <div class="col-md-6">
            {{-- <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>EP &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['ep'] }}
            </span> --}}
        </div>
    </div>
    {{-- <div class="row mt-3 px-2">
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>Consultant &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['consultant'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>Cardiologist :</b>&nbsp;&nbsp; {{ $rolespchc['cardiologist'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>1st Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['firstcall'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>2nd Call :</b>&nbsp;&nbsp; {{ $rolespchc['secondcall'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>MO Call &nbsp;:</b>&nbsp;&nbsp; {{ $rolespchc['mo'] }}</span>
    </div> --}}
</div>