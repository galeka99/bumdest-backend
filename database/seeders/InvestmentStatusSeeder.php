<?php

namespace Database\Seeders;

use App\Models\InvestmentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestmentStatusSeeder extends Seeder
{
    public function run()
    {
        InvestmentStatus::create([ 'id' => 1, 'label' => 'Proposed' ]);
        InvestmentStatus::create([ 'id' => 2, 'label' => 'Accepted' ]);
        InvestmentStatus::create([ 'id' => 3, 'label' => 'Rejected' ]);
        InvestmentStatus::create([ 'id' => 4, 'label' => 'Stopped' ]);
    }
}
