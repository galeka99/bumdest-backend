<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProvinceSeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            GenderSeeder::class,
            RoleSeeder::class,
            UserStatusSeeder::class,
            UserSeeder::class,
            DepositStatusSeeder::class,
            PaymentMethodSeeder::class,
            ProjectStatusSeeder::class,
            InvestmentStatusSeeder::class,
        ]);
    }
}
