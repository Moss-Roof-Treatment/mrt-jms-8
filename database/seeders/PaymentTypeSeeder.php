<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'title' => 'Deposit',
            'description' => 'This payment is a deposit.'
        ]);

        PaymentType::create([
            'title' => 'Payment',
            'description' => 'This payment is a standard payment.'
        ]);

        PaymentType::create([
            'title' => 'Write Off',
            'description' => 'This amount has been written off.'
        ]);
    }
}
