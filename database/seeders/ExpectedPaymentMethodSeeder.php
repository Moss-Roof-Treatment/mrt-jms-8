<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpectedPaymentMethod;

class ExpectedPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpectedPaymentMethod::create([
            'id' => 1,
            'title' => 'Not Specified',
            'description' => 'The customer has not specified how they are going to pay.',
            'payment_type_id' => null, // null.
            'payment_method_id' => null // null.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 2,
            'title' => 'Will Pay Deposit By Card',
            'description' => 'The customer has instructed staff that they are going to pay the deposit by card.',
            'payment_type_id' => null, // null.
            'payment_method_id' => null // null.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 3,
            'title' => 'Will Pay Deposit By Bank',
            'description' => 'The customer has instructed staff that they are going to pay the deposit by bank.',
            'payment_type_id' => null, // null.
            'payment_method_id' => null // null.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 4,
            'title' => 'Will Pay Deposit By Cheque',
            'description' => 'The customer has instructed staff that they are going to pay the deposit by cheque.',
            'payment_type_id' => null, // null.
            'payment_method_id' => null // null.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 5, // 2
            'title' => 'Deposit Paid By Card',
            'description' => 'The customer has paid the deposit by card.',
            'payment_type_id' => 1, // Deposit.
            'payment_method_id' => 4 // Card.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 6, // 4
            'title' => 'Deposit Paid By Bank',
            'description' => 'The customer has paid the deposit by bank deposit.',
            'payment_type_id' => 1, // Deposit.
            'payment_method_id' => 1 // Bank.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 7, // 3
            'title' => 'Deposit Paid By Cheque',
            'description' => 'The customer has paid the deposit by cheque.',
            'payment_type_id' => 1, // Deposit.
            'payment_method_id' => 5 // Cheque.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 8, // 5
            'title' => 'Total Card On Completion',
            'description' => 'The customer has specified that the final bill will be paid by card on completion.',
            'payment_type_id' => 2, // Deposit.
            'payment_method_id' => 4 // Card.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 9, // 6
            'title' => 'Total Cash On Completion',
            'description' => 'The customer has specified that the final bill will be paid by cash on completion.',
            'payment_type_id' => 2, // Deposit.
            'payment_method_id' => 2 // Cash.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 10, // 8
            'title' => 'Total Bank On Completion',
            'description' => 'The customer has specified that the final bill will be paid by bank on completion.',
            'payment_type_id' => 2, // Deposit.
            'payment_method_id' => 1 // Bank.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 11, // 7
            'title' => 'Total Cheque On Completion',
            'description' => 'The customer has specified that the final bill will be paid by cheque on completion.',
            'payment_type_id' => 2, // Deposit.
            'payment_method_id' => 5 // Cheque.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 12,
            'title' => 'Total Paid',
            'description' => 'The total required payment has been received from the customer.',
            'payment_type_id' => null, // null.
            'payment_method_id' => null // null.
        ]);

        ExpectedPaymentMethod::create([
            'id' => 13,
            'title' => 'Deposit Paid By Cash',
            'description' => 'The customer has paid the deposit by cash and a staff member has manually entered the deposit payment.',
            'payment_type_id' => 1, // Deposit.
            'payment_method_id' => 2 // Cash.
        ]);
    }
}
