<div class="card card-custom gutter-b mt-5" style="border-radius: 10px !important; background-color: #F0FFF0; border: solid; border-color: #ffffff; width: 100%; height: 200px">
    <div class="row mt-2">
        {{-- <h3 style="color: #000000; display: flex; align-items: center; justify-content: center;"><b>Cardiothoracic</b></h3>
        <hr style="width: 50%; color: #333333; margin: auto; height: 3px; border: none; background-color: #333333;"> --}}
        <div style="background-color: #c3ffc3; padding: 10px; border-radius: 10px; text-align: center; width: 80%;">
            <h1 style="color: #178217; margin: 0;"><b>CARDIOTHORACIC</b></h1>
        </div>
    </div>
    
    <div class="row mt-3 px-2">
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>Consultant &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolescd['consultant'] }}
            </span>
        </div>
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>1st Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['firstcall'] }}
            </span>
        </div>
    </div>
    <div class="row mt-1 px-2">
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>2nd Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['secondcall'] }}
            </span>
        </div>
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>3rd Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['thirdcall'] }}
            </span>
        </div>
    </div>
    <div class="row mt-1 px-2">
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>ICU AM &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['icuam'] }}
            </span>
        </div>
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>ICU PM &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['icupm'] }}
            </span>
        </div>
    </div>
    {{-- <div class="row mt-3 px-2">
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>Consultant :</b>&nbsp;&nbsp; {{ $rolesct['consultant'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>1st Call &nbsp;&nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['firstcall'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>2nd Call :</b>&nbsp;&nbsp; {{ $rolesct['secondcall'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>3rd Call &nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['thirdcall'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>ICU AM &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['icuam'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>ICU PM &nbsp;&nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesct['icupm'] }}</span>
    </div> --}}
</div>
