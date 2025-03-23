<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    public function handle(Request $request, Closure $next, $guard = 'admin')
    {
        if (!Auth::guard($guard)->check()) {
            return response()->view('loader.loader', [
                'redirectUrl' => route('login') // Redirect to login after loader
            ]);
        }

        return $next($request);
    }
}
