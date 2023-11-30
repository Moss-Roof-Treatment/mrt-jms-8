<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuoteSentStatus;

class QuoteSentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuoteSentStatus::create([
            'title' => 'None',
            'description' => 'No quote has been sent.'
        ]);

        QuoteSentStatus::create([
            'title' => 'Posted',
            'description' => 'A quote has been posted to the customer.'
        ]);

        QuoteSentStatus::create([
            'title' => 'Emailed',
            'description' => 'A quote has been emailed to the customer.'
        ]);

        QuoteSentStatus::create([
            'title' => 'Dropped off',
            'description' => 'A quote has been dropped off to the customer.'
        ]);

        QuoteSentStatus::create([
            'title' => 'Contract Posted',
            'description' => 'A contract has been posted to the customer.'
        ]);

        QuoteSentStatus::create([
            'title' => 'Sent To Mobile Phone',
            'description' => 'Sent the quote using text message to customer.'
        ]);
    }
}
