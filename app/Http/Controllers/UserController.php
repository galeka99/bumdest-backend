<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
