<?php

namespace App\Http\Middleware;

use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $auth = $request->header('Authorization');
        if (!$auth) {
            return response()->json(['error' => 'ACCESS_TOKEN_NOT_FOUND'], 403);
        }

        $tokenSent = explode(' ', $auth)[1];
        $token = UserToken::where('token', $tokenSent)->first();
        if (!$token) {
            return response()->json(['error' => 'INVALID_ACCESS_TOKEN'], 401);
        }

        if ($token->user->role_id !== 1) {
            return response()->json(['error' => 'RESTRICTED_ACCESS'], 403);
        }

        $request['user'] = $token->user;
        return $next($request);
    }
}
