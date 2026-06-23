<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpLoginController extends Controller
{

    public function showLogin()
    {
        return view('auth.otplogin');
    }


    public function sendOtp(Request $request)
{
    $request->validate([
        'phone' => 'required'
    ]);

    $user = User::where('phone',$request->phone)->first();

    if(!$user){
        return response()->json([
            'success'=>false,
            'message'=>'این شماره در سیستم ثبت نشده است'
        ]);
    }

    // جلوگیری از OTP برای سوپرادمین
    if($user->role == 'super_admin'){
        return response()->json([
            'success'=>false,
            'message'=>'سوپرادمین باید با رمز عبور وارد شود'
        ]);
    }

    Otp::where('phone',$request->phone)->delete();

    $code = rand(100000,999999);

    Otp::create([
        'phone' => $request->phone,
        'code' => $code,
        'expires_at' => now()->addMinutes(2)
    ]);

    return response()->json([
        'success'=>true,
        'otp'=>$code
    ]);
}




    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone'=>'required',
            'code'=>'required'
        ]);

        $otp = Otp::where('phone',$request->phone)
            ->where('code',$request->code)
            ->where('expires_at','>',now())
            ->latest()
            ->first();

        if(!$otp){
            return response()->json([
                'success'=>false,
                'message'=>'کد تایید نامعتبر است'
            ]);
        }

        // حذف OTP بعد از استفاده
        $otp->delete();

        $user = User::where('phone',$request->phone)->first();

        Auth::login($user);


        // تشخیص نقش کاربر
        if($user->role == 'superadmin'){
            $redirect = route('superadmin.dashboard');
        }
        elseif($user->role == 'admin'){
            $redirect = route('admin.dashboard');
        }
        else{
            $redirect = route('dashboard');
        }

        return response()->json([
            'success'=>true,
            'redirect'=>$redirect
        ]);
    }

}
