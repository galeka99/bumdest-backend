<?php

namespace Database\Seeders;

use App\Models\DepositStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepositStatusSeeder extends Seeder
{
    public function run()
    {
        DepositStatus::create([ 'id' => 1, 'label' => 'Pending' ]);
        DepositStatus::create([ 'id' => 2, 'label' => 'Success' ]);
        DepositStatus::create([ 'id' => 3, 'label' => 'Failed' ]);
    }
}
