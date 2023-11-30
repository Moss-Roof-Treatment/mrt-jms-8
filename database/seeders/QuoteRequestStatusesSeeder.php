<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuoteRequestStatus;

class QuoteRequestStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuoteRequestStatus::create([
            'id' => 1,
            'title' => 'New',
            'description' => 'This is a new quote request that has not been seen.',
        ]);

        QuoteRequestStatus::create([
            'id' => 2,
            'title' => 'Pending',
            'description' => 'This is a quote request that has been seen and is pending being converted into a quote.',
        ]);

        QuoteRequestStatus::create([
            'id' => 3,
            'title' => 'Completed',
            'description' => 'This is a quote request that has been converted into a quote.',
        ]);
    }
}
