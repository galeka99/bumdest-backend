<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use App\Models\City;
use App\Models\District;
use App\Models\Gender;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
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

    public function list(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $users = User::whereBetween('role_id', [2, 3])->orderBy('created_at', 'DESC')->paginate($limit);

        return view('dashboard.users.index', compact('users'));
    }

    public function add()
    {
        $provinces = Province::orderBy('name', 'ASC')->get();
        $genders = Gender::all();
        $roles = Role::where('id', '!=', 1)->get();
        $statuses = UserStatus::all();

        return view('dashboard.users.add', compact('provinces', 'genders', 'roles', 'statuses'));
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
            'gender' => 'numeric|required',
            'role' => 'numeric|required',
            'status' => 'numeric|required',
        ]);

        $district = District::find($request->post('district'));
        if (!$district) return redirect('/user/add')->with('error', 'District not found');
        $gender = Gender::find($request->post('gender'));
        if (!$gender) return redirect('/user/add')->with('error', 'Gender not found');
        $role = Role::find($request->post('role'));
        if (!$role) return redirect('/user/add')->with('error', 'Role not found');
        $status = UserStatus::find($request->post('status'));
        if (!$status) return redirect('/user/add')->with('error', 'User status not found');

        $user = User::where('email', $request->post('email'))->first();
        if ($user) return redirect('/user')->with('error', 'Email already used by another user');

        User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => $request->post('password'),
            'phone' => $request->post('phone'),
            'address' => $request->post('address'),
            'postal_code' => $request->post('postal_code'),
            'district_id' => $district->id,
            'gender_id' => $gender->id,
            'role_id' => $role->id,
            'user_status_id' => $status->id,
            'verified' => true,
        ]);

        return redirect('/user')->with('success', 'User created successfully');
    }

    public function edit(Request $request, int $id)
    {
        $user = User::whereBetween('role_id', [2, 3])->where('id', $id)->first();
        if (!$user) return redirect('/user')->with('error', 'User not found');

        $genders = Gender::all();
        $roles = Role::where('id', '!=', 1)->get();
        $statuses = UserStatus::all();
        $provinces = Province::orderBy('name', 'ASC')->get();;
        $cities = City::where('province_id', $user->location['province_id'])->orderBy('name', 'ASC')->get();
        $districts = District::where('city_id', $user->location['city_id'])->orderBy('name', 'ASC')->get();

        return view('dashboard.users.edit', compact('user', 'genders', 'roles', 'statuses', 'provinces', 'cities', 'districts'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|nullable',
            'confirm_password' => 'string|same:password|nullable',
            'phone' => 'numeric|required',
            'balance' => 'numeric|nullable',
            'address' => 'string|required',
            'postal_code' => 'numeric|required',
            'district' => 'numeric|required',
            'gender' => 'numeric|required',
            'role' => 'numeric|required',
            'status' => 'numeric|required',
        ]);

        $district = District::find($request->post('district'));
        if (!$district) return redirect('/user/'.$id)->with('error', 'District not found');
        $gender = Gender::find($request->post('gender'));
        if (!$gender) return redirect('/user/'.$id)->with('error', 'Gender not found');
        $role = Role::find($request->post('role'));
        if (!$role) return redirect('/user/'.$id)->with('error', 'Role not found');
        $status = UserStatus::find($request->post('status'));
        if (!$status) return redirect('/user/'.$id)->with('error', 'User status not found');

        $user = User::whereBetween('role_id', [2, 3])->where('id', $id)->first();
        if (!$user) return redirect('/user')->with('error', 'User not found');

        $user->name = $request->post('name');
        $user->email = $request->post('email');
        if ($request->filled('password')) $user->password = $request->post('password');
        $user->phone = $request->post('phone');
        if ($role->id === 3) $user->balance = $request->post('balance', $user->balance);
        $user->address = $request->post('address');
        $user->postal_code = $request->post('postal_code');
        $user->district_id = $district->id;
        $user->role_id = $role->id;
        $user->user_status_id = $status->id;
        $user->save();

        return redirect('/user')->with('success', 'User updated successfully');
    }

    public function delete(int $id)
    {
        $user = User::whereBetween('role_id', [2, 3])->where('id', $id)->first();
        if (!$user) return redirect('/user')->with('error', 'User not found');

        $user->delete();

        return redirect('/user')->with('success', 'User deleted successfully');
    }
}
