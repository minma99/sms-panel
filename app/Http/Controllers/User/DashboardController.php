<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Trainee;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. اگر کاربر سیستم لاگین باشد
        |--------------------------------------------------------------------------
        */
        $user = Auth::user();

        if ($user) {
            $trainee = null;

            if (method_exists($user, 'trainee')) {
                $trainee = $user->trainee()->with([
                    'course',
                    'payments' => function ($query) {
                        $query->latest();
                    },
                    'exams' => function ($query) {
                        $query->latest('exam_date');
                    }
                ])->first();
            }

            return view('user.dashboard', [
                'user' => $user,
                'trainee' => $trainee
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. اگر کارآموز با Session لاگین کرده باشد
        |--------------------------------------------------------------------------
        */
        if (
            Session::get('trainee_logged_in') === true &&
            Session::has('trainee_id')
        ) {
            $trainee = Trainee::with([
                'course',
                'payments' => function ($query) {
                    $query->latest();
                },
                'exams' => function ($query) {
                    $query->latest('exam_date');
                }
            ])->find(Session::get('trainee_id'));

            if ($trainee) {
                return view('user.dashboard', [
                    'user' => null,
                    'trainee' => $trainee
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. اگر لاگین نبود
        |--------------------------------------------------------------------------
        */
        return redirect()->route('login');
    }

    public function downloadFile()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. اگر کاربر سیستم لاگین باشد
        |--------------------------------------------------------------------------
        */
        $user = Auth::user();

        if ($user && method_exists($user, 'trainee')) {
            $trainee = $user->trainee()->first();

            if (!$trainee || empty($trainee->file)) {
                abort(404, 'فایلی برای دانلود یافت نشد.');
            }

            if (!Storage::disk('public')->exists($trainee->file)) {
                abort(404, 'فایل در سرور یافت نشد.');
            }

            return Storage::disk('public')->download(
                $trainee->file,
                basename($trainee->file)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 2. اگر کارآموز با Session لاگین کرده باشد
        |--------------------------------------------------------------------------
        */
        if (
            Session::get('trainee_logged_in') === true &&
            Session::has('trainee_id')
        ) {
            $trainee = Trainee::find(Session::get('trainee_id'));

            if (!$trainee || empty($trainee->file)) {
                abort(404, 'فایلی برای دانلود یافت نشد.');
            }

            if (!Storage::disk('public')->exists($trainee->file)) {
                abort(404, 'فایل در سرور یافت نشد.');
            }

            return Storage::disk('public')->download(
                $trainee->file,
                basename($trainee->file)
            );
        }

        abort(403, 'دسترسی غیرمجاز.');
    }
}
