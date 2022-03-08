<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        Province::create(['id' => 11, 'nama' => 'ACEH']);
        Province::create(['id' => 12, 'nama' => 'SUMATERA UTARA']);
        Province::create(['id' => 13, 'nama' => 'SUMATERA BARAT']);
        Province::create(['id' => 14, 'nama' => 'RIAU']);
        Province::create(['id' => 15, 'nama' => 'JAMBI']);
        Province::create(['id' => 16, 'nama' => 'SUMATERA SELATAN']);
        Province::create(['id' => 17, 'nama' => 'BENGKULU']);
        Province::create(['id' => 18, 'nama' => 'LAMPUNG']);
        Province::create(['id' => 19, 'nama' => 'KEPULAUAN BANGKA BELITUNG']);
        Province::create(['id' => 21, 'nama' => 'KEPULAUAN RIAU']);
        Province::create(['id' => 31, 'nama' => 'DKI JAKARTA']);
        Province::create(['id' => 32, 'nama' => 'JAWA BARAT']);
        Province::create(['id' => 33, 'nama' => 'JAWA TENGAH']);
        Province::create(['id' => 34, 'nama' => 'DAERAH ISTIMEWA YOGYAKARTA']);
        Province::create(['id' => 35, 'nama' => 'JAWA TIMUR']);
        Province::create(['id' => 36, 'nama' => 'BANTEN']);
        Province::create(['id' => 51, 'nama' => 'BALI']);
        Province::create(['id' => 52, 'nama' => 'NUSA TENGGARA BARAT']);
        Province::create(['id' => 53, 'nama' => 'NUSA TENGGARA TIMUR']);
        Province::create(['id' => 61, 'nama' => 'KALIMANTAN BARAT']);
        Province::create(['id' => 62, 'nama' => 'KALIMANTAN TENGAH']);
        Province::create(['id' => 63, 'nama' => 'KALIMANTAN SELATAN']);
        Province::create(['id' => 64, 'nama' => 'KALIMANTAN TIMUR']);
        Province::create(['id' => 65, 'nama' => 'KALIMANTAN UTARA']);
        Province::create(['id' => 71, 'nama' => 'SULAWESI UTARA']);
        Province::create(['id' => 72, 'nama' => 'SULAWESI TENGAH']);
        Province::create(['id' => 73, 'nama' => 'SULAWESI SELATAN']);
        Province::create(['id' => 74, 'nama' => 'SULAWESI TENGGARA']);
        Province::create(['id' => 75, 'nama' => 'GORONTALO']);
        Province::create(['id' => 76, 'nama' => 'SULAWESI BARAT']);
        Province::create(['id' => 81, 'nama' => 'MALUKU']);
        Province::create(['id' => 82, 'nama' => 'MALUKU UTARA']);
        Province::create(['id' => 91, 'nama' => 'P A P U A']);
        Province::create(['id' => 92, 'nama' => 'PAPUA BARAT']);
    }
}
