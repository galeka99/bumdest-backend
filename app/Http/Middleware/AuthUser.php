<?php

namespace App\Http\Middleware;

use App\Http\Helper;
use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;

class AuthUser
{
    public function handle(Request $request, Closure $next)
    {
        $auth = $request->header('Authorization');
        if (!$auth) {
            return Helper::sendJson('ACCESS_TOKEN_NOT_FOUND', null, 404);
        }

        $tokenSent = explode(' ', $auth)[1];
        $token = UserToken::where('token', $tokenSent)->first();
        if (!$token) {
            return Helper::sendJson('INVALID_ACCESS_TOKEN', null, 401);
        }

        if ($token->user->role_id !== 3) {
            return Helper::sendJson('RESTRICTED_ACCESS', null, 403);
        }

        $request['user'] = $token->user;
        return $next($request);
    }
}
