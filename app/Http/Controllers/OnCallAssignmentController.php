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


use Auth;
use Carbon\Carbon;


class OnCallAssignmentController extends Controller
{
    public function index(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();

        return view('oncall.index', compact(
            'sso', 
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
    
}
