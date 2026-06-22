<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // اگر لاگین نبود
        if (!Auth::check()) {
            return redirect()->route('superadmin.login');
        }

        $user = Auth::user();

        // اگر نقش کاربر داخل لیست نبود
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
