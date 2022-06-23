<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([ 'id' => 1, 'label' => 'Admin' ]);
        Role::create([ 'id' => 2, 'label' => 'Admin BUMDes' ]);
        Role::create([ 'id' => 3, 'label' => 'User' ]);
    }
}
