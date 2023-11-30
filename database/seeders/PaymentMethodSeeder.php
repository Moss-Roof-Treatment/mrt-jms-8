<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'id' => 1,
            'title' => 'Bank Transfer',
            'description' => 'The payment is made via a bank transfer.'
        ]);

        PaymentMethod::create([
            'id' => 2,
            'title' => 'Cash',
            'description' => 'The payment is made via cash.'
        ]);

        PaymentMethod::create([
            'id' => 3,
            'title' => 'Direct Debit',
            'description' => 'The payment is made via direct debit.'
        ]);

        PaymentMethod::create([
            'id' => 4,
            'title' => 'Card',
            'description' => 'The payment is made via the payment card.'
        ]);

        PaymentMethod::create([
            'id' => 5,
            'title' => 'Cheque',
            'description' => 'The payment is made via cheque.'
        ]);

        PaymentMethod::create([
            'id' => 6,
            'title' => 'Online Payment Gateway',
            'description' => 'The payment is made via the online payment gateway.'
        ]);
    }
}
