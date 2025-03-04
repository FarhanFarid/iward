<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

//models
use App\Models\User;
use App\Models\AccessroleIward;

use Auth;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function index(Request $request){
        return view('auth.login');
    }

    public function loginSSO(Request $request){
        try
        {            
            $rules =[
                'email'     => 'required',
                'password'  => 'required',
            ];

            $validator    = Validator::make($request->all(), $rules, [
                'email.required'    => __('Email is required!'),
                'password.required' => __('Password is required!'),
            ]);

            if($validator->fails()){
                $response = response()->json(
                    [
                      'status'  => 'failed',
                      'message' => 'Email/Password is required!'
                    ], 200
                );

                return $response;
            }

            $url    = env('POST_SSO_LOGIN');
            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', $url, ['form_params' => [
                                'email'     => $request->email,
                                'password'  => $request->password,
                                'platform'  => "web"
                            ]]);

            $statusCode = $response->getStatusCode();
            $content    = $response->getBody();

            $content = json_decode($response->getBody(), true);

            if($content['status'] == "failed")
            {
                $response = response()->json(
                    [
                      'status'  => 'failed',
                      'message' => 'Wrong email/password. Please try again.'
                    ], 200
                );

                return $response;
            }

            $userData = User::where('user_sso_id', $content['data']['id'])->first();

            $checkIfAssignedRole = AccessroleIward::where('user_id', $content['data']['id'])->where('status_id', 2)->first();
            if($checkIfAssignedRole != null)
            {
                if($userData == null)
                {
                    $userData = new User();
                    $userData->user_sso_id = $content['data']['id'];
                    $userData->save();
                }
                else
                {
                    $userData->user_sso_id = $content['data']['id'];
                    $userData->save();
                }

                Auth::login($userData);

                $response = response()->json(
                    [
                        'status'  => 'success',
                        'data'    => Auth::user(),
                    ], 200
                );
            }
            else
            {
                $response = response()->json(
                    [
                        'status'  => 'failed',
                        'message' => "Sorry, you don't have permission to login this system. Please contact administrator for further information. Thank you.",
                    ], 200
                );
            }

            return $response;
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            $response = response()->json(
                [
                    'status'  => 'failed',
                    'message' => 'Internal error happened. Try again'
                ], 200
            );

            return $response;
        }
    }

    public function logoutSSO(Request $request)
    {
        try
        {
            Auth::logout();

            return redirect()->route('login');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            $response = response()->json(
                [
                    'status'  => 'failed',
                    'message' => 'Internal error happened. Try again'
                ], 200
            );

            return $response;
        }
    }
}
