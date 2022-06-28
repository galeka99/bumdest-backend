<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Gender;
use App\Models\User;
use App\Models\UserToken;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'postal_code' => 'required|numeric',
            'district_id' => 'required|numeric',
            'gender_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => 'INVALID_REQUEST',
                'data' => $validator->errors(),
            ], 400);
        }

        $district = District::find($request->post('district_id'));
        if (!$district)
            return response()->json([
                'status' => 404,
                'error' => 'DISTRICT_NOT_FOUND',
                'data' => null,
            ]);
        $gender = Gender::find($request->post('gender_id'));
        if (!$gender)
            return response()->json([
                'status' => 404,
                'error' => 'GENDER_NOT_FOUND',
                'data' => null,
            ]);

        User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password')),
            'phone' => $request->post('phone'),
            'address' => $request->post('address'),
            'postal_code' => $request->post('postal_code'),
            'district_id' => $district->id,
            'gender_id' => $gender->id,
            'role_id' => 3,
            'user_status_id' => 1,
            'verified' => true,
        ]);

        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => null,
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => 'INVALID_REQUEST',
                'data' => $validator->errors(),
            ], 400);
        }

        $email = $request->post('email');
        $password = $request->post('password');

        $user = User::where('email', $email)->first();
        if (!$user)
            return response()->json([
                'status' => 404,
                'error' => 'USER_NOT_FOUND',
                'data' => null,
            ], 404);

        if (!Hash::check($password, $user->password))
            return response()->json([
                'status' => 401,
                'error' => 'WRONG_PASSOWRD',
                'data' => null,
            ], 401);

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

    public function userinfo(Request $request)
    {
        $user = User::find($request->user->id);
        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => $user,
        ]);
    }
}
