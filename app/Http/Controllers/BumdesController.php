<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use App\Models\City;
use App\Models\District;
use App\Models\Gender;
use App\Models\Province;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BumdesController extends Controller
{
    public function list(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $bumdes = Bumdes::orderBy('created_at', 'DESC')->paginate($limit);

        return view('dashboard.bumdes.index', compact('bumdes'));
    }

    public function add()
    {
        $provinces = Province::orderBy('name', 'ASC')->get();
        $genders = Gender::all();
        return view('dashboard.bumdes.add', compact('provinces', 'genders'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'bumdes_name' => 'required|string',
            'bumdes_phone' => 'required|numeric',
            'bumdes_address' => 'required|string',
            'bumdes_postal_code' => 'required|numeric',
            'bumdes_district' => 'required|numeric',
            'bumdes_description' => 'required|string',
            'bumdes_maps_url' => 'url|nullable',
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'password' => 'required',
            'user_phone' => 'required|numeric',
            'user_address' => 'required|string',
            'user_postal_code' => 'required|numeric',
            'user_district' => 'required|numeric',
            'gender' => 'required|numeric'
        ]);

        $user = User::where('email', $request->post('user_email'))->first();
        if ($user) return redirect('/bumdes')->with('error', 'Email already used by another user');

        $bumdes = Bumdes::create([
            'name' => $request->post('bumdes_name'),
            'phone' => $request->post('bumdes_phone'),
            'district_id' => $request->post('bumdes_district'),
            'address' => $request->post('bumdes_address'),
            'postal_code' => $request->post('bumdes_postal_code'),
            'description' => $request->post('bumdes_description'),
            'maps_url' => $request->post('bumdes_maps_url'),
        ]);
        
        User::create([
            'name' => $request->post('user_name'),
            'email' => $request->post('user_email'),
            'password' => Hash::make($request->post('password')),
            'phone' => $request->post('user_phone'),
            'address' => $request->post('user_address'),
            'postal_code' => $request->post('user_postal_code'),
            'district_id' => $request->post('user_district'),
            'gender_id' => $request->post('gender'),
            'role_id' => 2,
            'user_status_id' => 1,
            'bumdes_id' => $bumdes->id,
            'verified' => true,
        ]);

        return redirect('/bumdes')->with('success', 'BUMDes successfully created');
    }

    public function edit(Request $request, int $id)
    {
        $bumdes = Bumdes::find($id);
        if (!$bumdes) return redirect('/bumdes')->with('error', 'BUMDes not found');

        $user = User::where('bumdes_id', $id)->first();
        $user_statuses = UserStatus::all();
        $genders = Gender::all();
        $provinces = Province::orderBy('name', 'ASC')->get();
        $bumdes_cities = City::where('province_id', $bumdes->district->city->province_id)->get();
        $bumdes_districts = District::where('city_id', $bumdes->district->city_id)->get();
        $user_cities = City::where('province_id', $user->location['province_id'])->get();
        $user_districts = District::where('city_id', $user->location['city_id'])->get();

        return view('dashboard.bumdes.edit', compact('bumdes', 'user', 'genders', 'provinces', 'bumdes_cities', 'bumdes_districts', 'user_cities', 'user_districts', 'user_statuses'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'bumdes_name' => 'required|string',
            'bumdes_phone' => 'required|numeric',
            'bumdes_address' => 'required|string',
            'bumdes_postal_code' => 'required|numeric',
            'bumdes_district' => 'required|numeric',
            'bumdes_description' => 'required|string',
            'bumdes_maps_url' => 'url|nullable',
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'user_phone' => 'required|numeric',
            'user_address' => 'required|string',
            'user_postal_code' => 'required|numeric',
            'user_district' => 'required|numeric',
            'gender' => 'required|numeric',
            'user_status' => 'required|numeric'
        ]);

        $bumdes = Bumdes::find($id);
        if (!$bumdes) return redirect('/bumdes')->with('error', 'BUMDes not found');
        $user = User::where('bumdes_id', $id)->first();

        $bumdes->name = $request->post('bumdes_name', $bumdes->name);
        $bumdes->phone = $request->post('bumdes_phone', $bumdes->phone);
        $bumdes->address = $request->post('bumdes_address', $bumdes->address);
        $bumdes->postal_code = $request->post('bumdes_postal_code', $bumdes->postal_code);
        $bumdes->district_id = $request->post('bumdes_district', $bumdes->district_id);
        $bumdes->description = $request->post('bumdes_description', $bumdes->description);
        $bumdes->maps_url = $request->post('bumdes_maps_url', $bumdes->maps_url);
        $bumdes->save();

        $user->name = $request->post('user_name', $user->name);
        $user->email = $request->post('user_email', $user->email);
        if ($request->filled('password')) $user->password = Hash::make($request->post('password'));
        $user->phone = $request->post('user_phone', $user->phone);
        $user->address = $request->post('user_address', $user->address);
        $user->postal_code = $request->post('user_postal_code', $user->postal_code);
        $user->district_id = $request->post('user_district', $user->district_id);
        $user->gender_id = $request->post('gender', $user->gender_id);
        $user->user_status_id = $request->post('user_status', $user->user_status_id);
        $user->save();

        return redirect('/bumdes')->with('success', 'BUMDes updated successfully');
    }
}
