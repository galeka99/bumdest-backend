<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    public function run()
    {
        UserStatus::create(['id' => 1, 'label' => 'Aktif']);
        UserStatus::create(['id' => 2, 'label' => 'Nonaktif']);
    }
}
