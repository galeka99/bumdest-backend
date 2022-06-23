<?php

namespace Database\Seeders;

use App\Models\Bumdes;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $bumdes = Bumdes::create([
            'name' => 'Desa Sukamaju',
            'phone' => '081234567890',
            'district_id' => 337410,
            'address' => 'Sendangmulyo',
            'postal_code' => '50272',
            'description' => 'Sekedar BUMDes biasa',
        ]);
        
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
            'bumdes_id' => $bumdes->id,
            'verified' => true,
        ]);
    }
}
