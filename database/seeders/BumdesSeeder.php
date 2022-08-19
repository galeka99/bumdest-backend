<?php

namespace Database\Seeders;

use App\Models\Bumdes;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BumdesSeeder extends Seeder
{
    public function run()
    {
        $bumdes = Bumdes::create([
            'code' => '96d5e10b443649bfb53003936b49a57b',
            'name' => 'Sukamaju Village',
            'phone' => '081234567890',
            'balance' => 0,
            'district_id' => 337410,
            'address' => 'Sendangmulyo',
            'postal_code' => '50272',
            'description' => 'Just an ordinary BUMDes',
            'maps_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d771.7858997280559!2d110.4742544789766!3d-7.040220734203237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708dccb7188301%3A0x32e6e99e036979a0!2sJl.%20Perum%20Griya%20Tria%20Indah%20II%20No.27%2C%20Sendangmulyo%2C%20Kec.%20Tembalang%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050272!5e0!3m2!1sid!2sid!4v1658887973531!5m2!1sid!2sid'
        ]);
        
        User::create([
            'name' => 'Galang',
            'email' => 'galang@gmail.com',
            'password' => Hash::make('galang'),
            'phone' => '089656544023',
            'balance' => 0,
            'address' => 'Perum Griya Tria Indah 2 no.27 Sendangmulyo',
            'postal_code' => '50272',
            'district_id' => 337410,
            'gender_id' => 1,
            'role_id' => 2,
            'user_status_id' => 1,
            'bumdes_id' => $bumdes->id,
            'verified' => true
        ]);
    }
}
