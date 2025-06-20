<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\UserSso;
use App\Models\WardLocation;
use App\Models\PatientManagements;
use App\Models\ProcedureList;

use Auth;
use Carbon\Carbon;
class PatManagementController extends Controller
{
    public function index(Request $request){

        $sso = UserSso::where('status_id', 2)->select('id', 'name')->get();
        $ward = WardLocation::all();

        return view('patmanagement.index', compact(
            'sso', 
            'ward', 
        ));

    }

    public function getWardPatientList(Request $request)
    {
        $wardCode = $request->input('wardcode');

        $uri = env('BED_SEARCH');
        $client = new \GuzzleHttp\Client(['defaults' => ['verify' => false]]);
        $response = $client->request('GET', $uri);
        $content = json_decode($response->getBody(), true);

        $filtered = collect($content['WardList'])->firstWhere('wardcode', $wardCode);

        $bedList = $filtered['BedList'] ?? [];
        $nurseStations = $filtered['NurseStation'] ?? [];

        $nurseStations = collect($nurseStations)->map(function ($ns) {
            $ns['bedno'] = 'Nurse Station';
            return $ns;
        });

        $combinedList = array_merge($bedList, $nurseStations->toArray());

        return response()->json([
            'status' => 'success',
            'data' => $combinedList,
        ], 200);

    }

    public function savePatientFlag(Request $request){

        try 
        {

            // dd($request->all());

            $existingRecord = PatientManagements::where('mrn', $request->mrn)->first();
            
            if($existingRecord == null){

                $storeflag                      = new PatientManagements();
                $storeflag->mrn                 = $request->mrn ?? null;
                $storeflag->nbm                 = $request->nbm ?? null;
                $storeflag->nbm_remark          = $request->nbm_remark ?? null;
                $storeflag->fasting             = $request->fasting ?? null;
                $storeflag->fasting_remark      = $request->fasting_remark ?? null;
                $storeflag->procedure           = $request->procedure ?? null;
                $storeflag->fall_risk           = $request->fallrisk ?? null;
                $storeflag->heart_failure       = $request->heartfailure ?? null;
                $storeflag->respi               = $request->respi ?? null;
                $storeflag->nephro              = $request->nephro ?? null;
                $storeflag->neuro               = $request->neuro ?? null;
                $storeflag->gastro              = $request->gastro ?? null;
                $storeflag->infdisease          = $request->infdisease ?? null;
                $storeflag->dildnr              = $request->dildnr ?? null;
                $storeflag->ent                 = $request->ent ?? null;
                $storeflag->high_risk           = $request->highrisk ?? null;
                $storeflag->created_by          = Auth::user()->id;
                $storeflag->created_at          = Carbon::now();
                $storeflag->save();

                $prodlist = ProcedureList::where('patmanage_id', $storeflag->id)->where('status_id', 2)->get();

                if(isset($request->procedure) && isset($request->procedure_remark)){
                    foreach($request->procedure_remark as $index => $remark){
                        $storeprocedure                 = new ProcedureList();
                        $storeprocedure->patmanage_id   = $storeflag->id;
                        $storeprocedure->procedure      = $remark;
                        $storeprocedure->financial      = isset($request->financial_switch[$index]) ? 1 : null;
                        $storeprocedure->status_id      = 2;
                        $storeprocedure->created_at     = Carbon::now();
                        $storeprocedure->updated_at     = Carbon::now();
                        $storeprocedure->save();
                    }
                }

            }else{

                $existingRecord->mrn                 = $request->mrn ?? null;
                $existingRecord->nbm                 = $request->nbm ?? null;
                $existingRecord->nbm_remark          = $request->nbm_remark ?? null;
                $existingRecord->fasting             = $request->fasting ?? null;
                $existingRecord->fasting_remark      = $request->fasting_remark ?? null;
                $existingRecord->procedure           = $request->procedure ?? null;
                $existingRecord->fall_risk           = $request->fallrisk ?? null;
                $existingRecord->heart_failure       = $request->heartfailure ?? null;
                $existingRecord->respi               = $request->respi ?? null;
                $existingRecord->nephro              = $request->nephro ?? null;
                $existingRecord->neuro               = $request->neuro ?? null;
                $existingRecord->gastro              = $request->gastro ?? null;
                $existingRecord->infdisease          = $request->infdisease ?? null;
                $existingRecord->dildnr              = $request->dildnr ?? null;
                $existingRecord->ent                 = $request->ent ?? null;
                $existingRecord->high_risk           = $request->highrisk ?? null;
                $existingRecord->updated_by          = Auth::user()->id;
                $existingRecord->updated_at          = Carbon::now();
                $existingRecord->save();

                $prodlist = ProcedureList::where('patmanage_id', $existingRecord->id)->where('status_id', 2)->get();

                if($prodlist != null){
                    foreach($prodlist as $list){
                        $list->status_id = 1;
                        $list->updated_at = Carbon::now();
                        $list->save();
                    }
                }

                if(isset($request->procedure) && isset($request->procedure_remark)){
                    foreach($request->procedure_remark as $index => $remark){
                        $storeprocedure                 = new ProcedureList();
                        $storeprocedure->patmanage_id   = $existingRecord->id;
                        $storeprocedure->procedure      = $remark;
                        $storeprocedure->financial      = isset($request->financial_switch[$index]) ? 1 : null;
                        $storeprocedure->status_id      = 2;
                        $storeprocedure->created_at     = Carbon::now();
                        $storeprocedure->updated_at     = Carbon::now();
                        $storeprocedure->save();
                    }
                }

            }

            return response()->json([
                'status' => 'success',
                'response' => 'Successfully saved',
            ], 200);
            

        }catch (\Exception $e) {
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

    public function getPatientFlag(Request $request){

        try 
        {
            $existingRecord = PatientManagements::with(['procedureList' => function($query) {
                $query->where('status_id', 2);
            }])->where('mrn', $request->mrn)->first();

            // dd($existingRecord);

            return response()->json([
                'status' => 'success',
                'response' => $existingRecord,
            ], 200);

        }catch (\Exception $e) {
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
