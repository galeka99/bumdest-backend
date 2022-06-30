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

        $bumdes = Bumdes::create([
            'name' => 'Desa Sukamaju',
            'phone' => '081234567890',
            'district_id' => 337410,
            'address' => 'Sendangmulyo',
            'postal_code' => '50272',
            'description' => 'Sekedar BUMDes biasa',
        ]);

        // Bumdes User
        User::create([
            'name' => 'Galang',
            'email' => 'galang@polines.ac.id',
            'password' => Hash::make('galang'),
            'phone' => '089656544023',
            'balance' => 0,
            'address' => 'Perum Griya Tria Indah 2 no.27 Sendangmulyo',
            'postal_code' => '50272',
            'district_id' => 337410,
            'gender_id' => 1,
            'role_id' => 2,
            'user_status_id' => 1,
            'bumdes_id' => $bumdes->id,
            'verified' => true,
        ]);
        
        // User
        $user = User::create([
            'name' => 'Galang',
            'email' => 'galange99@gmail.com',
            'password' => Hash::make('galang'),
            'phone' => '089656544023',
            'balance' => 0,
            'address' => 'Perum Griya Tria Indah 2 no.27 Sendangmulyo',
            'postal_code' => '50272',
            'district_id' => 337410,
            'gender_id' => 1,
            'role_id' => 3,
            'user_status_id' => 1,
            'bumdes_id' => null,
            'verified' => true,
        ]);

        // User Token
        UserToken::create([
            'token' => '5UsHxjXi7PbGs61cnujNf2u3W1kPy9PIaXSn24DTqwTYOFDUWE0S3oXX1F61gBZNFh7BMRvNH320QiOh',
            'user_id' => $user->id,
            'expired_at' => Carbon::now('Asia/Jakarta')->addMonth(),
        ]);
    }
}
