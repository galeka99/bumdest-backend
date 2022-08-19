<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    public function run()
    {
        Gender::create([ 'id' => 1, 'label' => 'Male' ]);
        Gender::create([ 'id' => 2, 'label' => 'Female' ]);
    }
}
