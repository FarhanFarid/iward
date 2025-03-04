<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OncallCardiothoracicList;

use Auth;
use Carbon\Carbon;

class WardDisplayController extends Controller
{
    public function indexb5z2(Request $request){
        $todayctlist = OncallCardiothoracicList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();

        // Initialize default values
        $roles = [
            'consultant' => '-',
            'firstcall' => '-',
            'secondcall' => '-',
            'thirdcall' => '-',
            'icuam' => '-',
            'icupm' => '-'
        ];

        // Loop through and assign names based on position_type
        foreach ($todayctlist as $staff) {
            if (isset($roles[$staff->position_type])) {
                $roles[$staff->position_type] = $staff->name;
            }
        }

        return view('display.b5z2.index', compact('roles'));
    }

    public function oncallCtSec(Request $request){
        $todayctlist = OncallCardiothoracicList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();

        // Initialize default values
        $roles = [
            'consultant' => '-',
            'firstcall' => '-',
            'secondcall' => '-',
            'thirdcall' => '-',
            'icuam' => '-',
            'icupm' => '-'
        ];

        // Loop through and assign names based on position_type
        foreach ($todayctlist as $staff) {
            if (isset($roles[$staff->position_type])) {
                $roles[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.cardiothoracic', compact('roles'));
    }


}
