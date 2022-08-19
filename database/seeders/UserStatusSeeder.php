<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    public function run()
    {
        UserStatus::create(['id' => 1, 'label' => 'Active']);
        UserStatus::create(['id' => 2, 'label' => 'Nonactive']);
    }
}
