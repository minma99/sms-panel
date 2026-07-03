<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class TraineeOrUserAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        if (Session::get('trainee_logged_in') === true && Session::has('trainee_id')) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
