<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OncallCardiothoracicList;
use App\Models\OncallCardiologyList;
use App\Models\OncallAnaesList;
use App\Models\OncallOtherList;
use App\Models\OncallNurseManagerList;
use App\Models\OncallPchcList;
use App\Models\OncallResponseTeamList;
use App\Models\OncallStaffAssignmentList;
use App\Models\WardLocation;


use Auth;
use Carbon\Carbon;
use Log;

class WardDisplayController extends Controller
{
    public function index(Request $request, $ward)
    {
        $ward = strtoupper($ward);
    
        $todayctlist = OncallCardiothoracicList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();
        $todaycdlist = OncallCardiologyList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();
        $todaynmlist = OncallNurseManagerList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();
        $todayanaeslist = OncallAnaesList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();
        $todaypchclist = OncallPchcList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();
        $todayothlist = OncallOtherList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();
        $todayertlist = OncallResponseTeamList::where('oncall_date', Carbon::today())->where('status_id', 2)->where('ward_location', $ward)->get();
        $todaysalist = OncallStaffAssignmentList::where('oncall_date', Carbon::today())->where('status_id', 2)->where('ward_location', $ward)->get();
    
        $getward = WardLocation::where('location_code', $ward)->first();
    
        $uri = env('BED_SEARCH');
        $client = new \GuzzleHttp\Client(['defaults' => ['verify' => false]]);
        $response = $client->request('GET', $uri);
        $content = json_decode($response->getBody(), true);
    
        // Filter the ward
        $filteredWard = null;
        foreach ($content['WardList'] as $wardData) {
            if (isset($wardData['wardcode']) && $wardData['wardcode'] === $ward) {
                $filteredWard = $wardData;
                break;
            }
        }
    
        $bedlist = []; // ✅ initialize first
    
        if ($filteredWard && isset($filteredWard['BedList'])) {
            foreach ($filteredWard['BedList'] as $bed) {
                if (isset($bed['episodeno']) && !empty($bed['episodeno'])) {
                    $epsdno = $bed['episodeno'];
                    $uripatdemo = env('PAT_DEMO') . $epsdno;
    
                    try {
                        $response = $client->request('GET', $uripatdemo);
                        if ($response->getStatusCode() == 200) {
                            $patdemoContent = json_decode($response->getBody(), true);
                            $bed['patdemo'] = $patdemoContent['data'];
                        }
                    } catch (\Exception $e) {
                        Log::error($e->getMessage(), [
                            'file' => $e->getFile(),
                            'line' => $e->getLine(),
                        ]);
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Internal error happened. Try again',
                        ], 200);
                    }
                }
    
                $bedlist[] = $bed; // ✅ even if no patdemo, still push
            }
        }
    
        $bedChunks = array_chunk($bedlist, 10); // ✅ safe to use
    
        // Initialize all role arrays
        $rolesct = ['consultant' => '-', 'firstcall' => '-', 'secondcall' => '-', 'thirdcall' => '-', 'icuam' => '-', 'icupm' => '-'];
        $rolescd = ['consultant' => '-', 'cardiologist' => '-', 'firstcall' => '-', 'secondcall' => '-', 'mo' => '-', 'ep' => '-'];
        $rolesnm = ['firstcall' => '-', 'secondcall' => '-', 'weekendam' => '-', 'weekendpm' => '-', 'oncall' => '-'];
        $rolesanaes = ['consultant' => '-', 'sr' => '-', 'sricu' => '-', 'mo' => '-'];
        $rolespchc = ['consultant' => '-', 'cardiologist' => '-', 'firstcall' => '-', 'secondcall' => '-', 'mo' => '-'];
        $rolesoth = ['perfusionist' => '-', 'dietitian' => '-', 'physiotherapist' => '-', 'resplab' => '-', 'cvt' => '-'];
        $rolesert = ['ioam' => '-', 'iopm' => '-', 'iooncall' => '-', 'fwam' => '-', 'fwpm' => '-', 'fwoncall' => '-', 'fsam' => '-', 'fspm' => '-', 'fsoncall' => '-', 'rsam' => '-', 'rspm' => '-', 'rsoncall' => '-'];
        $rolessa = ['tlam' => '-', 'tlpm' => '-', 'tloncall' => '-', 'iam' => '-', 'ipm' => '-', 'ioncall' => '-', 'medam' => '-', 'medpm' => '-', 'medoncall' => '-', 'runam' => '-', 'runpm' => '-', 'runoncall' => '-', 'obsam' => '-', 'obspm' => '-', 'obsoncall' => '-'];
    
        // Assign names to roles if matched
        foreach ($todayctlist as $staff) {
            if (isset($rolesct[$staff->position_type])) {
                $rolesct[$staff->position_type] = $staff->name;
            }
        }
    
        foreach ($todaycdlist as $staff) {
            if (isset($rolescd[$staff->position_type])) {
                $rolescd[$staff->position_type] = $staff->name;
            }
        }
    
        foreach ($todaynmlist as $staff) {
            if (isset($rolesnm[$staff->position_type])) {
                $rolesnm[$staff->position_type] = $staff->name;
            }
        }
    
        foreach ($todayanaeslist as $staff) {
            if (isset($rolesanaes[$staff->position_type])) {
                $rolesanaes[$staff->position_type] = $staff->name;
            }
        }
    
        foreach ($todaypchclist as $staff) {
            if (isset($rolespchc[$staff->position_type])) {
                $rolespchc[$staff->position_type] = $staff->name;
            }
        }
    
        foreach ($todayothlist as $staff) {
            if (isset($rolesoth[$staff->position_type])) {
                $rolesoth[$staff->position_type] = $staff->name;
            }
        }
    
        foreach ($todayertlist as $staff) {
            if (isset($rolesert[$staff->position_type])) {
                $rolesert[$staff->position_type] = $staff->name;
            }
        }
    
        foreach ($todaysalist as $staff) {
            if (isset($rolessa[$staff->position_type])) {
                $rolessa[$staff->position_type] = $staff->name;
            }
        }
    
        return view('display.index', compact(
            'rolesct',
            'rolescd',
            'rolesnm',
            'rolesanaes',
            'rolespchc',
            'rolesoth',
            'rolesert',
            'rolessa',
            'getward',
            'bedChunks',
            'bedlist'
        ));
    }    

    public function oncallCtSec(Request $request){
        $todayctlist = OncallCardiothoracicList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();

        // Initialize default values
        $rolesct = [
            'consultant' => '-',
            'firstcall' => '-',
            'secondcall' => '-',
            'thirdcall' => '-',
            'icuam' => '-',
            'icupm' => '-'
        ];

        // Loop through and assign names based on position_type
        foreach ($todayctlist as $staff) {
            if (isset($rolesct[$staff->position_type])) {
                $rolesct[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.cardiothoracic', compact('rolesct'));
    }

    public function oncallCdSec(Request $request){

        $todaycdlist = OncallCardiologyList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();

        // Initialize default values
        $rolescd = [
            'consultant' => '-',
            'cardiologist' => '-',
            'firstcall' => '-',
            'secondcall' => '-',
            'mo' => '-',
            'ep' => '-'
        ];

        // Loop through and assign names based on position_type
        foreach ($todaycdlist as $staff) {
            if (isset($rolescd[$staff->position_type])) {
                $rolescd[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.cardiology', compact('rolescd'));
    }

    public function oncallNmSec(Request $request){

        $todaynmlist = OncallNurseManagerList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();

        $rolesnm = [
            'firstcall' => '-',
            'secondcall' => '-',
            'weekendam' => '-',
            'weekendpm' => '-',
            'oncall' => '-',
        ];

        foreach ($todaynmlist as $staff) {
            if (isset($rolesnm[$staff->position_type])) {
                $rolesnm[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.nursemanager', compact('rolesnm'));
    }

    public function oncallAnaesSec(Request $request){

        $todayanaeslist = OncallAnaesList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();

        $rolesanaes = [
            'consultant' => '-',
            'sr' => '-',
            'sricu' => '-',
            'mo' => '-',
        ];

        foreach ($todayanaeslist as $staff) {
            if (isset($rolesanaes[$staff->position_type])) {
                $rolesanaes[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.anaesthesia', compact('rolesanaes'));
    }

    public function oncallPchcSec(Request $request){

        $todaypchclist = OncallPchcList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();

        $rolespchc = [
            'consultant' => '-',
            'cardiologist' => '-',
            'firstcall' => '-',
            'secondcall' => '-',
            'mo' => '-',
        ];

        foreach ($todaypchclist as $staff) {
            if (isset($rolespchc[$staff->position_type])) {
                $rolespchc[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.pchc', compact('rolespchc'));
    }
    
    public function oncallOthSec(Request $request){

        $todayothlist = OncallOtherList::where('oncall_date', Carbon::today())->where('status_id', 2)->get();

        $rolesoth = [
            'perfusionist' => '-',
            'dietitian' => '-',
            'physiotherapist' => '-',
            'resplab' => '-',
            'cvt' => '-',
        ];

        foreach ($todayothlist as $staff) {
            if (isset($rolesoth[$staff->position_type])) {
                $rolesoth[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.other', compact('rolesoth'));
    }

    public function oncallErtSec(Request $request)
    {
        $ward = strtoupper($request->get('ward'));

        $query = OncallResponseTeamList::where('oncall_date', Carbon::today())
                    ->where('status_id', 2);

        if ($ward) {
            $query->where('ward_location', $ward);
        }

        $todayertlist = $query->get();

        $rolesert = [
            'ioam' => '-',
            'iopm' => '-',
            'iooncall' => '-',
            'fwam' => '-',
            'fwpm' => '-',
            'fwoncall' => '-',
            'fsam' => '-',
            'fspm' => '-',
            'fsoncall' => '-',
            'rsam' => '-',
            'rspm' => '-',
            'rsoncall' => '-',
        ];

        foreach ($todayertlist as $staff) {
            if (isset($rolesert[$staff->position_type])) {
                $rolesert[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.ert', compact('rolesert'));
    }

    public function oncallSaSec(Request $request)
    {
        $ward = strtoupper($request->get('ward'));

        $query = OncallStaffAssignmentList::where('oncall_date', Carbon::today())
                    ->where('status_id', 2);

        if ($ward) {
            $query->where('ward_location', $ward);
        }

        $todaysalist = $query->get();

        $rolessa = [
            'tlam' => '-',
            'tlpm' => '-',
            'tloncall' => '-',
            'iam' => '-',
            'ipm' => '-',
            'ioncall' => '-',
            'medam' => '-',
            'medpm' => '-',
            'medoncall' => '-',
            'runam' => '-',
            'runpm' => '-',
            'runoncall' => '-',
            'obsam' => '-',
            'obspm' => '-',
            'obsoncall' => '-',
        ];

        foreach ($todaysalist as $staff) {
            if (isset($rolessa[$staff->position_type])) {
                $rolessa[$staff->position_type] = $staff->name;
            }
        }

        return view('display.general.sections.staffassignment', compact('rolessa'));
    }


}
