<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TermsHeading;

class TermsHeadingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        TermsHeading::create([
            'title' => 'Definitions'
        ]);

        // 2
        TermsHeading::create([
            'title' => 'Client’s Obligations'
        ]);

        // 3
        TermsHeading::create([
            'title' => 'Performance of the Services'
        ]);

        // 4
        TermsHeading::create([
            'title' => 'Fees and Payment'
        ]);

        // 5
        TermsHeading::create([
            'title' => 'GST'
        ]);

        // 6
        TermsHeading::create([
            'title' => 'Confidentiality'
        ]);

        // 7
        TermsHeading::create([
            'title' => 'Performance Guarantee'
        ]);

        // 8
        TermsHeading::create([
            'title' => 'Limitation of Liability and Indemnity'
        ]);

        // 9
        TermsHeading::create([
            'title' => 'General Matters'
        ]);
    }
}
