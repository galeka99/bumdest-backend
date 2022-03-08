<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([ 'label' => 'Admin' ]);
        Role::create([ 'label' => 'Admin BUMDes' ]);
        Role::create([ 'label' => 'User' ]);
    }
}
