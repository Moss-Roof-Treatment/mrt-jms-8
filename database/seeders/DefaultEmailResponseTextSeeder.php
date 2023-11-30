<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DefaultEmailResponseText;

class DefaultEmailResponseTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultEmailResponseText::create([
            'text' => 'Went with cheaper job.',
            'type' => 1
        ]);

        DefaultEmailResponseText::create([
            'text' => 'Not able to proceed at this time.',
            'type' => 1
        ]);

        DefaultEmailResponseText::create([
            'text' => 'Going to do other work on house.',
            'type' => 1
        ]);

        DefaultEmailResponseText::create([
            'text' => "Didn't like quote and or customer service.",
            'type' => 1
        ]);

        DefaultEmailResponseText::create([
            'text' => 'Other.',
            'type' => 1
        ]);

        DefaultEmailResponseText::create([
            'text' => 'Default waiting text 1.',
            'type' => 0
        ]);

        DefaultEmailResponseText::create([
            'text' => 'Default waiting text 2.',
            'type' => 0
        ]);

        DefaultEmailResponseText::create([
            'text' => 'Default waiting text 3.',
            'type' => 0
        ]);

        DefaultEmailResponseText::create([
            'text' => 'Default waiting text 4.',
            'type' => 0
        ]);
    }
}
