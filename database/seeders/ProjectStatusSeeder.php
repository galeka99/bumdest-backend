<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    public function run()
    {
        ProjectStatus::create(['id' => 1, 'label' => 'Dalam Rencana']);
        ProjectStatus::create(['id' => 2, 'label' => 'Sedang Berjalan']);
        ProjectStatus::create(['id' => 3, 'label' => 'Nonaktif']);
        ProjectStatus::create(['id' => 4, 'label' => 'Diarsipkan']);
    }
}
