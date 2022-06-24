<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $request->post('email');
        $password = $request->post('password');

        $user = User::where('email', $email)->first();
        if (!$user) return redirect('/login')->with('error', 'User tidak ditemukan');

        if (!Hash::check($password, $user->password))
            return redirect('/login')->with('error', 'Kata sandi salah');
        
        Auth::login($user, true);
        return redirect('/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function api_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => 'LOGIN_FAILED',
                'data' => $validator->errors(),
            ], 400);
        }

        $email = $request->post('email');
        $password = $request->post('password');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'status' => 404,
                'error' => 'USER_NOT_FOUND',
                'data' => null,
            ], 404);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 401,
                'error' => 'WRONG_PASSOWRD',
                'data' => null,
            ], 401);
        }

        $token = Str::random(80);
        $expired = Carbon::now('Asia/Jakarta')->addMonth()->format('Y-m-d');
        UserToken::create([
            'token' => $token,
            'user_id' => $user->id,
            'expired_at' => $expired,
        ]);

        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => $token,
        ]);
    }
}
