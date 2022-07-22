<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use App\Models\City;
use App\Models\District;
use App\Models\Gender;
use App\Models\Province;
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
        if (!$user) return redirect('/login')->with('error', 'User not found');

        if (!Hash::check($password, $user->password))
            return redirect('/login')->with('error', 'Wrong password');
        
        Auth::login($user, true);
        return redirect('/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function profile()
    {
        $genders = Gender::all();
        $provinces = Province::orderBy('name', 'ASC')->get();
        $user_cities = City::where('province_id', auth()->user()->location['province_id'])->get();
        $user_districts = District::where('city_id', auth()->user()->location['city_id'])->get();
        $bumdes_cities = City::where('province_id', auth()->user()->bumdes->location['province_id'])->get();
        $bumdes_districts = District::where('city_id', auth()->user()->bumdes->location['city_id'])->get();
        return view('dashboard.profile.index', compact('genders', 'provinces', 'user_cities', 'user_districts', 'bumdes_cities', 'bumdes_districts'));
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'user_phone' => 'required|numeric',
            'user_gender' => 'required|numeric',
            'user_address' => 'required|string',
            'user_postal_code' => 'required|numeric',
            'user_district' => 'required|numeric',

            'bumdes_name' => 'required|string',
            'bumdes_phone' => 'required|numeric',
            'bumdes_description' => 'required|string',
            'bumdes_address' => 'required|string',
            'bumdes_postal_code' => 'required|numeric',
            'bumdes_district' => 'required|numeric',
            'bumdes_maps_url' => 'url|nullable',

            'password' => 'required|string',
            'confirm_password' => 'required|string',
        ]);

        $password = $request->post('password');
        $confirm_password = $request->post('confirm_password');

        if ($password !== $confirm_password)
            return redirect('/profile')->with('error', 'Confirm password not match');
        if (!Hash::check($password, auth()->user()->password))
            return redirect('/profile')->with('error', 'Wrong password');
        
        $user = User::find(auth()->user()->id);
        $user->name = $request->post('user_name', $user->name);
        $user->email = $request->post('user_email', $user->email);
        if ($request->filled('user_password')) $user->password = Hash::make($request->post('user_password'));
        $user->phone = $request->post('user_phone', $user->phone);
        $user->gender_id = $request->post('user_gender', $user->gender_id);
        $user->address = $request->post('user_address', $user->address);
        $user->postal_code = $request->post('user_postal_code', $user->postal_code);
        $user->district_id = $request->post('user_district', $user->district_id);
        $user->save();

        $bumdes = Bumdes::find($user->bumdes->id);
        $bumdes->name = $request->post('bumdes_name', $bumdes->name);
        $bumdes->phone = $request->post('bumdes_phone', $bumdes->phone);
        $bumdes->description = $request->post('bumdes_description', $bumdes->description);
        $bumdes->district_id = $request->post('bumdes_district', $bumdes->district_id);
        $bumdes->address = $request->post('bumdes_address', $bumdes->address);
        $bumdes->postal_code = $request->post('bumdes_postal_code', $bumdes->postal_code);
        $bumdes->maps_url = $request->post('bumdes_maps_url', $bumdes->maps_url);
        $bumdes->save();

        return redirect('/profile')->with('success', 'Profile updated');
    }
}
