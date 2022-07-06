<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    public function run()
    {
        ProjectStatus::create(['id' => 1, 'label' => 'In Plan']);
        ProjectStatus::create(['id' => 2, 'label' => 'Running']);
        ProjectStatus::create(['id' => 3, 'label' => 'Nonactive']);
        ProjectStatus::create(['id' => 4, 'label' => 'Archived']);
    }
}
