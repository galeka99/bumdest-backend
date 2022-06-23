<?php

namespace Database\Seeders;

use App\Models\InvestmentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestmentStatusSeeder extends Seeder
{
    public function run()
    {
        InvestmentStatus::create([ 'id' => 1, 'label' => 'Diajukan' ]);
        InvestmentStatus::create([ 'id' => 2, 'label' => 'Diterima' ]);
        InvestmentStatus::create([ 'id' => 3, 'label' => 'Ditolak' ]);
        InvestmentStatus::create([ 'id' => 4, 'label' => 'Berjalan' ]);
        InvestmentStatus::create([ 'id' => 5, 'label' => 'Dihentikan' ]);
    }
}
