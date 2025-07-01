<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

//models
use App\Models\UserSso;
use App\Models\OncallCardiothoracicList;
use App\Models\OncallCardiologyList;
use App\Models\OncallAnaesList;
use App\Models\OncallOtherList;
use App\Models\OncallNurseManagerList;
use App\Models\OncallPchcList;
use App\Models\OncallStaffAssignmentList;
use App\Models\OncallResponseTeamList;
use App\Models\WardLocation;
use App\Models\Careprovider;



use Auth;
use Carbon\Carbon;


class OnCallAssignmentController extends Controller
{
    public function index(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function indexCT(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index.cardiothoracic', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function indexCD(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index.cardiology', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function indexNM(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index.nmanager', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function indexAnaes(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index.anaes', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function indexPchc(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index.pchc', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function indexOther(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index.other', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function indexSa(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index.sa', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function indexErt(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $careprov = Careprovider::where('status_id', 2)->get();
        $ward = WardLocation::all();

        return view('oncall.index.ert', compact(
            'sso', 
            'ward', 
            'careprov', 
        ));
    }

    public function saveAssignedCT(Request $request)
    {
        try 
        {

            // dd($request->all());
            if ($request->ctconsultant != null && $request->oncallstartcons != null && $request->oncallendcons != null) {

                $user = Careprovider::where('cpid', $request->ctconsultant)->select('cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->oncallstartcons)->startOfDay();
                    $endDate = Carbon::parse($request->oncallendcons)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallCardiothoracicList::where('position_type', "consultant")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->ctconsultant;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeocctconsultant                = new OncallCardiothoracicList();
                            $storeocctconsultant->user_cp_id   = $request->ctconsultant;
                            $storeocctconsultant->name          = $user->cpName;
                            $storeocctconsultant->oncall_date   = $startDate->toDateString();
                            $storeocctconsultant->position_type = "consultant";
                            $storeocctconsultant->status_id     = 2;
                            $storeocctconsultant->created_by    = Auth::user()->id;
                            $storeocctconsultant->created_at    = Carbon::now();
                            $storeocctconsultant->updated_by    = Auth::user()->id;
                            $storeocctconsultant->updated_at    = Carbon::now();
                            $storeocctconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }
             
            
            if ($request->ctfirstcall != null && $request->oncallstartfirst != null && $request->oncallendfirst != null) {

                $user = Careprovider::where('cpid', $request->ctfirstcall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->oncallstartfirst)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendfirst)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordfirst = OncallCardiothoracicList::where('position_type', "firstcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordfirst) {

                            $existingRecordfirst->user_cp_id        = $request->ctfirstcall;
                            $existingRecordfirst->name               = $user->cpName;
                            $existingRecordfirst->updated_by         = Auth::user()->id;
                            $existingRecordfirst->updated_at         = Carbon::now();
                            $existingRecordfirst->save();

                        } else {

                            $storeocctfirstcall                = new OncallCardiothoracicList();
                            $storeocctfirstcall->user_cp_id   = $request->ctfirstcall;
                            $storeocctfirstcall->name          = $user->cpName;
                            $storeocctfirstcall->oncall_date   = $startDate->toDateString(); 
                            $storeocctfirstcall->position_type = "firstcall";
                            $storeocctfirstcall->status_id     = 2;
                            $storeocctfirstcall->created_by    = Auth::user()->id;
                            $storeocctfirstcall->created_at    = Carbon::now();
                            $storeocctfirstcall->updated_by    = Auth::user()->id;
                            $storeocctfirstcall->updated_at    = Carbon::now();
                            $storeocctfirstcall->save();

                        }
    
                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->ctsecondcall != null && $request->oncallstartsec != null && $request->oncallendsec != null) {

                $user = Careprovider::where('cpid', $request->ctsecondcall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->oncallstartsec)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendsec)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsec = OncallCardiothoracicList::where('position_type', "secondcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsec) {

                            $existingRecordsec->user_cp_id        = $request->ctsecondcall;
                            $existingRecordsec->name               = $user->cpName;
                            $existingRecordsec->updated_by         = Auth::user()->id;
                            $existingRecordsec->updated_at         = Carbon::now();
                            $existingRecordsec->save();

                        } else {

                            $storeocctseccall                = new OncallCardiothoracicList();
                            $storeocctseccall->user_cp_id   = $request->ctsecondcall;
                            $storeocctseccall->name          = $user->cpName;
                            $storeocctseccall->oncall_date   = $startDate->toDateString(); 
                            $storeocctseccall->position_type = "secondcall";
                            $storeocctseccall->status_id     = 2;
                            $storeocctseccall->created_by    = Auth::user()->id;
                            $storeocctseccall->created_at    = Carbon::now();
                            $storeocctseccall->updated_by    = Auth::user()->id;
                            $storeocctseccall->updated_at    = Carbon::now();
                            $storeocctseccall->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->ctthirdcall != null && $request->oncallstartthird != null && $request->oncallendthird != null) {

                $user = Careprovider::where('cpid', $request->ctthirdcall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->oncallstartthird)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendthird)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsthird = OncallCardiothoracicList::where('position_type', "thirdcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsthird) {

                            $existingRecordsthird->user_cp_id        = $request->ctthirdcall;
                            $existingRecordsthird->name               = $user->cpName;
                            $existingRecordsthird->updated_by         = Auth::user()->id;
                            $existingRecordsthird->updated_at         = Carbon::now();
                            $existingRecordsthird->save();

                        } else {

                            $storeocctthirdcall                = new OncallCardiothoracicList();
                            $storeocctthirdcall->user_cp_id   = $request->ctthirdcall;
                            $storeocctthirdcall->name          = $user->cpName;
                            $storeocctthirdcall->oncall_date   = $startDate->toDateString(); 
                            $storeocctthirdcall->position_type = "thirdcall";
                            $storeocctthirdcall->status_id     = 2;
                            $storeocctthirdcall->created_by    = Auth::user()->id;
                            $storeocctthirdcall->created_at    = Carbon::now();
                            $storeocctthirdcall->updated_by    = Auth::user()->id;
                            $storeocctthirdcall->updated_at    = Carbon::now();
                            $storeocctthirdcall->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->cticuam != null && $request->oncallstarticuam != null && $request->oncallendicuam != null) {

                $user = Careprovider::where('cpid', $request->cticuam)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->oncallstarticuam)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendicuam)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsicuam = OncallCardiothoracicList::where('position_type', "icuam")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsicuam) {

                            $existingRecordsicuam->user_cp_id        = $request->cticuam;
                            $existingRecordsicuam->name               = $user->cpName;
                            $existingRecordsicuam->updated_by         = Auth::user()->id;
                            $existingRecordsicuam->updated_at         = Carbon::now();
                            $existingRecordsicuam->save();

                        } else {

                            $storeoccticuam                = new OncallCardiothoracicList();
                            $storeoccticuam->user_cp_id   = $request->cticuam;
                            $storeoccticuam->name          = $user->cpName;
                            $storeoccticuam->oncall_date   = $startDate->toDateString(); 
                            $storeoccticuam->position_type = "icuam";
                            $storeoccticuam->status_id     = 2;
                            $storeoccticuam->created_by    = Auth::user()->id;
                            $storeoccticuam->created_at    = Carbon::now();
                            $storeoccticuam->updated_by    = Auth::user()->id;
                            $storeoccticuam->updated_at    = Carbon::now();
                            $storeoccticuam->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->cticupm != null && $request->oncallstarticupm != null && $request->oncallendicupm != null) {

                $user = Careprovider::where('cpid', $request->cticupm)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->oncallstarticupm)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendicupm)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsicupm = OncallCardiothoracicList::where('position_type', "icupm")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsicupm) {

                            $existingRecordsicupm->user_cp_id        = $request->cticupm;
                            $existingRecordsicupm->name               = $user->cpName;
                            $existingRecordsicupm->updated_by         = Auth::user()->id;
                            $existingRecordsicupm->updated_at         = Carbon::now();
                            $existingRecordsicupm->save();

                        } else {

                            $storeoccticupm                = new OncallCardiothoracicList();
                            $storeoccticupm->user_cp_id   = $request->cticupm;
                            $storeoccticupm->name          = $user->cpName;
                            $storeoccticupm->oncall_date   = $startDate->toDateString(); 
                            $storeoccticupm->position_type = "icupm";
                            $storeoccticupm->status_id     = 2;
                            $storeoccticupm->created_by    = Auth::user()->id;
                            $storeoccticupm->created_at    = Carbon::now();
                            $storeoccticupm->updated_by    = Auth::user()->id;
                            $storeoccticupm->updated_at    = Carbon::now();
                            $storeoccticupm->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }
             
            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function getAssignedCT(Request $request)
    {
        try 
        {
            $getCtList = OncallCardiothoracicList::where('status_id', 2)->get();
            
             
            return response()->json([
                'status' => 'success',
                'response' => $getCtList,
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function updateAssignedCT(Request $request)
    {
        try 
        {
            $user = Careprovider::where('cpid', $request->updatectstaff)->select('cpid','cpName')->first();

            $updateAssignCt                = OncallCardiothoracicList::where('id', $request->occtid)->first();
            $updateAssignCt->user_cp_id   = $user->cpid;
            $updateAssignCt->name          = $user->cpName;
            $updateAssignCt->updated_by    = Auth::user()->id;
            $updateAssignCt->updated_at    = Carbon::now();
            $updateAssignCt->save();

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function saveAssignedCD(Request $request)
    {
        try 
        {

            // dd($request->all());
            if ($request->cdcons != null && $request->cdconsoncallstart != null && $request->cdconsoncallend != null) {

                $user = Careprovider::where('cpid', $request->cdcons)->select('cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->cdconsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->cdconsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallCardiologyList::where('position_type', "consultant")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->cdcons;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallCardiologyList();
                            $storeoccdconsultant->user_cp_id   = $request->cdcons;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "consultant";
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->cdcardiologist != null && $request->cdcardiooncallstart != null && $request->cdcardiooncallend != null) {

                $user = Careprovider::where('cpid', $request->cdcardiologist)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->cdcardiooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdcardiooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordscardio = OncallCardiologyList::where('position_type', "cardiologist")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordscardio) {

                            $existingRecordscardio->user_cp_id        = $request->cdcardiologist;
                            $existingRecordscardio->name               = $user->cpName;
                            $existingRecordscardio->updated_by         = Auth::user()->id;
                            $existingRecordscardio->updated_at         = Carbon::now();
                            $existingRecordscardio->save();

                        } else {

                            $storeoccdcardiologist               = new OncallCardiologyList();
                            $storeoccdcardiologist->user_cp_id   = $request->cdcardiologist;
                            $storeoccdcardiologist->name          = $user->cpName;
                            $storeoccdcardiologist->oncall_date   = $startDate->toDateString(); 
                            $storeoccdcardiologist->position_type = "cardiologist";
                            $storeoccdcardiologist->status_id     = 2;
                            $storeoccdcardiologist->created_by    = Auth::user()->id;
                            $storeoccdcardiologist->created_at    = Carbon::now();
                            $storeoccdcardiologist->updated_by    = Auth::user()->id;
                            $storeoccdcardiologist->updated_at    = Carbon::now();
                            $storeoccdcardiologist->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }
             
            
            if ($request->cdfirstcall != null && $request->cdfirstoncallstart != null && $request->cdfirstoncallend != null) {

                $user = Careprovider::where('cpid', $request->cdfirstcall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->cdfirstoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdfirstoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordfirst = OncallCardiologyList::where('position_type', "firstcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordfirst) {

                            $existingRecordfirst->user_cp_id        = $request->cdfirstcall;
                            $existingRecordfirst->name               = $user->cpName;
                            $existingRecordfirst->updated_by         = Auth::user()->id;
                            $existingRecordfirst->updated_at         = Carbon::now();
                            $existingRecordfirst->save();

                        } else {

                            $storeoccdfirstcall                = new OncallCardiologyList();
                            $storeoccdfirstcall->user_cp_id   = $request->cdfirstcall;
                            $storeoccdfirstcall->name          = $user->cpName;
                            $storeoccdfirstcall->oncall_date   = $startDate->toDateString(); 
                            $storeoccdfirstcall->position_type = "firstcall";
                            $storeoccdfirstcall->status_id     = 2;
                            $storeoccdfirstcall->created_by    = Auth::user()->id;
                            $storeoccdfirstcall->created_at    = Carbon::now();
                            $storeoccdfirstcall->updated_by    = Auth::user()->id;
                            $storeoccdfirstcall->updated_at    = Carbon::now();
                            $storeoccdfirstcall->save();

                        }
    
                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->cdseccall != null && $request->cdseconcallstart != null && $request->cdseconcallend != null) {

                $user = Careprovider::where('cpid', $request->cdseccall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->cdseconcallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdseconcallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsec = OncallCardiologyList::where('position_type', "secondcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsec) {

                            $existingRecordsec->user_cp_id        = $request->cdseccall;
                            $existingRecordsec->name               = $user->cpName;
                            $existingRecordsec->updated_by         = Auth::user()->id;
                            $existingRecordsec->updated_at         = Carbon::now();
                            $existingRecordsec->save();

                        } else {

                            $storeoccdseccall                = new OncallCardiologyList();
                            $storeoccdseccall->user_cp_id   = $request->cdseccall;
                            $storeoccdseccall->name          = $user->cpName;
                            $storeoccdseccall->oncall_date   = $startDate->toDateString(); 
                            $storeoccdseccall->position_type = "secondcall";
                            $storeoccdseccall->status_id     = 2;
                            $storeoccdseccall->created_by    = Auth::user()->id;
                            $storeoccdseccall->created_at    = Carbon::now();
                            $storeoccdseccall->updated_by    = Auth::user()->id;
                            $storeoccdseccall->updated_at    = Carbon::now();
                            $storeoccdseccall->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            

            if ($request->cdmocall != null && $request->cdmooncallstart != null && $request->cdmooncallend != null) {

                $user = Careprovider::where('cpid', $request->cdseccall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->cdmooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdmooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsmo = OncallCardiologyList::where('position_type', "mo")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsmo) {

                            $existingRecordsmo->user_cp_id        = $request->cdmocall;
                            $existingRecordsmo->name               = $user->cpName;
                            $existingRecordsmo->updated_by         = Auth::user()->id;
                            $existingRecordsmo->updated_at         = Carbon::now();
                            $existingRecordsmo->save();

                        } else {

                            $storeoccdmo               = new OncallCardiologyList();
                            $storeoccdmo->user_cp_id   = $request->cdmocall;
                            $storeoccdmo->name          = $user->cpName;
                            $storeoccdmo->oncall_date   = $startDate->toDateString(); 
                            $storeoccdmo->position_type = "mo";
                            $storeoccdmo->status_id     = 2;
                            $storeoccdmo->created_by    = Auth::user()->id;
                            $storeoccdmo->created_at    = Carbon::now();
                            $storeoccdmo->updated_by    = Auth::user()->id;
                            $storeoccdmo->updated_at    = Carbon::now();
                            $storeoccdmo->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->cdepcall != null && $request->cdeponcallstart != null && $request->cdeponcallend != null) {

                $user = Careprovider::where('cpid', $request->cdepcall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->cdeponcallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdeponcallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsep = OncallCardiologyList::where('position_type', "ep")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsep) {

                            $existingRecordsep->user_cp_id        = $request->cdepcall;
                            $existingRecordsep->name               = $user->cpName;
                            $existingRecordsep->updated_by         = Auth::user()->id;
                            $existingRecordsep->updated_at         = Carbon::now();
                            $existingRecordsep->save();

                        } else {

                            $storeoccdep                = new OncallCardiologyList();
                            $storeoccdep->user_cp_id   = $request->cdepcall;
                            $storeoccdep->name          = $user->cpName;
                            $storeoccdep->oncall_date   = $startDate->toDateString(); 
                            $storeoccdep->position_type = "ep";
                            $storeoccdep->status_id     = 2;
                            $storeoccdep->created_by    = Auth::user()->id;
                            $storeoccdep->created_at    = Carbon::now();
                            $storeoccdep->updated_by    = Auth::user()->id;
                            $storeoccdep->updated_at    = Carbon::now();
                            $storeoccdep->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }
             
            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function getAssignedCD(Request $request)
    {
        try 
        {
            $getCdList = OncallCardiologyList::where('status_id', 2)->get();
            
             
            return response()->json([
                'status' => 'success',
                'response' => $getCdList,
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function updateAssignedCD(Request $request)
    {
        try 
        {
            $user = Careprovider::where('cpid', $request->updatecdstaff)->select('cpid','cpName')->first();

            $updateAssignCD                = OncallCardiologyList::where('id', $request->occdid)->first();
            $updateAssignCD->user_cp_id   = $user->cpid;
            $updateAssignCD->name          = $user->cpName;
            $updateAssignCD->updated_by    = Auth::user()->id;
            $updateAssignCD->updated_at    = Carbon::now();
            $updateAssignCD->save();

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function getAssignedNM(Request $request)
    {
        try 
        {
            $getList = OncallNurseManagerList::where('status_id', 2)->get();
            
             
            return response()->json([
                'status' => 'success',
                'response' => $getList,
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function saveAssignedNM(Request $request)
    {
        try 
        {

            // dd($request->all());
            if ($request->nmfirstcall != null && $request->nmfirstoncallstart != null && $request->nmfirstoncallend != null) {

                $user = Careprovider::where('cpid', $request->nmfirstcall)->select('cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->nmfirstoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->nmfirstoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecord = OncallNurseManagerList::where('position_type', "firstcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecord) {

                            $existingRecord->user_cp_id        = $request->nmfirstcall;
                            $existingRecord->name               = $user->cpName;
                            $existingRecord->updated_by         = Auth::user()->id;
                            $existingRecord->updated_at         = Carbon::now();
                            $existingRecord->save();

                        } else {

                            $storenmfc                = new OncallNurseManagerList();
                            $storenmfc->user_cp_id   = $request->nmfirstcall;
                            $storenmfc->name          = $user->cpName;
                            $storenmfc->oncall_date   = $startDate->toDateString();
                            $storenmfc->position_type = "firstcall";
                            $storenmfc->status_id     = 2;
                            $storenmfc->created_by    = Auth::user()->id;
                            $storenmfc->created_at    = Carbon::now();
                            $storenmfc->updated_by    = Auth::user()->id;
                            $storenmfc->updated_at    = Carbon::now();
                            $storenmfc->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->nmsecondcall != null && $request->nmseconcallstart != null && $request->nmseconcallend != null) {

                $user = Careprovider::where('cpid', $request->nmsecondcall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->nmseconcallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->nmseconcallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsseccall = OncallNurseManagerList::where('position_type', "secondcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsseccall) {

                            $existingRecordsseccall->user_cp_id        = $request->nmsecondcall;
                            $existingRecordsseccall->name               = $user->cpName;
                            $existingRecordsseccall->updated_by         = Auth::user()->id;
                            $existingRecordsseccall->updated_at         = Carbon::now();
                            $existingRecordsseccall->save();

                        } else {

                            $storeocnmseccall              = new OncallNurseManagerList();
                            $storeocnmseccall->user_cp_id   = $request->nmsecondcall;
                            $storeocnmseccall->name          = $user->cpName;
                            $storeocnmseccall->oncall_date   = $startDate->toDateString(); 
                            $storeocnmseccall->position_type = "secondcall";
                            $storeocnmseccall->status_id     = 2;
                            $storeocnmseccall->created_by    = Auth::user()->id;
                            $storeocnmseccall->created_at    = Carbon::now();
                            $storeocnmseccall->updated_by    = Auth::user()->id;
                            $storeocnmseccall->updated_at    = Carbon::now();
                            $storeocnmseccall->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }
             
            
            if ($request->nmweekendam != null && $request->nmamoncallstart != null && $request->nmamoncallend != null) {

                $user = Careprovider::where('cpid', $request->nmweekendam)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->nmamoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->nmamoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordam = OncallNurseManagerList::where('position_type', "weekendam")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordam) {

                            $existingRecordam->user_cp_id        = $request->nmweekendam;
                            $existingRecordam->name               = $user->cpName;
                            $existingRecordam->updated_by         = Auth::user()->id;
                            $existingRecordam->updated_at         = Carbon::now();
                            $existingRecordam->save();

                        } else {

                            $storeocnmam                = new OncallNurseManagerList();
                            $storeocnmam->user_cp_id   = $request->nmweekendam;
                            $storeocnmam->name          = $user->cpName;
                            $storeocnmam->oncall_date   = $startDate->toDateString(); 
                            $storeocnmam->position_type = "weekendam";
                            $storeocnmam->status_id     = 2;
                            $storeocnmam->created_by    = Auth::user()->id;
                            $storeocnmam->created_at    = Carbon::now();
                            $storeocnmam->updated_by    = Auth::user()->id;
                            $storeocnmam->updated_at    = Carbon::now();
                            $storeocnmam->save();

                        }
    
                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->nmweekendpm != null && $request->nmpmoncallstart != null && $request->nmpmoncallend != null) {

                $user = Careprovider::where('cpid', $request->nmweekendpm)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->nmpmoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->nmpmoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordpm = OncallNurseManagerList::where('position_type', "weekendpm")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordpm) {

                            $existingRecordpm->user_cp_id        = $request->nmweekendpm;
                            $existingRecordpm->name               = $user->cpName;
                            $existingRecordpm->updated_by         = Auth::user()->id;
                            $existingRecordpm->updated_at         = Carbon::now();
                            $existingRecordpm->save();

                        } else {

                            $storeocnmpm                = new OncallNurseManagerList();
                            $storeocnmpm->user_cp_id   = $request->nmweekendpm;
                            $storeocnmpm->name          = $user->cpName;
                            $storeocnmpm->oncall_date   = $startDate->toDateString(); 
                            $storeocnmpm->position_type = "weekendpm";
                            $storeocnmpm->status_id     = 2;
                            $storeocnmpm->created_by    = Auth::user()->id;
                            $storeocnmpm->created_at    = Carbon::now();
                            $storeocnmpm->updated_by    = Auth::user()->id;
                            $storeocnmpm->updated_at    = Carbon::now();
                            $storeocnmpm->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            

            if ($request->nmoncall != null && $request->nmoncallstart != null && $request->nmoncallend != null) {

                $user = Careprovider::where('cpid', $request->nmoncall)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->nmoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->nmoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsmo = OncallNurseManagerList::where('position_type', "oncall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsmo) {

                            $existingRecordsmo->user_cp_id        = $request->nmoncall;
                            $existingRecordsmo->name               = $user->cpName;
                            $existingRecordsmo->updated_by         = Auth::user()->id;
                            $existingRecordsmo->updated_at         = Carbon::now();
                            $existingRecordsmo->save();

                        } else {

                            $storeoccdmo               = new OncallNurseManagerList();
                            $storeoccdmo->user_cp_id   = $request->nmoncall;
                            $storeoccdmo->name          = $user->cpName;
                            $storeoccdmo->oncall_date   = $startDate->toDateString(); 
                            $storeoccdmo->position_type = "oncall";
                            $storeoccdmo->status_id     = 2;
                            $storeoccdmo->created_by    = Auth::user()->id;
                            $storeoccdmo->created_at    = Carbon::now();
                            $storeoccdmo->updated_by    = Auth::user()->id;
                            $storeoccdmo->updated_at    = Carbon::now();
                            $storeoccdmo->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->nm_remark != null) {

                $existingRecordsmo = OncallNurseManagerList::where('remark', '!=', null)->first();

                if ($existingRecordsmo) {

                    $existingRecordsmo->remark             = $request->nm_remark;
                    $existingRecordsmo->status_id          = $request->nm_remark_switch ?? null;
                    $existingRecordsmo->updated_by         = Auth::user()->id;
                    $existingRecordsmo->updated_at         = Carbon::now();
                    $existingRecordsmo->save();

                } else {

                    $storeoccdmo                    = new OncallNurseManagerList();
                    $storeoccdmo->remark            = $request->nm_remark;
                    $storeoccdmo->status_id         = $request->nm_remark_switch ?? null;
                    $storeoccdmo->created_by        = Auth::user()->id;
                    $storeoccdmo->created_at        = Carbon::now();
                    $storeoccdmo->updated_by        = Auth::user()->id;
                    $storeoccdmo->updated_at        = Carbon::now();
                    $storeoccdmo->save();

                }

            }

             
            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function updateAssignedNM(Request $request)
    {
        try 
        {
            $user = Careprovider::where('cpid', $request->updatenmstaff)->select('cpid','cpName')->first();

            $updateAssignCD                = OncallNurseManagerList::where('id', $request->ocnmid)->first();
            $updateAssignCD->user_cp_id   = $user->cpid;
            $updateAssignCD->name          = $user->cpName;
            $updateAssignCD->updated_by    = Auth::user()->id;
            $updateAssignCD->updated_at    = Carbon::now();
            $updateAssignCD->save();

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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
    
    public function getAssignedAnaes(Request $request)
    {
        try 
        {
            $getList = OncallAnaesList::where('status_id', 2)->get();
            
             
            return response()->json([
                'status' => 'success',
                'response' => $getList,
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function saveAssignedAnaes(Request $request)
    {
        try 
        {

            // dd($request->all());
            if ($request->anaescons != null && $request->anaesconsoncallstart != null && $request->anaesconsoncallend != null) {

                $user = Careprovider::where('cpid', $request->anaescons)->select('cpName')->first();
            
                if ($user) {
            
                    $startDate = Carbon::parse($request->anaesconsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->anaesconsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecord = OncallAnaesList::where('position_type', "consultant")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecord) {

                            $existingRecord->user_cp_id         = $request->anaescons;
                            $existingRecord->name               = $user->cpName;
                            $existingRecord->updated_by         = Auth::user()->id;
                            $existingRecord->updated_at         = Carbon::now();
                            $existingRecord->save();

                        } else {

                            $storenmfc                = new OncallAnaesList();
                            $storenmfc->user_cp_id   = $request->anaescons;
                            $storenmfc->name          = $user->cpName;
                            $storenmfc->oncall_date   = $startDate->toDateString();
                            $storenmfc->position_type = "consultant";
                            $storenmfc->status_id     = 2;
                            $storenmfc->created_by    = Auth::user()->id;
                            $storenmfc->created_at    = Carbon::now();
                            $storenmfc->updated_by    = Auth::user()->id;
                            $storenmfc->updated_at    = Carbon::now();
                            $storenmfc->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->anaessr != null && $request->anaessroncallstart != null && $request->anaessroncallend != null) {

                $user = Careprovider::where('cpid', $request->anaessr)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->anaessroncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->anaessroncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsseccall = OncallAnaesList::where('position_type', "sr")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsseccall) {

                            $existingRecordsseccall->user_cp_id        = $request->anaessr;
                            $existingRecordsseccall->name               = $user->cpName;
                            $existingRecordsseccall->updated_by         = Auth::user()->id;
                            $existingRecordsseccall->updated_at         = Carbon::now();
                            $existingRecordsseccall->save();

                        } else {

                            $storeocnmseccall                = new OncallAnaesList();
                            $storeocnmseccall->user_cp_id    = $request->anaessr;
                            $storeocnmseccall->name          = $user->cpNname;
                            $storeocnmseccall->oncall_date   = $startDate->toDateString(); 
                            $storeocnmseccall->position_type = "sr";
                            $storeocnmseccall->status_id     = 2;
                            $storeocnmseccall->created_by    = Auth::user()->id;
                            $storeocnmseccall->created_at    = Carbon::now();
                            $storeocnmseccall->updated_by    = Auth::user()->id;
                            $storeocnmseccall->updated_at    = Carbon::now();
                            $storeocnmseccall->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }
             
            
            if ($request->anaessricu != null && $request->anaessricuoncallstart != null && $request->anaessricuoncallend != null) {

                $user = Careprovider::where('cpid', $request->anaessricu)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->anaessricuoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->anaessricuoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordam = OncallAnaesList::where('position_type', "sricu")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordam) {

                            $existingRecordam->user_cp_id         = $request->anaessricu;
                            $existingRecordam->name               = $user->cpName;
                            $existingRecordam->updated_by         = Auth::user()->id;
                            $existingRecordam->updated_at         = Carbon::now();
                            $existingRecordam->save();

                        } else {

                            $storeocnmam                = new OncallAnaesList();
                            $storeocnmam->user_cp_id    = $request->anaessricu;
                            $storeocnmam->name          = $user->cpName;
                            $storeocnmam->oncall_date   = $startDate->toDateString(); 
                            $storeocnmam->position_type = "sricu";
                            $storeocnmam->status_id     = 2;
                            $storeocnmam->created_by    = Auth::user()->id;
                            $storeocnmam->created_at    = Carbon::now();
                            $storeocnmam->updated_by    = Auth::user()->id;
                            $storeocnmam->updated_at    = Carbon::now();
                            $storeocnmam->save();

                        }
    
                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->anaesmo != null && $request->anaesmooncallstart != null && $request->anaesmooncallend != null) {

                $user = Careprovider::where('cpid', $request->anaesmo)->select('cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->anaesmooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->anaesmooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordpm = OncallAnaesList::where('position_type', "mo")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordpm) {

                            $existingRecordpm->user_cp_id        = $request->anaesmo;
                            $existingRecordpm->name               = $user->cpName;
                            $existingRecordpm->updated_by         = Auth::user()->id;
                            $existingRecordpm->updated_at         = Carbon::now();
                            $existingRecordpm->save();

                        } else {

                            $storeocnmpm                = new OncallAnaesList();
                            $storeocnmpm->user_cp_id    = $request->anaesmo;
                            $storeocnmpm->name          = $user->cpName;
                            $storeocnmpm->oncall_date   = $startDate->toDateString(); 
                            $storeocnmpm->position_type = "mo";
                            $storeocnmpm->status_id     = 2;
                            $storeocnmpm->created_by    = Auth::user()->id;
                            $storeocnmpm->created_at    = Carbon::now();
                            $storeocnmpm->updated_by    = Auth::user()->id;
                            $storeocnmpm->updated_at    = Carbon::now();
                            $storeocnmpm->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }
    
            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function updateAssignedAnaes(Request $request)
    {
        try 
        {
            $user = Careprovider::where('cpid', $request->updateanaesstaff)->select('cpid','cpName')->first();

            $updateAssignCD                = OncallAnaesList::where('id', $request->ocanaesid)->first();
            $updateAssignCD->user_cp_id    = $user->cpid;
            $updateAssignCD->name          = $user->cpName;
            $updateAssignCD->updated_by    = Auth::user()->id;
            $updateAssignCD->updated_at    = Carbon::now();
            $updateAssignCD->save();

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function getAssignedPchc(Request $request)
    {
        try 
        {
            $getList = OncallPchcList::where('status_id', 2)->get();
            
             
            return response()->json([
                'status' => 'success',
                'response' => $getList,
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function saveAssignedPchc(Request $request)
    {
        try 
        {

            // dd($request->all());
            if ($request->pchccons != null && $request->pchcconsoncallstart != null && $request->pchcconsoncallend != null) {

                $user = Careprovider::where('cpid', $request->pchccons)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->pchcconsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->pchcconsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallPchcList::where('position_type', "consultant")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->pchccons;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallPchcList();
                            $storeoccdconsultant->user_cp_id   = $request->pchccons;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "consultant";
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->pchccardiologist != null && $request->pchccardiooncallstart != null && $request->pchccardiooncallend != null) {

                $user = Careprovider::where('cpid', $request->pchccardiologist)->select('cpid','cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->pchccardiooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->pchccardiooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordscardio = OncallPchcList::where('position_type', "cardiologist")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordscardio) {

                            $existingRecordscardio->user_cp_id        = $request->pchccardiologist;
                            $existingRecordscardio->name               = $user->cpName;
                            $existingRecordscardio->updated_by         = Auth::user()->id;
                            $existingRecordscardio->updated_at         = Carbon::now();
                            $existingRecordscardio->save();

                        } else {

                            $storeoccdcardiologist               = new OncallPchcList();
                            $storeoccdcardiologist->user_cp_id   = $request->pchccardiologist;
                            $storeoccdcardiologist->name          = $user->cpName;
                            $storeoccdcardiologist->oncall_date   = $startDate->toDateString(); 
                            $storeoccdcardiologist->position_type = "cardiologist";
                            $storeoccdcardiologist->status_id     = 2;
                            $storeoccdcardiologist->created_by    = Auth::user()->id;
                            $storeoccdcardiologist->created_at    = Carbon::now();
                            $storeoccdcardiologist->updated_by    = Auth::user()->id;
                            $storeoccdcardiologist->updated_at    = Carbon::now();
                            $storeoccdcardiologist->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }
            
            if ($request->pchcfirstcall != null && $request->pchcfirstoncallstart != null && $request->pchcfirstoncallend != null) {

                $user = Careprovider::where('cpid', $request->pchcfirstcall)->select('cpid','cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->pchcfirstoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->pchcfirstoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordfirst = OncallPchcList::where('position_type', "firstcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordfirst) {

                            $existingRecordfirst->user_cp_id        = $request->pchcfirstcall;
                            $existingRecordfirst->name               = $user->cpName;
                            $existingRecordfirst->updated_by         = Auth::user()->id;
                            $existingRecordfirst->updated_at         = Carbon::now();
                            $existingRecordfirst->save();

                        } else {

                            $storeoccdfirstcall                = new OncallPchcList();
                            $storeoccdfirstcall->user_cp_id   = $request->pchcfirstcall;
                            $storeoccdfirstcall->name          = $user->cpName;
                            $storeoccdfirstcall->oncall_date   = $startDate->toDateString(); 
                            $storeoccdfirstcall->position_type = "firstcall";
                            $storeoccdfirstcall->status_id     = 2;
                            $storeoccdfirstcall->created_by    = Auth::user()->id;
                            $storeoccdfirstcall->created_at    = Carbon::now();
                            $storeoccdfirstcall->updated_by    = Auth::user()->id;
                            $storeoccdfirstcall->updated_at    = Carbon::now();
                            $storeoccdfirstcall->save();

                        }
    
                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->pchcseccall != null && $request->pchcseconcallstart != null && $request->pchcseconcallend != null) {

                $user = Careprovider::where('cpid', $request->pchcseccall)->select('cpid','cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->pchcseconcallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->pchcseconcallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsec = OncallPchcList::where('position_type', "secondcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsec) {

                            $existingRecordsec->user_cp_id        = $request->pchcseccall;
                            $existingRecordsec->name               = $user->cpName;
                            $existingRecordsec->updated_by         = Auth::user()->id;
                            $existingRecordsec->updated_at         = Carbon::now();
                            $existingRecordsec->save();

                        } else {

                            $storeoccdseccall                = new OncallPchcList();
                            $storeoccdseccall->user_cp_id   = $request->pchcseccall;
                            $storeoccdseccall->name          = $user->cpName;
                            $storeoccdseccall->oncall_date   = $startDate->toDateString(); 
                            $storeoccdseccall->position_type = "secondcall";
                            $storeoccdseccall->status_id     = 2;
                            $storeoccdseccall->created_by    = Auth::user()->id;
                            $storeoccdseccall->created_at    = Carbon::now();
                            $storeoccdseccall->updated_by    = Auth::user()->id;
                            $storeoccdseccall->updated_at    = Carbon::now();
                            $storeoccdseccall->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            } 

            if ($request->pchcmocall != null && $request->pchcmooncallstart != null && $request->pchcmooncallend != null) {

                $user = Careprovider::where('cpid', $request->pchcmocall)->select('cpid','cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->pchcmooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->pchcmooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsmo = OncallPchcList::where('position_type', "mo")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsmo) {

                            $existingRecordsmo->user_cp_id        = $request->pchcmocall;
                            $existingRecordsmo->name               = $user->cpName;
                            $existingRecordsmo->updated_by         = Auth::user()->id;
                            $existingRecordsmo->updated_at         = Carbon::now();
                            $existingRecordsmo->save();

                        } else {

                            $storeoccdmo               = new OncallPchcList();
                            $storeoccdmo->user_cp_id   = $request->pchcmocall;
                            $storeoccdmo->name          = $user->cpName;
                            $storeoccdmo->oncall_date   = $startDate->toDateString(); 
                            $storeoccdmo->position_type = "mo";
                            $storeoccdmo->status_id     = 2;
                            $storeoccdmo->created_by    = Auth::user()->id;
                            $storeoccdmo->created_at    = Carbon::now();
                            $storeoccdmo->updated_by    = Auth::user()->id;
                            $storeoccdmo->updated_at    = Carbon::now();
                            $storeoccdmo->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function updateAssignedPchc(Request $request)
    {
        try 
        {
            $user = Careprovider::where('cpid', $request->updatepchcstaff)->select('cpid','cpName')->first();

            $updateAssignCD                = OncallPchcList::where('id', $request->ocpchcid)->first();
            $updateAssignCD->user_cp_id   = $user->cpid;
            $updateAssignCD->name          = $user->cpName;
            $updateAssignCD->updated_by    = Auth::user()->id;
            $updateAssignCD->updated_at    = Carbon::now();
            $updateAssignCD->save();

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function getAssignedOther(Request $request)
    {
        try 
        {
            $getList = OncallOtherList::where('status_id', 2)->get();
            
             
            return response()->json([
                'status' => 'success',
                'response' => $getList,
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function saveAssignedOther(Request $request)
    {
        try 
        {

            // dd($request->all());
            if ($request->othperf != null && $request->othperfoncallstart != null && $request->othperfoncallend != null) {

                $user = Careprovider::where('cpid', $request->othperf)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->othperfoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->othperfoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallOtherList::where('position_type', "perfusionist")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->othperf;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallOtherList();
                            $storeoccdconsultant->user_cp_id   = $request->othperf;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "perfusionist";
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->othdiet != null && $request->othdietoncallstart != null && $request->othdietoncallend != null) {

                $user = Careprovider::where('cpid', $request->othdiet)->select('cpid','cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->othdietoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->othdietoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordscardio = OncallOtherList::where('position_type', "dietitian")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordscardio) {

                            $existingRecordscardio->user_cp_id        = $request->othdiet;
                            $existingRecordscardio->name               = $user->cpName;
                            $existingRecordscardio->updated_by         = Auth::user()->id;
                            $existingRecordscardio->updated_at         = Carbon::now();
                            $existingRecordscardio->save();

                        } else {

                            $storeoccdcardiologist               = new OncallOtherList();
                            $storeoccdcardiologist->user_cp_id   = $request->othdiet;
                            $storeoccdcardiologist->name          = $user->cpName;
                            $storeoccdcardiologist->oncall_date   = $startDate->toDateString(); 
                            $storeoccdcardiologist->position_type = "dietitian";
                            $storeoccdcardiologist->status_id     = 2;
                            $storeoccdcardiologist->created_by    = Auth::user()->id;
                            $storeoccdcardiologist->created_at    = Carbon::now();
                            $storeoccdcardiologist->updated_by    = Auth::user()->id;
                            $storeoccdcardiologist->updated_at    = Carbon::now();
                            $storeoccdcardiologist->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }
            
            if ($request->othphysio != null && $request->othphysiooncallstart != null && $request->othphysiooncallend != null) {

                $user = Careprovider::where('cpid', $request->othphysio)->select('cpid','cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->othphysiooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->othphysiooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordfirst = OncallOtherList::where('position_type', "physiotherapist")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordfirst) {

                            $existingRecordfirst->user_cp_id        = $request->othphysio;
                            $existingRecordfirst->name               = $user->cpName;
                            $existingRecordfirst->updated_by         = Auth::user()->id;
                            $existingRecordfirst->updated_at         = Carbon::now();
                            $existingRecordfirst->save();

                        } else {

                            $storeoccdfirstcall                = new OncallOtherList();
                            $storeoccdfirstcall->user_cp_id   = $request->othphysio;
                            $storeoccdfirstcall->name          = $user->cpName;
                            $storeoccdfirstcall->oncall_date   = $startDate->toDateString(); 
                            $storeoccdfirstcall->position_type = "physiotherapist";
                            $storeoccdfirstcall->status_id     = 2;
                            $storeoccdfirstcall->created_by    = Auth::user()->id;
                            $storeoccdfirstcall->created_at    = Carbon::now();
                            $storeoccdfirstcall->updated_by    = Auth::user()->id;
                            $storeoccdfirstcall->updated_at    = Carbon::now();
                            $storeoccdfirstcall->save();

                        }
    
                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->othlab != null && $request->othlaboncallstart != null && $request->othlaboncallend != null) {

                $user = Careprovider::where('cpid', $request->othlab)->select('cpid','cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->othlaboncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->othlaboncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsec = OncallOtherList::where('position_type', "resplab")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsec) {

                            $existingRecordsec->user_cp_id        = $request->othlab;
                            $existingRecordsec->name               = $user->cpName;
                            $existingRecordsec->updated_by         = Auth::user()->id;
                            $existingRecordsec->updated_at         = Carbon::now();
                            $existingRecordsec->save();

                        } else {

                            $storeoccdseccall                = new OncallOtherList();
                            $storeoccdseccall->user_cp_id   = $request->othlab;
                            $storeoccdseccall->name          = $user->cpName;
                            $storeoccdseccall->oncall_date   = $startDate->toDateString(); 
                            $storeoccdseccall->position_type = "resplab";
                            $storeoccdseccall->status_id     = 2;
                            $storeoccdseccall->created_by    = Auth::user()->id;
                            $storeoccdseccall->created_at    = Carbon::now();
                            $storeoccdseccall->updated_by    = Auth::user()->id;
                            $storeoccdseccall->updated_at    = Carbon::now();
                            $storeoccdseccall->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            } 

            if ($request->othcvt != null && $request->othcvtoncallstart != null && $request->othcvtoncallend != null) {

                $user = Careprovider::where('cpid', $request->othcvt)->select('cpid','cpName')->first();

                if ($user) {

                    $startDate  = Carbon::parse($request->othcvtoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->othcvtoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsmo = OncallOtherList::where('position_type', "cvt")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsmo) {

                            $existingRecordsmo->user_cp_id        = $request->othcvt;
                            $existingRecordsmo->name               = $user->cpName;
                            $existingRecordsmo->updated_by         = Auth::user()->id;
                            $existingRecordsmo->updated_at         = Carbon::now();
                            $existingRecordsmo->save();

                        } else {

                            $storeoccdmo               = new OncallOtherList();
                            $storeoccdmo->user_cp_id   = $request->othcvt;
                            $storeoccdmo->name          = $user->cpName;
                            $storeoccdmo->oncall_date   = $startDate->toDateString(); 
                            $storeoccdmo->position_type = "cvt";
                            $storeoccdmo->status_id     = 2;
                            $storeoccdmo->created_by    = Auth::user()->id;
                            $storeoccdmo->created_at    = Carbon::now();
                            $storeoccdmo->updated_by    = Auth::user()->id;
                            $storeoccdmo->updated_at    = Carbon::now();
                            $storeoccdmo->save();

                        }

                        $startDate->addDay(); 
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function updateAssignedOther(Request $request)
    {
        try 
        {
            $user = Careprovider::where('cpid', $request->updateothstaff)->select('cpid','cpName')->first();

            // dd($request->all());

            $updateAssignCD                = OncallOtherList::where('id', $request->ocothid)->first();
            $updateAssignCD->user_cp_id    = $user->cpid;
            $updateAssignCD->name          = $user->cpName;
            $updateAssignCD->updated_by    = Auth::user()->id;
            $updateAssignCD->updated_at    = Carbon::now();
            $updateAssignCD->save();

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function getAssignedErt(Request $request)
    {
        try 
        {
            $getList = OncallResponseTeamList::where('status_id', 2)->where('ward_location', $request->ertlocation)->get();
            
            return response()->json([
                'status' => 'success',
                'response' => $getList,
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function saveAssignedErt(Request $request)
    {
        try 
        {

            if ($request->ioam != null && $request->iooncallstart != null && $request->iooncallend != null) {

                $user = Careprovider::where('cpid', $request->ioam)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->iooncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->iooncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "ioam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->ioam;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->ioam;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "ioam";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->iopm != null && $request->iooncallstart != null && $request->iooncallend != null) {

                $user = Careprovider::where('cpid', $request->iopm)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->iooncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->iooncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "iopm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->iopm;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->iopm;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "iopm";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->iooncall != null && $request->iooncallstart != null && $request->iooncallend != null) {

                $user = Careprovider::where('cpid', $request->iooncall)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->iooncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->iooncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "iooncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->iooncall;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->iooncall;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "iooncall";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->fwam != null && $request->fwoncallstart != null && $request->fwoncallend != null) {

                $user = Careprovider::where('cpid', $request->fwam)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->fwoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fwoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fwam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->fwam;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->fwam;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "fwam";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->fwpm != null && $request->fwoncallstart != null && $request->fwoncallend != null) {

                $user = Careprovider::where('cpid', $request->fwpm)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->fwoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fwoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fwpm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->fwpm;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->fwpm;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "fwpm";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->fwoncall != null && $request->fwoncallstart != null && $request->fwoncallend != null) {

                $user = Careprovider::where('cpid', $request->fwoncall)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->fwoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fwoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fwoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->fwoncall;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->fwoncall;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "fwoncall";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->fwoncall != null && $request->fwoncallstart != null && $request->fwoncallend != null) {

                $user = Careprovider::where('cpid', $request->fwoncall)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->fwoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fwoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fwoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->fwoncall;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->fwoncall;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "fwoncall";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->fsam != null && $request->fsoncallstart != null && $request->fsoncallend != null) {

                $user = Careprovider::where('cpid', $request->fsam)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->fsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fsam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->fsam;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->fsam;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "fsam";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->fspm != null && $request->fsoncallstart != null && $request->fsoncallend != null) {

                $user = Careprovider::where('cpid', $request->fspm)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->fsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fspm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->fspm;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->fspm;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "fspm";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->fsoncall != null && $request->fsoncallstart != null && $request->fsoncallend != null) {

                $user = Careprovider::where('cpid', $request->fsoncall)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->fsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fsoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->fsoncall;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_cp_id   = $request->fsoncall;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "fsoncall";
                            $storeoccdconsultant->ward_location = $request->ertwardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            $positionTypes = ['rsam', 'rspm', 'rsoncall'];

            for ($i = 1; $i <= 4; $i++) {
                foreach ($positionTypes as $type) {
                    $cpIdField = $type . $i;
                    $startField = 'rsoncallstart' . $i;
                    $endField = 'rsoncallend' . $i;

                    $cpId = $request->$cpIdField;
                    $startDateInput = $request->$startField;
                    $endDateInput = $request->$endField;

                    if ($cpId && $startDateInput && $endDateInput) {
                        $user = Careprovider::where('cpid', $cpId)->select('cpid', 'cpName')->first();

                        if (!$user) continue;

                        $startDate = Carbon::parse($startDateInput)->startOfDay();
                        $endDate = Carbon::parse($endDateInput)->startOfDay();

                        while ($startDate->lte($endDate)) {
                            $record = OncallResponseTeamList::where('position_type', $cpIdField)
                                ->where('oncall_date', $startDate->toDateString())
                                ->where('ward_location', $request->ertwardlocation)
                                ->first();

                            if ($record) {
                                $record->user_cp_id = $cpId;
                                $record->name = $user->cpName;
                                $record->updated_by = Auth::id();
                                $record->updated_at = Carbon::now();
                                $record->save();
                                
                            } else {

                                $storeertoc                 = new OncallResponseTeamList();
                                $storeertoc->user_cp_id     = $cpId;
                                $storeertoc->name           = $user->cpName;
                                $storeertoc->oncall_date    = $startDate->toDateString();
                                $storeertoc->position_type  = $cpIdField;
                                $storeertoc->ward_location  = $request->ertwardlocation;
                                $storeertoc->status_id      = 2;
                                $storeertoc->created_by     = Auth::id();
                                $storeertoc->created_at     = Carbon::now();
                                $storeertoc->updated_by     = Auth::id();
                                $storeertoc->updated_at     = Carbon::now();
                                $storeertoc->save();

                            }

                            $startDate->addDay();
                        }
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function updateAssignedErt(Request $request)
    {
        try 
        {
            $user = Careprovider::where('cpid', $request->updateertstaff)->select('cpid','cpName')->first();

            $updateAssignCD                = OncallResponseTeamList::where('id', $request->ocertid)->first();
            $updateAssignCD->user_cp_id   = $user->cpid;
            $updateAssignCD->name          = $user->cpName;
            $updateAssignCD->updated_by    = Auth::user()->id;
            $updateAssignCD->updated_at    = Carbon::now();
            $updateAssignCD->save();

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function getAssignedSa(Request $request)
    {
        try 
        {
            $getList = OncallStaffAssignmentList::where('status_id', 2)->where('ward_location', $request->salocation)->get();         
             
            return response()->json([
                'status' => 'success',
                'response' => $getList,
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function saveAssignedSa(Request $request)
    {
        try 
        {

            if ($request->tlam != null && $request->tloncallstart != null && $request->tloncallend != null) {

                $user = Careprovider::where('cpid', $request->tlam)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->tloncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->tloncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "tlam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->tlam;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_cp_id   = $request->tlam;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "tlam";
                            $storeoccdconsultant->ward_location = $request->sawardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->tlpm != null && $request->tloncallstart != null && $request->tloncallend != null) {

                $user = Careprovider::where('cpid', $request->tlpm)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->tloncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->tloncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "tlpm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->tlpm;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_cp_id   = $request->tlpm;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "tlpm";
                            $storeoccdconsultant->ward_location = $request->sawardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            if ($request->tloncall != null && $request->tloncallstart != null && $request->tloncallend != null) {

                $user = Careprovider::where('cpid', $request->tloncall)->select('cpid','cpName')->first();

                if ($user) {
            
                    $startDate = Carbon::parse($request->tloncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->tloncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "tloncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_cp_id        = $request->tloncall;
                            $existingRecordcons->name               = $user->cpName;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_cp_id   = $request->tloncall;
                            $storeoccdconsultant->name          = $user->cpName;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "tloncall";
                            $storeoccdconsultant->ward_location = $request->sawardlocation;
                            $storeoccdconsultant->status_id     = 2;
                            $storeoccdconsultant->created_by    = Auth::user()->id;
                            $storeoccdconsultant->created_at    = Carbon::now();
                            $storeoccdconsultant->updated_by    = Auth::user()->id;
                            $storeoccdconsultant->updated_at    = Carbon::now();
                            $storeoccdconsultant->save();
                        }

                        $startDate->addDay(); 
                    }
                }
            }

            $positionTypes = ['iam', 'ipm', 'ioncall'];

            for ($i = 1; $i <= 6; $i++) {
                foreach ($positionTypes as $type) {
                    $cpIdField = $type . $i;
                    $startField = 'ioncallstart' . $i;
                    $endField = 'ioncallend' . $i;
                    $remarkField   = $type . 'remark' . $i;

                    $cpId = $request->$cpIdField;
                    $startDateInput = $request->$startField;
                    $endDateInput = $request->$endField;
                    $remark         = $request->$remarkField;

                    if ($cpId && $startDateInput && $endDateInput) {
                        $user = Careprovider::where('cpid', $cpId)->select('cpid', 'cpName')->first();

                        if (!$user) continue;

                        $startDate = Carbon::parse($startDateInput)->startOfDay();
                        $endDate = Carbon::parse($endDateInput)->startOfDay();

                        while ($startDate->lte($endDate)) {
                            $record = OncallStaffAssignmentList::where('position_type', $cpIdField)
                                ->where('oncall_date', $startDate->toDateString())
                                ->where('ward_location', $request->sawardlocation)
                                ->first();

                            if ($record) {
                                $record->user_cp_id = $cpId;
                                $record->name       = $user->cpName;
                                $record->remarks     = $remark;
                                $record->updated_by = Auth::id();
                                $record->updated_at = Carbon::now();
                                $record->save();
                                
                            } else {

                                $storeertoc                 = new OncallStaffAssignmentList();
                                $storeertoc->user_cp_id     = $cpId;
                                $storeertoc->name           = $user->cpName;
                                $storeertoc->oncall_date    = $startDate->toDateString();
                                $storeertoc->position_type  = $cpIdField;
                                $storeertoc->remarks        = $remark;
                                $storeertoc->ward_location  = $request->sawardlocation;
                                $storeertoc->status_id      = 2;
                                $storeertoc->created_by     = Auth::id();
                                $storeertoc->created_at     = Carbon::now();
                                $storeertoc->updated_by     = Auth::id();
                                $storeertoc->updated_at     = Carbon::now();
                                $storeertoc->save();

                            }

                            $startDate->addDay();
                        }
                    }
                }
            }

            $positionTypesmed = ['medam', 'medpm', 'medoncall'];

            for ($i = 1; $i <= 4; $i++) {
                foreach ($positionTypesmed as $type) {
                    $cpIdField = $type . $i;
                    $startField = 'medoncallstart' . $i;
                    $endField = 'medoncallend' . $i;

                    $cpId = $request->$cpIdField;
                    $startDateInput = $request->$startField;
                    $endDateInput = $request->$endField;

                    if ($cpId && $startDateInput && $endDateInput) {
                        $user = Careprovider::where('cpid', $cpId)->select('cpid', 'cpName')->first();

                        if (!$user) continue;

                        $startDate = Carbon::parse($startDateInput)->startOfDay();
                        $endDate = Carbon::parse($endDateInput)->startOfDay();

                        while ($startDate->lte($endDate)) {
                            $record = OncallStaffAssignmentList::where('position_type', $cpIdField)
                                ->where('oncall_date', $startDate->toDateString())
                                ->where('ward_location', $request->sawardlocation)
                                ->first();

                            if ($record) {
                                $record->user_cp_id = $cpId;
                                $record->name       = $user->cpName;
                                $record->updated_by = Auth::id();
                                $record->updated_at = Carbon::now();
                                $record->save();
                                
                            } else {

                                $storeertoc                 = new OncallStaffAssignmentList();
                                $storeertoc->user_cp_id     = $cpId;
                                $storeertoc->name           = $user->cpName;
                                $storeertoc->oncall_date    = $startDate->toDateString();
                                $storeertoc->position_type  = $cpIdField;
                                $storeertoc->ward_location  = $request->sawardlocation;
                                $storeertoc->status_id      = 2;
                                $storeertoc->created_by     = Auth::id();
                                $storeertoc->created_at     = Carbon::now();
                                $storeertoc->updated_by     = Auth::id();
                                $storeertoc->updated_at     = Carbon::now();
                                $storeertoc->save();

                            }

                            $startDate->addDay();
                        }
                    }
                }
            }

            $positionTypesrun = ['runam', 'runpm', 'runoncall'];

            for ($i = 1; $i <= 6; $i++) {
                foreach ($positionTypesrun as $type) {
                    $cpIdField = $type . $i;
                    $startField = 'runoncallstart' . $i;
                    $endField = 'runoncallend' . $i;

                    $cpId = $request->$cpIdField;
                    $startDateInput = $request->$startField;
                    $endDateInput = $request->$endField;

                    if ($cpId && $startDateInput && $endDateInput) {
                        $user = Careprovider::where('cpid', $cpId)->select('cpid', 'cpName')->first();

                        if (!$user) continue;

                        $startDate = Carbon::parse($startDateInput)->startOfDay();
                        $endDate = Carbon::parse($endDateInput)->startOfDay();

                        while ($startDate->lte($endDate)) {
                            $record = OncallStaffAssignmentList::where('position_type', $cpIdField)
                                ->where('oncall_date', $startDate->toDateString())
                                ->where('ward_location', $request->sawardlocation)
                                ->first();

                            if ($record) {
                                $record->user_cp_id = $cpId;
                                $record->name       = $user->cpName;
                                $record->updated_by = Auth::id();
                                $record->updated_at = Carbon::now();
                                $record->save();
                                
                            } else {

                                $storeertoc                 = new OncallStaffAssignmentList();
                                $storeertoc->user_cp_id     = $cpId;
                                $storeertoc->name           = $user->cpName;
                                $storeertoc->oncall_date    = $startDate->toDateString();
                                $storeertoc->position_type  = $cpIdField;
                                $storeertoc->ward_location  = $request->sawardlocation;
                                $storeertoc->status_id      = 2;
                                $storeertoc->created_by     = Auth::id();
                                $storeertoc->created_at     = Carbon::now();
                                $storeertoc->updated_by     = Auth::id();
                                $storeertoc->updated_at     = Carbon::now();
                                $storeertoc->save();

                            }

                            $startDate->addDay();
                        }
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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

    public function updateAssignedSa(Request $request)
    {
        try 
        {
            $user = Careprovider::where('cpid', $request->updatesastaff)->select('cpid','cpName')->first();

            $updateAssignCD                = OncallStaffAssignmentList::where('id', $request->ocsaid)->first();
            $updateAssignCD->user_cp_id   = $user->cpid;
            $updateAssignCD->name          = $user->cpName;
            $updateAssignCD->updated_by    = Auth::user()->id;
            $updateAssignCD->updated_at    = Carbon::now();
            $updateAssignCD->save();

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);

        } 
        catch (\Exception $e) {
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
}
