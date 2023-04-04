<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTraits;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\Providers\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserAuthController extends Controller
{

/*     public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    } */




    use GeneralTraits;


    public function login(Request $request){


        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required|string',
            ];
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login

            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('user-api')->attempt($credentials);

            if (!$token){
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');
            }
        $user = Auth::guard('user-api')->user();
        $user->api_token = $token;
        //return token
        return $this->returnData('user', $user,"data have returned");




        }



            catch (\Exception $ex) {
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }


    }




    public function logout(Request $request)
    {
         $token = $request -> header('auth-token');
        if($token){
            try {

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','some thing went wrongs');
            }
            return $this->returnSuccessMessage('Logged out successfully');
        }else{
            $this -> returnError('','some thing went wrongs');
        }

    }







}
