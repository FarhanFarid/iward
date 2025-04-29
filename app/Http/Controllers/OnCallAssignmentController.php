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



use Auth;
use Carbon\Carbon;


class OnCallAssignmentController extends Controller
{
    public function index(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $ward = WardLocation::all();

        return view('oncall.index', compact(
            'sso', 
            'ward', 
        ));
    }

    public function saveAssignedCT(Request $request)
    {
        try 
        {

            // dd($request->all());
            if ($request->ctconsultant != null && $request->oncallstartcons != null && $request->oncallendcons != null) {

                $sso = UserSso::where('id', $request->ctconsultant)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->oncallstartcons)->startOfDay();
                    $endDate = Carbon::parse($request->oncallendcons)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallCardiothoracicList::where('position_type', "consultant")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->ctconsultant;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeocctconsultant                = new OncallCardiothoracicList();
                            $storeocctconsultant->user_sso_id   = $request->ctconsultant;
                            $storeocctconsultant->staffno       = $sso->staffno;
                            $storeocctconsultant->name          = $sso->name;
                            $storeocctconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->ctfirstcall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->oncallstartfirst)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendfirst)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordfirst = OncallCardiothoracicList::where('position_type', "firstcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordfirst) {

                            $existingRecordfirst->user_sso_id        = $request->ctfirstcall;
                            $existingRecordfirst->staffno            = $sso->staffno;
                            $existingRecordfirst->name               = $sso->name;
                            $existingRecordfirst->email              = $sso->email;
                            $existingRecordfirst->updated_by         = Auth::user()->id;
                            $existingRecordfirst->updated_at         = Carbon::now();
                            $existingRecordfirst->save();

                        } else {

                            $storeocctfirstcall                = new OncallCardiothoracicList();
                            $storeocctfirstcall->user_sso_id   = $request->ctfirstcall;
                            $storeocctfirstcall->staffno       = $sso->staffno;
                            $storeocctfirstcall->name          = $sso->name;
                            $storeocctfirstcall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->ctsecondcall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->oncallstartsec)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendsec)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsec = OncallCardiothoracicList::where('position_type', "secondcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsec) {

                            $existingRecordsec->user_sso_id        = $request->ctsecondcall;
                            $existingRecordsec->staffno            = $sso->staffno;
                            $existingRecordsec->name               = $sso->name;
                            $existingRecordsec->email              = $sso->email;
                            $existingRecordsec->updated_by         = Auth::user()->id;
                            $existingRecordsec->updated_at         = Carbon::now();
                            $existingRecordsec->save();

                        } else {

                            $storeocctseccall                = new OncallCardiothoracicList();
                            $storeocctseccall->user_sso_id   = $request->ctsecondcall;
                            $storeocctseccall->staffno       = $sso->staffno;
                            $storeocctseccall->name          = $sso->name;
                            $storeocctseccall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->ctthirdcall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->oncallstartthird)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendthird)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsthird = OncallCardiothoracicList::where('position_type', "thirdcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsthird) {

                            $existingRecordsthird->user_sso_id        = $request->ctthirdcall;
                            $existingRecordsthird->staffno            = $sso->staffno;
                            $existingRecordsthird->name               = $sso->name;
                            $existingRecordsthird->email              = $sso->email;
                            $existingRecordsthird->updated_by         = Auth::user()->id;
                            $existingRecordsthird->updated_at         = Carbon::now();
                            $existingRecordsthird->save();

                        } else {

                            $storeocctthirdcall                = new OncallCardiothoracicList();
                            $storeocctthirdcall->user_sso_id   = $request->ctthirdcall;
                            $storeocctthirdcall->staffno       = $sso->staffno;
                            $storeocctthirdcall->name          = $sso->name;
                            $storeocctthirdcall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->cticuam)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->oncallstarticuam)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendicuam)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsicuam = OncallCardiothoracicList::where('position_type', "icuam")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsicuam) {

                            $existingRecordsicuam->user_sso_id        = $request->cticuam;
                            $existingRecordsicuam->staffno            = $sso->staffno;
                            $existingRecordsicuam->name               = $sso->name;
                            $existingRecordsicuam->email              = $sso->email;
                            $existingRecordsicuam->updated_by         = Auth::user()->id;
                            $existingRecordsicuam->updated_at         = Carbon::now();
                            $existingRecordsicuam->save();

                        } else {

                            $storeoccticuam                = new OncallCardiothoracicList();
                            $storeoccticuam->user_sso_id   = $request->cticuam;
                            $storeoccticuam->staffno       = $sso->staffno;
                            $storeoccticuam->name          = $sso->name;
                            $storeoccticuam->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->cticupm)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->oncallstarticupm)->startOfDay();
                    $endDate    = Carbon::parse($request->oncallendicupm)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsicupm = OncallCardiothoracicList::where('position_type', "icupm")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsicupm) {

                            $existingRecordsicupm->user_sso_id        = $request->cticupm;
                            $existingRecordsicupm->staffno            = $sso->staffno;
                            $existingRecordsicupm->name               = $sso->name;
                            $existingRecordsicupm->email              = $sso->email;
                            $existingRecordsicupm->updated_by         = Auth::user()->id;
                            $existingRecordsicupm->updated_at         = Carbon::now();
                            $existingRecordsicupm->save();

                        } else {

                            $storeoccticupm                = new OncallCardiothoracicList();
                            $storeoccticupm->user_sso_id   = $request->cticupm;
                            $storeoccticupm->staffno       = $sso->staffno;
                            $storeoccticupm->name          = $sso->name;
                            $storeoccticupm->email         = $sso->email;
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
            $sso = UserSso::where('id', $request->updatectstaff)->select('id', 'staffno', 'name', 'email')->first();

            $updateAssignCt                = OncallCardiothoracicList::where('id', $request->occtid)->first();
            $updateAssignCt->user_sso_id   = $sso->id;
            $updateAssignCt->staffno       = $sso->staffno;
            $updateAssignCt->name          = $sso->name;
            $updateAssignCt->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->cdcons)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->cdconsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->cdconsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallCardiologyList::where('position_type', "consultant")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->cdcons;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallCardiologyList();
                            $storeoccdconsultant->user_sso_id   = $request->cdcons;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->cdcardiologist)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->cdcardiooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdcardiooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordscardio = OncallCardiologyList::where('position_type', "cardiologist")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordscardio) {

                            $existingRecordscardio->user_sso_id        = $request->cdcardiologist;
                            $existingRecordscardio->staffno            = $sso->staffno;
                            $existingRecordscardio->name               = $sso->name;
                            $existingRecordscardio->email              = $sso->email;
                            $existingRecordscardio->updated_by         = Auth::user()->id;
                            $existingRecordscardio->updated_at         = Carbon::now();
                            $existingRecordscardio->save();

                        } else {

                            $storeoccdcardiologist               = new OncallCardiologyList();
                            $storeoccdcardiologist->user_sso_id   = $request->cdcardiologist;
                            $storeoccdcardiologist->staffno       = $sso->staffno;
                            $storeoccdcardiologist->name          = $sso->name;
                            $storeoccdcardiologist->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->cdfirstcall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->cdfirstoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdfirstoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordfirst = OncallCardiologyList::where('position_type', "firstcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordfirst) {

                            $existingRecordfirst->user_sso_id        = $request->cdfirstcall;
                            $existingRecordfirst->staffno            = $sso->staffno;
                            $existingRecordfirst->name               = $sso->name;
                            $existingRecordfirst->email              = $sso->email;
                            $existingRecordfirst->updated_by         = Auth::user()->id;
                            $existingRecordfirst->updated_at         = Carbon::now();
                            $existingRecordfirst->save();

                        } else {

                            $storeoccdfirstcall                = new OncallCardiologyList();
                            $storeoccdfirstcall->user_sso_id   = $request->cdfirstcall;
                            $storeoccdfirstcall->staffno       = $sso->staffno;
                            $storeoccdfirstcall->name          = $sso->name;
                            $storeoccdfirstcall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->cdseccall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->cdseconcallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdseconcallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsec = OncallCardiologyList::where('position_type', "secondcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsec) {

                            $existingRecordsec->user_sso_id        = $request->cdseccall;
                            $existingRecordsec->staffno            = $sso->staffno;
                            $existingRecordsec->name               = $sso->name;
                            $existingRecordsec->email              = $sso->email;
                            $existingRecordsec->updated_by         = Auth::user()->id;
                            $existingRecordsec->updated_at         = Carbon::now();
                            $existingRecordsec->save();

                        } else {

                            $storeoccdseccall                = new OncallCardiologyList();
                            $storeoccdseccall->user_sso_id   = $request->cdseccall;
                            $storeoccdseccall->staffno       = $sso->staffno;
                            $storeoccdseccall->name          = $sso->name;
                            $storeoccdseccall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->cdmocall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->cdmooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdmooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsmo = OncallCardiologyList::where('position_type', "mo")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsmo) {

                            $existingRecordsmo->user_sso_id        = $request->cdmocall;
                            $existingRecordsmo->staffno            = $sso->staffno;
                            $existingRecordsmo->name               = $sso->name;
                            $existingRecordsmo->email              = $sso->email;
                            $existingRecordsmo->updated_by         = Auth::user()->id;
                            $existingRecordsmo->updated_at         = Carbon::now();
                            $existingRecordsmo->save();

                        } else {

                            $storeoccdmo               = new OncallCardiologyList();
                            $storeoccdmo->user_sso_id   = $request->cdmocall;
                            $storeoccdmo->staffno       = $sso->staffno;
                            $storeoccdmo->name          = $sso->name;
                            $storeoccdmo->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->cdepcall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->cdeponcallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->cdeponcallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsep = OncallCardiologyList::where('position_type', "ep")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsep) {

                            $existingRecordsep->user_sso_id        = $request->cdepcall;
                            $existingRecordsep->staffno            = $sso->staffno;
                            $existingRecordsep->name               = $sso->name;
                            $existingRecordsep->email              = $sso->email;
                            $existingRecordsep->updated_by         = Auth::user()->id;
                            $existingRecordsep->updated_at         = Carbon::now();
                            $existingRecordsep->save();

                        } else {

                            $storeoccdep                = new OncallCardiologyList();
                            $storeoccdep->user_sso_id   = $request->cdepcall;
                            $storeoccdep->staffno       = $sso->staffno;
                            $storeoccdep->name          = $sso->name;
                            $storeoccdep->email         = $sso->email;
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
            $sso = UserSso::where('id', $request->updatecdstaff)->select('id', 'staffno', 'name', 'email')->first();

            $updateAssignCD                = OncallCardiologyList::where('id', $request->occdid)->first();
            $updateAssignCD->user_sso_id   = $sso->id;
            $updateAssignCD->staffno       = $sso->staffno;
            $updateAssignCD->name          = $sso->name;
            $updateAssignCD->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->nmfirstcall)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->nmfirstoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->nmfirstoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecord = OncallNurseManagerList::where('position_type', "firstcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecord) {

                            $existingRecord->user_sso_id        = $request->nmfirstcall;
                            $existingRecord->staffno            = $sso->staffno;
                            $existingRecord->name               = $sso->name;
                            $existingRecord->email              = $sso->email;
                            $existingRecord->updated_by         = Auth::user()->id;
                            $existingRecord->updated_at         = Carbon::now();
                            $existingRecord->save();

                        } else {

                            $storenmfc                = new OncallNurseManagerList();
                            $storenmfc->user_sso_id   = $request->nmfirstcall;
                            $storenmfc->staffno       = $sso->staffno;
                            $storenmfc->name          = $sso->name;
                            $storenmfc->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->nmsecondcall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->nmseconcallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->nmseconcallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsseccall = OncallNurseManagerList::where('position_type', "secondcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsseccall) {

                            $existingRecordsseccall->user_sso_id        = $request->nmsecondcall;
                            $existingRecordsseccall->staffno            = $sso->staffno;
                            $existingRecordsseccall->name               = $sso->name;
                            $existingRecordsseccall->email              = $sso->email;
                            $existingRecordsseccall->updated_by         = Auth::user()->id;
                            $existingRecordsseccall->updated_at         = Carbon::now();
                            $existingRecordsseccall->save();

                        } else {

                            $storeocnmseccall              = new OncallNurseManagerList();
                            $storeocnmseccall->user_sso_id   = $request->nmsecondcall;
                            $storeocnmseccall->staffno       = $sso->staffno;
                            $storeocnmseccall->name          = $sso->name;
                            $storeocnmseccall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->nmweekendam)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->nmamoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->nmamoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordam = OncallNurseManagerList::where('position_type', "weekendam")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordam) {

                            $existingRecordam->user_sso_id        = $request->nmweekendam;
                            $existingRecordam->staffno            = $sso->staffno;
                            $existingRecordam->name               = $sso->name;
                            $existingRecordam->email              = $sso->email;
                            $existingRecordam->updated_by         = Auth::user()->id;
                            $existingRecordam->updated_at         = Carbon::now();
                            $existingRecordam->save();

                        } else {

                            $storeocnmam                = new OncallNurseManagerList();
                            $storeocnmam->user_sso_id   = $request->nmweekendam;
                            $storeocnmam->staffno       = $sso->staffno;
                            $storeocnmam->name          = $sso->name;
                            $storeocnmam->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->nmweekendpm)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->nmpmoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->nmpmoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordpm = OncallNurseManagerList::where('position_type', "weekendpm")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordpm) {

                            $existingRecordpm->user_sso_id        = $request->nmweekendpm;
                            $existingRecordpm->staffno            = $sso->staffno;
                            $existingRecordpm->name               = $sso->name;
                            $existingRecordpm->email              = $sso->email;
                            $existingRecordpm->updated_by         = Auth::user()->id;
                            $existingRecordpm->updated_at         = Carbon::now();
                            $existingRecordpm->save();

                        } else {

                            $storeocnmpm                = new OncallNurseManagerList();
                            $storeocnmpm->user_sso_id   = $request->nmweekendpm;
                            $storeocnmpm->staffno       = $sso->staffno;
                            $storeocnmpm->name          = $sso->name;
                            $storeocnmpm->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->nmoncall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->nmoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->nmoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsmo = OncallNurseManagerList::where('position_type', "oncall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsmo) {

                            $existingRecordsmo->user_sso_id        = $request->nmoncall;
                            $existingRecordsmo->staffno            = $sso->staffno;
                            $existingRecordsmo->name               = $sso->name;
                            $existingRecordsmo->email              = $sso->email;
                            $existingRecordsmo->updated_by         = Auth::user()->id;
                            $existingRecordsmo->updated_at         = Carbon::now();
                            $existingRecordsmo->save();

                        } else {

                            $storeoccdmo               = new OncallNurseManagerList();
                            $storeoccdmo->user_sso_id   = $request->nmoncall;
                            $storeoccdmo->staffno       = $sso->staffno;
                            $storeoccdmo->name          = $sso->name;
                            $storeoccdmo->email         = $sso->email;
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
            $sso = UserSso::where('id', $request->updatenmstaff)->select('id', 'staffno', 'name', 'email')->first();

            $updateAssignCD                = OncallNurseManagerList::where('id', $request->ocnmid)->first();
            $updateAssignCD->user_sso_id   = $sso->id;
            $updateAssignCD->staffno       = $sso->staffno;
            $updateAssignCD->name          = $sso->name;
            $updateAssignCD->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->anaescons)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->anaesconsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->anaesconsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecord = OncallAnaesList::where('position_type', "consultant")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecord) {

                            $existingRecord->user_sso_id        = $request->anaescons;
                            $existingRecord->staffno            = $sso->staffno;
                            $existingRecord->name               = $sso->name;
                            $existingRecord->email              = $sso->email;
                            $existingRecord->updated_by         = Auth::user()->id;
                            $existingRecord->updated_at         = Carbon::now();
                            $existingRecord->save();

                        } else {

                            $storenmfc                = new OncallAnaesList();
                            $storenmfc->user_sso_id   = $request->anaescons;
                            $storenmfc->staffno       = $sso->staffno;
                            $storenmfc->name          = $sso->name;
                            $storenmfc->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->anaessr)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->anaessroncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->anaessroncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsseccall = OncallAnaesList::where('position_type', "sr")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsseccall) {

                            $existingRecordsseccall->user_sso_id        = $request->anaessr;
                            $existingRecordsseccall->staffno            = $sso->staffno;
                            $existingRecordsseccall->name               = $sso->name;
                            $existingRecordsseccall->email              = $sso->email;
                            $existingRecordsseccall->updated_by         = Auth::user()->id;
                            $existingRecordsseccall->updated_at         = Carbon::now();
                            $existingRecordsseccall->save();

                        } else {

                            $storeocnmseccall              = new OncallAnaesList();
                            $storeocnmseccall->user_sso_id   = $request->anaessr;
                            $storeocnmseccall->staffno       = $sso->staffno;
                            $storeocnmseccall->name          = $sso->name;
                            $storeocnmseccall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->anaessricu)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->anaessricuoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->anaessricuoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordam = OncallAnaesList::where('position_type', "sricu")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordam) {

                            $existingRecordam->user_sso_id        = $request->anaessricu;
                            $existingRecordam->staffno            = $sso->staffno;
                            $existingRecordam->name               = $sso->name;
                            $existingRecordam->email              = $sso->email;
                            $existingRecordam->updated_by         = Auth::user()->id;
                            $existingRecordam->updated_at         = Carbon::now();
                            $existingRecordam->save();

                        } else {

                            $storeocnmam                = new OncallAnaesList();
                            $storeocnmam->user_sso_id   = $request->anaessricu;
                            $storeocnmam->staffno       = $sso->staffno;
                            $storeocnmam->name          = $sso->name;
                            $storeocnmam->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->anaesmo)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->anaesmooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->anaesmooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordpm = OncallAnaesList::where('position_type', "mo")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordpm) {

                            $existingRecordpm->user_sso_id        = $request->anaesmo;
                            $existingRecordpm->staffno            = $sso->staffno;
                            $existingRecordpm->name               = $sso->name;
                            $existingRecordpm->email              = $sso->email;
                            $existingRecordpm->updated_by         = Auth::user()->id;
                            $existingRecordpm->updated_at         = Carbon::now();
                            $existingRecordpm->save();

                        } else {

                            $storeocnmpm                = new OncallAnaesList();
                            $storeocnmpm->user_sso_id   = $request->anaesmo;
                            $storeocnmpm->staffno       = $sso->staffno;
                            $storeocnmpm->name          = $sso->name;
                            $storeocnmpm->email         = $sso->email;
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
            $sso = UserSso::where('id', $request->updateanaesstaff)->select('id', 'staffno', 'name', 'email')->first();

            $updateAssignCD                = OncallAnaesList::where('id', $request->ocanaesid)->first();
            $updateAssignCD->user_sso_id   = $sso->id;
            $updateAssignCD->staffno       = $sso->staffno;
            $updateAssignCD->name          = $sso->name;
            $updateAssignCD->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->pchccons)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->pchcconsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->pchcconsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallPchcList::where('position_type', "consultant")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->pchccons;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallPchcList();
                            $storeoccdconsultant->user_sso_id   = $request->pchccons;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->pchccardiologist)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->pchccardiooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->pchccardiooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordscardio = OncallPchcList::where('position_type', "cardiologist")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordscardio) {

                            $existingRecordscardio->user_sso_id        = $request->pchccardiologist;
                            $existingRecordscardio->staffno            = $sso->staffno;
                            $existingRecordscardio->name               = $sso->name;
                            $existingRecordscardio->email              = $sso->email;
                            $existingRecordscardio->updated_by         = Auth::user()->id;
                            $existingRecordscardio->updated_at         = Carbon::now();
                            $existingRecordscardio->save();

                        } else {

                            $storeoccdcardiologist               = new OncallPchcList();
                            $storeoccdcardiologist->user_sso_id   = $request->pchccardiologist;
                            $storeoccdcardiologist->staffno       = $sso->staffno;
                            $storeoccdcardiologist->name          = $sso->name;
                            $storeoccdcardiologist->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->pchcfirstcall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->pchcfirstoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->pchcfirstoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordfirst = OncallPchcList::where('position_type', "firstcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordfirst) {

                            $existingRecordfirst->user_sso_id        = $request->pchcfirstcall;
                            $existingRecordfirst->staffno            = $sso->staffno;
                            $existingRecordfirst->name               = $sso->name;
                            $existingRecordfirst->email              = $sso->email;
                            $existingRecordfirst->updated_by         = Auth::user()->id;
                            $existingRecordfirst->updated_at         = Carbon::now();
                            $existingRecordfirst->save();

                        } else {

                            $storeoccdfirstcall                = new OncallPchcList();
                            $storeoccdfirstcall->user_sso_id   = $request->pchcfirstcall;
                            $storeoccdfirstcall->staffno       = $sso->staffno;
                            $storeoccdfirstcall->name          = $sso->name;
                            $storeoccdfirstcall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->pchcseccall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->pchcseconcallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->pchcseconcallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsec = OncallPchcList::where('position_type', "secondcall")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsec) {

                            $existingRecordsec->user_sso_id        = $request->pchcseccall;
                            $existingRecordsec->staffno            = $sso->staffno;
                            $existingRecordsec->name               = $sso->name;
                            $existingRecordsec->email              = $sso->email;
                            $existingRecordsec->updated_by         = Auth::user()->id;
                            $existingRecordsec->updated_at         = Carbon::now();
                            $existingRecordsec->save();

                        } else {

                            $storeoccdseccall                = new OncallPchcList();
                            $storeoccdseccall->user_sso_id   = $request->pchcseccall;
                            $storeoccdseccall->staffno       = $sso->staffno;
                            $storeoccdseccall->name          = $sso->name;
                            $storeoccdseccall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->pchcmocall)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->pchcmooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->pchcmooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsmo = OncallPchcList::where('position_type', "mo")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsmo) {

                            $existingRecordsmo->user_sso_id        = $request->pchcmocall;
                            $existingRecordsmo->staffno            = $sso->staffno;
                            $existingRecordsmo->name               = $sso->name;
                            $existingRecordsmo->email              = $sso->email;
                            $existingRecordsmo->updated_by         = Auth::user()->id;
                            $existingRecordsmo->updated_at         = Carbon::now();
                            $existingRecordsmo->save();

                        } else {

                            $storeoccdmo               = new OncallPchcList();
                            $storeoccdmo->user_sso_id   = $request->pchcmocall;
                            $storeoccdmo->staffno       = $sso->staffno;
                            $storeoccdmo->name          = $sso->name;
                            $storeoccdmo->email         = $sso->email;
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
            $sso = UserSso::where('id', $request->updatepchcstaff)->select('id', 'staffno', 'name', 'email')->first();

            $updateAssignCD                = OncallPchcList::where('id', $request->ocpchcid)->first();
            $updateAssignCD->user_sso_id   = $sso->id;
            $updateAssignCD->staffno       = $sso->staffno;
            $updateAssignCD->name          = $sso->name;
            $updateAssignCD->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->othperf)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->othperfoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->othperfoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallOtherList::where('position_type', "perfusionist")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->othperf;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallOtherList();
                            $storeoccdconsultant->user_sso_id   = $request->othperf;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->othdiet)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->othdietoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->othdietoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordscardio = OncallOtherList::where('position_type', "dietitian")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordscardio) {

                            $existingRecordscardio->user_sso_id        = $request->othdiet;
                            $existingRecordscardio->staffno            = $sso->staffno;
                            $existingRecordscardio->name               = $sso->name;
                            $existingRecordscardio->email              = $sso->email;
                            $existingRecordscardio->updated_by         = Auth::user()->id;
                            $existingRecordscardio->updated_at         = Carbon::now();
                            $existingRecordscardio->save();

                        } else {

                            $storeoccdcardiologist               = new OncallOtherList();
                            $storeoccdcardiologist->user_sso_id   = $request->othdiet;
                            $storeoccdcardiologist->staffno       = $sso->staffno;
                            $storeoccdcardiologist->name          = $sso->name;
                            $storeoccdcardiologist->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->othphysio)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->othphysiooncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->othphysiooncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordfirst = OncallOtherList::where('position_type', "physiotherapist")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordfirst) {

                            $existingRecordfirst->user_sso_id        = $request->othphysio;
                            $existingRecordfirst->staffno            = $sso->staffno;
                            $existingRecordfirst->name               = $sso->name;
                            $existingRecordfirst->email              = $sso->email;
                            $existingRecordfirst->updated_by         = Auth::user()->id;
                            $existingRecordfirst->updated_at         = Carbon::now();
                            $existingRecordfirst->save();

                        } else {

                            $storeoccdfirstcall                = new OncallOtherList();
                            $storeoccdfirstcall->user_sso_id   = $request->othphysio;
                            $storeoccdfirstcall->staffno       = $sso->staffno;
                            $storeoccdfirstcall->name          = $sso->name;
                            $storeoccdfirstcall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->othlab)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->othlaboncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->othlaboncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsec = OncallOtherList::where('position_type', "resplab")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsec) {

                            $existingRecordsec->user_sso_id        = $request->othlab;
                            $existingRecordsec->staffno            = $sso->staffno;
                            $existingRecordsec->name               = $sso->name;
                            $existingRecordsec->email              = $sso->email;
                            $existingRecordsec->updated_by         = Auth::user()->id;
                            $existingRecordsec->updated_at         = Carbon::now();
                            $existingRecordsec->save();

                        } else {

                            $storeoccdseccall                = new OncallOtherList();
                            $storeoccdseccall->user_sso_id   = $request->othlab;
                            $storeoccdseccall->staffno       = $sso->staffno;
                            $storeoccdseccall->name          = $sso->name;
                            $storeoccdseccall->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->othcvt)->select('staffno', 'name', 'email')->first();
    
                if ($sso) {

                    $startDate  = Carbon::parse($request->othcvtoncallstart)->startOfDay();
                    $endDate    = Carbon::parse($request->othcvtoncallend)->startOfDay();
    
                    while ($startDate->lte($endDate)) {

                        $existingRecordsmo = OncallOtherList::where('position_type', "cvt")->where('oncall_date', $startDate->toDateString())->first();

                        if ($existingRecordsmo) {

                            $existingRecordsmo->user_sso_id        = $request->othcvt;
                            $existingRecordsmo->staffno            = $sso->staffno;
                            $existingRecordsmo->name               = $sso->name;
                            $existingRecordsmo->email              = $sso->email;
                            $existingRecordsmo->updated_by         = Auth::user()->id;
                            $existingRecordsmo->updated_at         = Carbon::now();
                            $existingRecordsmo->save();

                        } else {

                            $storeoccdmo               = new OncallOtherList();
                            $storeoccdmo->user_sso_id   = $request->othcvt;
                            $storeoccdmo->staffno       = $sso->staffno;
                            $storeoccdmo->name          = $sso->name;
                            $storeoccdmo->email         = $sso->email;
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
            $sso = UserSso::where('id', $request->updateothstaff)->select('id', 'staffno', 'name', 'email')->first();

            $updateAssignCD                = OncallOtherList::where('id', $request->ocothid)->first();
            $updateAssignCD->user_sso_id   = $sso->id;
            $updateAssignCD->staffno       = $sso->staffno;
            $updateAssignCD->name          = $sso->name;
            $updateAssignCD->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->ioam)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->iooncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->iooncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "ioam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->ioam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->ioam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->iopm)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->iooncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->iooncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "iopm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->iopm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->iopm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->iooncall)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->iooncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->iooncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "iooncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->iooncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->iooncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->fwam)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->fwoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fwoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fwam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->fwam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->fwam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->fwpm)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->fwoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fwoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fwpm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->fwpm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->fwpm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->fwoncall)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->fwoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fwoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fwoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->fwoncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->fwoncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->fwoncall)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->fwoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fwoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fwoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->fwoncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->fwoncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->fsam)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->fsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fsam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->fsam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->fsam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->fspm)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->fsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fspm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->fspm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->fspm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->fsoncall)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->fsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->fsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "fsoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->fsoncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->fsoncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

            if ($request->rsam != null && $request->rsoncallstart != null && $request->rsoncallend != null) {

                $sso = UserSso::where('id', $request->rsam)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->rsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->rsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "rsam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->rsam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->rsam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "rsam";
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

            if ($request->rsoncall != null && $request->rsoncallstart != null && $request->rsoncallend != null) {

                $sso = UserSso::where('id', $request->rsoncall)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->rsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->rsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "rsoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->rsoncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->rsoncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "rsoncall";
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

            if ($request->rspm != null && $request->rsoncallstart != null && $request->rsoncallend != null) {

                $sso = UserSso::where('id', $request->rspm)->select('staffno', 'name', 'email')->first();
            
                if ($sso) {
            
                    $startDate = Carbon::parse($request->rsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->rsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallResponseTeamList::where('position_type', "rspm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->ertwardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->rspm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallResponseTeamList();
                            $storeoccdconsultant->user_sso_id   = $request->rspm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "rspm";
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
            $sso = UserSso::where('id', $request->updateertstaff)->select('id', 'staffno', 'name', 'email')->first();

            $updateAssignCD                = OncallResponseTeamList::where('id', $request->ocertid)->first();
            $updateAssignCD->user_sso_id   = $sso->id;
            $updateAssignCD->staffno       = $sso->staffno;
            $updateAssignCD->name          = $sso->name;
            $updateAssignCD->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->tlam)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->tloncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->tloncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "tlam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->tlam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->tlam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->tlpm)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->tloncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->tloncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "tlpm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->tlpm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->tlpm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

                $sso = UserSso::where('id', $request->tloncall)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->tloncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->tloncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "tloncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->tloncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->tloncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
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

            if ($request->iam != null && $request->ioncallstart != null && $request->ioncallend != null) {

                $sso = UserSso::where('id', $request->iam)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->ioncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->ioncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "iam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->iam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->iam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "iam";
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

            if ($request->ipm != null && $request->ioncallstart != null && $request->ioncallend != null) {

                $sso = UserSso::where('id', $request->ipm)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->ioncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->ioncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "ipm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->ipm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->ipm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "ipm";
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

            if ($request->ioncall != null && $request->ioncallstart != null && $request->ioncallend != null) {

                $sso = UserSso::where('id', $request->ioncall)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->ioncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->ioncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "ioncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->ioncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->ioncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "ioncall";
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

            if ($request->medam != null && $request->medoncallstart != null && $request->medoncallend != null) {

                $sso = UserSso::where('id', $request->medam)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->medoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->medoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "medam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->medam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->medam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "medam";
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

            if ($request->medpm != null && $request->medoncallstart != null && $request->medoncallend != null) {

                $sso = UserSso::where('id', $request->medpm)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->medoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->medoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "medpm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->medpm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->medpm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "medpm";
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

            if ($request->medoncall != null && $request->medoncallstart != null && $request->medoncallend != null) {

                $sso = UserSso::where('id', $request->medoncall)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->medoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->medoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "medoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->medoncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->medoncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "medoncall";
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

            if ($request->runam != null && $request->runoncallstart != null && $request->runoncallend != null) {

                $sso = UserSso::where('id', $request->runam)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->runoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->runoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "runam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->runam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->runam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "runam";
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

            if ($request->runpm != null && $request->runoncallstart != null && $request->runoncallend != null) {

                $sso = UserSso::where('id', $request->runpm)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->runoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->runoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "runpm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->runpm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->runpm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "runpm";
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

            if ($request->runoncall != null && $request->runoncallstart != null && $request->runoncallend != null) {

                $sso = UserSso::where('id', $request->runoncall)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->runoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->runoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "runoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->runoncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->runoncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "runoncall";
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

            if ($request->obsam != null && $request->obsoncallstart != null && $request->obsoncallend != null) {

                $sso = UserSso::where('id', $request->obsam)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->obsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->obsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "obsam")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->obsam;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->obsam;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "obsam";
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

            if ($request->obspm != null && $request->obsoncallstart != null && $request->obsoncallend != null) {

                $sso = UserSso::where('id', $request->obspm)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->obsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->obsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "obspm")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->obspm;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->obspm;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "obspm";
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

            if ($request->obsoncall != null && $request->obsoncallstart != null && $request->obsoncallend != null) {

                $sso = UserSso::where('id', $request->obsoncall)->select('staffno', 'name', 'email')->first();

                if ($sso) {
            
                    $startDate = Carbon::parse($request->obsoncallstart)->startOfDay();
                    $endDate = Carbon::parse($request->obsoncallend)->startOfDay();

            
                    while ($startDate->lte($endDate)) {
            
                        $existingRecordcons = OncallStaffAssignmentList::where('position_type', "obsoncall")->where('oncall_date', $startDate->toDateString())->where('ward_location', $request->sawardlocation)->first();

                        if ($existingRecordcons) {

                            $existingRecordcons->user_sso_id        = $request->obsoncall;
                            $existingRecordcons->staffno            = $sso->staffno;
                            $existingRecordcons->name               = $sso->name;
                            $existingRecordcons->email              = $sso->email;
                            $existingRecordcons->updated_by         = Auth::user()->id;
                            $existingRecordcons->updated_at         = Carbon::now();
                            $existingRecordcons->save();

                        } else {

                            $storeoccdconsultant                = new OncallStaffAssignmentList();
                            $storeoccdconsultant->user_sso_id   = $request->obsoncall;
                            $storeoccdconsultant->staffno       = $sso->staffno;
                            $storeoccdconsultant->name          = $sso->name;
                            $storeoccdconsultant->email         = $sso->email;
                            $storeoccdconsultant->oncall_date   = $startDate->toDateString();
                            $storeoccdconsultant->position_type = "obsoncall";
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
            $sso = UserSso::where('id', $request->updatesastaff)->select('id', 'staffno', 'name', 'email')->first();

            $updateAssignCD                = OncallStaffAssignmentList::where('id', $request->ocsaid)->first();
            $updateAssignCD->user_sso_id   = $sso->id;
            $updateAssignCD->staffno       = $sso->staffno;
            $updateAssignCD->name          = $sso->name;
            $updateAssignCD->email         = $sso->email;
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
