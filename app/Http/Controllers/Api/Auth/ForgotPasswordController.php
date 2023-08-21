<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }
    public function mSendVerifyCode(Request $request)
    {
        error_log($request->email);
        
        $user = User::where('email', $request->email)->first();
       
        if ($this->checkValidCode($user, $user->ver_code, 2)) {
            $target_time = $user->ver_code_send_at->addMinutes(2)->timestamp;
            $delay = $target_time - time();
            $notify[] = 'Please Try after ' . $delay . ' Seconds';
            return response()->json([
                'message'=>$notify
            ])->setStatusCode(400);
        }
        if (!$this->checkValidCode($user, $user->ver_code)) {
            $user->ver_code = verificationCode(6);
            $user->ver_code_send_at = Carbon::now();
            $user->save();
        } else {
            $user->ver_code = $user->ver_code;
            $user->ver_code_send_at = Carbon::now();
            $user->save();
        }
        if ($request->type === 'email') {
            sendEmail($user, 'EVER_CODE',[
                'code' => $user->ver_code
            ]);
            $notify[] = 'Email verification code sent successfully';
            return response()->json([
                'message'=>$notify
            ])->setStatusCode(200);
        } elseif ($request->type === 'phone') {
            sendSms($user, 'SVER_CODE', [
                'code' => $user->ver_code
            ]);
            $notify[] = 'SMS verification code sent successfully';
            return response()->json([
                'message'=>$notify
            ])->setStatusCode(200);
        } else {
            $notify[] = 'Sending Failed';
            return response()->json([
                'message'=>$notify
            ])->setStatusCode(400);
        }
    }
    public function mSendResetCodeEmail(Request $request)
    {
        if ($request->type == 'email') {
            $validationRule = [
                'value'=>'required|email'
            ];
            $validationMessage = [
                'value.required'=>'Email field is required',
                'value.email'=>'Email must be an valid email'
            ];
        }elseif($request->type == 'username'){
            $validationRule = [
                'value'=>'required'
            ];
            $validationMessage = ['value.required'=>'Username field is required'];
        }else{
            return response()->json([
                'message'=>['Invalid selection'],
            ])->setStatusCode(400);
        }
        $validator = Validator::make($request->all(),$validationRule,$validationMessage);
        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()->all(),
            ])->setStatusCode(400);
        }
        error_log($request->type);
        error_log($request->value);
        $user = User::where($request->type, $request->value)->first();

        if (!$user) {
            $notify[] = 'User not found.';
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new PasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
        sendEmail($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ]);
        $email = $user->email;
        $notify[] = 'Password reset email sent successfully';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>$notify,
            'data'=>['email'=>$email]
        ])->setStatusCode(200);
    }

    public function mVerifyCode(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>$validator->errors()->all()
            ])->setStatusCode(400);
        }

        $code =  $request->code;

        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = 'Invalid token';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>$notify,
            ])->setStatusCode(400);
        }

        $notify[] = 'You can change your password';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>$notify,
            'data'=>[
                'token'=>$code,
                'email'=>$request->email,
            ]
        ])->setStatusCode(200);
    }

    public function sendResetCodeEmail(Request $request)
    {
        if ($request->type == 'email') {
            $validationRule = [
                'value'=>'required|email'
            ];
            $validationMessage = [
                'value.required'=>'Email field is required',
                'value.email'=>'Email must be an valide email'
            ];
        }elseif($request->type == 'username'){
            $validationRule = [
                'value'=>'required'
            ];
            $validationMessage = ['value.required'=>'Username field is required'];
        }else{
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>['Invalid selection']],
            ]);
        }
        $validator = Validator::make($request->all(),$validationRule,$validationMessage);
        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()],
            ]);
        }

        $user = User::where($request->type, $request->value)->first();
        
        if (!$user) {
            $notify[] = 'User not found.';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$notify],
            ]);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new PasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
        sendEmail($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ]);
        $email = $user->email;
        $notify[] = 'Password reset email sent successfully';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
            'data'=>['email'=>$email]
        ]);
    }


    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$validator->errors()->all()]
            ]);
        }

        $code =  $request->code;

        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = 'Invalid token';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>['error'=>$notify],
            ]);
        }

        $notify[] = 'You can change your password';
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>['success'=>$notify],
            'data'=>[
                'token'=>$code,
                'email'=>$request->email,
            ]
        ]);
    }

}
