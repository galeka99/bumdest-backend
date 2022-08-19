<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role_id === 1) {
            return $next($request);
        } else {
            return redirect('/dashboard');
        }
    }
}
