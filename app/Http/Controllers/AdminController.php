<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Gender;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $q = $request->input('q', '');
        $admins = User::where('role_id', 1)->where('email', 'LIKE', "%$q%")->orderBy('created_at', 'DESC')->paginate($limit);

        return view('dashboard.admins.index', compact('admins'));
    }

    public function add()
    {
        $provinces = Province::orderBy('name', 'ASC')->get();
        $genders = Gender::all();

        return view('dashboard.admins.add', compact('provinces', 'genders'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required',
            'confirm_password' => 'string|same:password|required',
            'phone' => 'numeric|required',
            'address' => 'string|required',
            'postal_code' => 'numeric|required',
            'district' => 'numeric|required',
            'gender' => 'numeric|required'
        ]);

        $name = $request->post('name');
        $email = $request->post('email');
        $password = $request->post('password');
        $phone = $request->post('phone');
        $address = $request->post('address');
        $postal_code = $request->post('postal_code');
        $gender = $request->post('gender');

        $user = User::where('email', $email)->first();
        if ($user) return redirect('/admin/add')->with('error', 'Email already used by another user');

        $district = District::find($request->post('district'));
        if (!$district) return redirect('/admin/add')->with('error', 'District not found');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'phone' => $phone,
            'address' => $address,
            'postal_code' => $postal_code,
            'district_id' => $district->id,
            'gender_id' => $gender,
            'role_id' => 1,
            'user_status_id' => 1,
            'bumdes_id' => null,
            'verified' => true,
        ]);

        return redirect('/admin')->with('success', 'Success creating new administrator');
    }

    public function edit(int $id)
    {
        $admin = User::where('role_id', 1)->where('id', $id)->first();
        if (!$admin) return redirect('/admin')->with('error', 'Administrator not found');

        $genders = Gender::all();
        $provinces = Province::orderBy('name', 'ASC')->get();;
        $cities = City::where('province_id', $admin->location['province_id'])->orderBy('name', 'ASC')->get();
        $districts = District::where('city_id', $admin->location['city_id'])->orderBy('name', 'ASC')->get();

        return view('dashboard.admins.edit', compact('admin', 'genders', 'provinces', 'cities', 'districts'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|nullable',
            'confirm_password' => 'string|same:password|nullable',
            'phone' => 'numeric|required',
            'address' => 'string|required',
            'postal_code' => 'numeric|required',
            'district' => 'numeric|required',
            'gender' => 'numeric|required'
        ]);

        $district = District::find($request->post('district'));
        if (!$district) return redirect('/admin/'.$id)->with('error', 'District not found');
        $gender = Gender::find($request->post('gender'));
        if (!$gender) return redirect('/admin/'.$id)->with('error', 'Gender not found');

        $admin = User::where('role_id', 1)->where('id', $id)->first();
        if (!$admin) return redirect('/admin')->with('error', 'Administrator not found');

        $admin->name = $request->post('name', $admin->name);
        $admin->email = $request->post('email', $admin->email);
        if ($request->filled('password')) $admin->password = Hash::make($request->post('password'));
        $admin->phone = $request->post('phone', $admin->phone);
        $admin->address = $request->post('address', $admin->address);
        $admin->postal_code = $request->post('postal_code', $admin->postal_code);
        $admin->district_id = $district->id;
        $admin->gender_id = $gender->id;
        $admin->save();

        return redirect('/admin')->with('success', 'Administrator updated successfully');
    }

    public function delete(int $id)
    {
        $admin = User::where('role_id', 1)->where('id', $id)->first();
        if (!$admin) return redirect('/admin')->with('error', 'Administrator not found');

        $admin->delete();

        return redirect('/admin')->with('success', 'Administrator deleted successfully');
    }
}
