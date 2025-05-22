<div class="card card-custom gutter-b mt-5" style="border-radius: 10px !important; background-color: #F8F8FF; border: solid; border-color: #ffffff; width: 100%; height: 200px">
    {{-- <div class="row mt-5">
        <h3 style="color: #000000; display: flex; align-items: center; justify-content: center;"><b>Anaesthesia</b></h3>
        <hr style="width: 50%; color: #333333; margin: auto; height: 3px; border: none; background-color: #333333;">
    </div> --}}
    <div class="row mt-2">
        <div style="background-color: #adadff; padding: 10px; border-radius: 10px; text-align: center; width: 80%;">
            <h1 style="color: #191986; margin: 0;"><b>ANAESTHESIA</b></h1>
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
                <b>Consultant &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesanaes['consultant'] }}
            </span>
        </div>
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>SR &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesanaes['sr'] }}
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
                <b>SR ICU &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesanaes['sricu'] }}
            </span>
        </div>
        <div class="col-md-6">
            <span style="font-size: 1.8rem; color:#000000; font-weight: 600; 
                        display: inline-block; 
                        white-space: nowrap; 
                        overflow: hidden; 
                        text-overflow: ellipsis; 
                        width: 100%;">
                <b>MO Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesanaes['mo'] }}
            </span>
        </div>
    </div>
    {{-- <div class="row mt-3 px-2">
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>Consultant &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesanaes['consultant'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>SR :</b>&nbsp;&nbsp; {{ $rolesanaes['sr'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>SR ICU &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesanaes['sricu'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>MO Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesanaes['mo'] }}</span>
    </div> --}}
</div>