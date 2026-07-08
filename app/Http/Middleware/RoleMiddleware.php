<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // ۱. چک کردن لاگین بودن
        if (! Auth::check()) {
            return redirect()->route('superadmin.login');
        }

        $user = Auth::user();

        // ۲. چک کردن اینکه آیا ستون role اصلاً وجود دارد یا خالی است
        if (!$user || !isset($user->role)) {
            Log::error('User ID ' . ($user ? $user->id : 'null') . ' has no role defined.');
            abort(403, 'User role is not defined.');
        }

        // ۳. بررسی نقش
        if (! in_array($user->role, $roles, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
