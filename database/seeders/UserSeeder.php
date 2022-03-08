<?php

namespace Database\Seeders;

use App\Models\User;
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
            'description' => 'I\'m an administrator',
            'address' => 'Jl. Prof. Sudarto',
            'subdistrict_id' => 337410,
            'gender_id' => 1,
            'role_id' => 1,
        ]);
    }
}
