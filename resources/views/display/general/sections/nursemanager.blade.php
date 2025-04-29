<div class="card card-custom gutter-b mt-5" style="border-radius: 10px !important; background-color: #F0FFFF; border: solid; border-color: #ffffff; width: 100%; height: 200px">
    <div class="row mt-2">
        <h3 style="color: #000000; display: flex; align-items: center; justify-content: center;"><b>Nurse Manager</b></h3>
        <hr style="width: 50%; color: #333333; margin: auto; height: 3px; border: none; background-color: #333333;">
    </div>
    <div class="row mt-3 px-2">
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b><u>Weekdays</u></b></span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>1st Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesnm['firstcall'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>2nd Call :</b>&nbsp;&nbsp; {{ $rolesnm['secondcall'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b><u>Weekend</u></b></span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>AM Call &nbsp;&nbsp;:</b>&nbsp;&nbsp; {{ $rolesnm['weekendam'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>PM Call :</b>&nbsp;&nbsp; {{ $rolesnm['weekendpm'] }}</span>
        <span style="font-size: 1.3rem; color:#000000; font-weight: 600;"><b>ON Call &nbsp;:</b>&nbsp;&nbsp; {{ $rolesnm['oncall'] }}</span>
    </div>
</div>