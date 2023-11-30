<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuoteStatus;

class QuoteStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuoteStatus::create([
            'id' => 1,
            'title' => 'New',
            'description' => 'This quote is new.'
        ]);

        QuoteStatus::create([
            'id' => 2,
            'title' => 'Pending',
            'description' => 'This quote is pending.'
        ]);

        QuoteStatus::create([
            'id' => 3,
            'title' => 'Sold (Deposit Paid)',
            'description' => 'This quote has been accepted by the customer and a deposit has been paid'
        ]);

        QuoteStatus::create([
            'id' => 4,
            'title' => 'Sold (Deposit Pending)',
            'description' => 'This quote has been accepted by the customer and no deposit has been paid.'
        ]);

        QuoteStatus::create([
            'id' => 5,
            'title' => 'Sold (Payment On Completion)',
            'description' => 'This quote has been accepted by the customer and payment will be made on completion.'
        ]);

        QuoteStatus::create([
            'id' => 6,
            'title' => 'Completed',
            'description' => 'This quote has been completed.'
        ]);

        QuoteStatus::create([
            'id' => 7,
            'title' => 'Paid',
            'description' => 'This quote has been paid.'
        ]);

        QuoteStatus::create([
            'id' => 8,
            'title' => 'Not Given',
            'description' => 'This quote has been rejected by the customer.'
        ]);

        QuoteStatus::create([
            'id' => 9,
            'title' => 'Not Quoted',
            'description' => 'The quote has been prepared and sent to the customer and they are non responsive and showing no interest..'
        ]);
    }
}
