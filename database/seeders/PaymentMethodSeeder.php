<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        PaymentMethod::create([ 'id' => 1, 'label' => 'Transfer Bank' ]);
        PaymentMethod::create([ 'id' => 2, 'label' => 'Transfer eWallet' ]);
        PaymentMethod::create([ 'id' => 3, 'label' => 'Virtual Account' ]);
        PaymentMethod::create([ 'id' => 4, 'label' => 'DANA' ]);
        PaymentMethod::create([ 'id' => 5, 'label' => 'ShopeePay' ]);
        PaymentMethod::create([ 'id' => 6, 'label' => 'QRIS' ]);
    }
}
