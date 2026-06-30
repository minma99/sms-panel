<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpLoginController extends Controller
{
    public function showLogin() { return view('auth.otplogin'); }

    public function sendOtp(Request $request) {
        $user = User::where('phone', trim($request->phone))->first();
        if (!$user) return response()->json(['success' => false, 'message' => 'شماره یافت نشد']);
        if (in_array($user->role, ['super_admin', 'superadmin'])) 
            return response()->json(['success' => false, 'message' => 'سوپرادمین باید با رمز وارد شود']);

        Otp::where('phone', $request->phone)->delete();
        $code = rand(100000, 999999);
        Otp::create(['phone' => $request->phone, 'code' => $code, 'expires_at' => now()->addMinutes(2)]);
        return response()->json(['success' => true, 'otp' => $code]);
    }

    public function verifyOtp(Request $request) {
        $record = Otp::where('phone', $request->phone)->where('code', $request->otp)->where('expires_at', '>', now())->first();
        if (!$record) return response()->json(['success' => false, 'message' => 'کد نامعتبر']);
        
        $user = User::where('phone', $request->phone)->first();
        Auth::login($user);
        $record->delete();

        $redirect = ($user->role === 'admin') ? route('admin.dashboard') : route('user.dashboard');
        return response()->json(['success' => true, 'redirect' => $redirect]);
    }
}
