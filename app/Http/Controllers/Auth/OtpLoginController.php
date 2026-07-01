<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpLoginController extends Controller
{
    public function showLogin()
    {
        return view('welcome_new');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'کاربر یافت نشد'
            ], 404);
        }

        // OTP چهار رقمی برای هماهنگی با welcome_new
        $otp = (string) random_int(1000, 9999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        return response()->json([
            'success' => true,
            'otp' => $otp // فقط برای حالت تست
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string'
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'کاربر یافت نشد'
            ], 404);
        }

        if (
            !$user->otp ||
            !$user->otp_expires_at ||
            now()->greaterThan($user->otp_expires_at)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'کد منقضی شده است'
            ], 422);
        }

        if ($user->otp !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'کد وارد شده اشتباه است'
            ], 422);
        }

        Auth::login($user);

        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        $redirect = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'super_admin' => route('superadmin.dashboard'),
            default => route('user.dashboard')
        };

        return response()->json([
            'success' => true,
            'redirect' => $redirect
        ]);
    }
}