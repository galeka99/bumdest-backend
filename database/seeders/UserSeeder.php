<?php

namespace Database\Seeders;

use App\Models\Bumdes;
use App\Models\User;
use App\Models\UserToken;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@polines.ac.id',
            'password' => Hash::make('admin'),
            'phone' => '081234567890',
            'balance' => 0,
            'address' => 'Jl. Prof. Sudarto',
            'postal_code' => '50275',
            'district_id' => 337410,
            'gender_id' => 1,
            'role_id' => 1,
            'user_status_id' => 1,
            'verified' => true,
        ]);
    }
}
