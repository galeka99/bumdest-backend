<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        //
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'postal_code' => 'required|numeric',
            'district' => 'required|numeric',
            'gender' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'ADD_ADMIN_FAILED',
                'data' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password')),
            'phone' => $request->post('phone'),
            'address' => $request->post('address'),
            'postal_code' => $request->post('postal_code'),
            'district_id' => $request->post('district'),
            'gender_id' => $request->post('gender'),
            'role_id' => 1,
            'user_status_id' => 1,
            'verified' => 1,
        ]);

        return response()->json([
            'error' => null,
            'data' => $user,
        ]);
    }
}
