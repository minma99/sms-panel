<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

        $phone = trim($request->phone);

        /*
        |--------------------------------------------------------------------------
        | 1. اول کاربران سیستم را بررسی می‌کنیم
        |--------------------------------------------------------------------------
        | admin / super_admin / user
        */

        $user = User::where('phone', $phone)->first();

        if ($user) {
            // OTP چهار رقمی برای هماهنگی با welcome_new
            $otp = (string) random_int(1000, 9999);

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5)
            ]);

            return response()->json([
                'success' => true,
                'otp' => $otp, // فقط برای حالت تست
                'message' => 'کد تایید ارسال شد.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. اگر کاربر نبود، کارآموز را بررسی می‌کنیم
        |--------------------------------------------------------------------------
        */

        $trainee = Trainee::where('phone', $phone)->first();

        if ($trainee) {
            // OTP چهار رقمی برای حالت تست
            $otp = (string) random_int(1000, 9999);

            /*
             * چون جدول trainees احتمالاً ستون‌های otp و otp_expires_at ندارد،
             * برای کارآموز OTP را داخل Session ذخیره می‌کنیم.
             */
            Session::put('trainee_otp_phone', $phone);
            Session::put('trainee_otp_code', $otp);
            Session::put('trainee_otp_expires_at', now()->addMinutes(5)->timestamp);

            return response()->json([
                'success' => true,
                'otp' => $otp, // فقط برای حالت تست
                'message' => 'کد تایید ارسال شد.'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. اگر نه User بود نه Trainee
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => false,
            'message' => 'کاربر یافت نشد'
        ], 404);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string'
        ]);

        $phone = trim($request->phone);
        $otp = trim($request->otp);

        /*
        |--------------------------------------------------------------------------
        | 1. اول کاربران سیستم را بررسی می‌کنیم
        |--------------------------------------------------------------------------
        */

        $user = User::where('phone', $phone)->first();

        if ($user) {
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

            if ($user->otp !== $otp) {
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

        /*
        |--------------------------------------------------------------------------
        | 2. اگر User نبود، کارآموز را بررسی می‌کنیم
        |--------------------------------------------------------------------------
        */

        $trainee = Trainee::where('phone', $phone)->first();

        if ($trainee) {
            $sessionPhone = Session::get('trainee_otp_phone');
            $sessionOtp = Session::get('trainee_otp_code');
            $expiresAt = Session::get('trainee_otp_expires_at');

            if (
                !$sessionPhone ||
                !$sessionOtp ||
                !$expiresAt ||
                now()->timestamp > $expiresAt
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'کد منقضی شده است'
                ], 422);
            }

            if ($sessionPhone !== $phone) {
                return response()->json([
                    'success' => false,
                    'message' => 'شماره موبایل معتبر نیست'
                ], 422);
            }

            if ($sessionOtp !== $otp) {
                return response()->json([
                    'success' => false,
                    'message' => 'کد وارد شده اشتباه است'
                ], 422);
            }

            /*
             * لاگین کارآموز با Session
             */
            Session::put('trainee_logged_in', true);
            Session::put('trainee_id', $trainee->id);

            /*
             * پاک کردن OTP بعد از ورود موفق
             */
            Session::forget('trainee_otp_phone');
            Session::forget('trainee_otp_code');
            Session::forget('trainee_otp_expires_at');

            return response()->json([
                'success' => true,
                'redirect' => route('user.dashboard')
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. اگر هیچکدام نبود
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => false,
            'message' => 'کاربر یافت نشد'
        ], 404);
    }
}
