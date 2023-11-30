<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TermsSubHeading;

class TermsSubHeadingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1  
        TermsSubHeading::create([
            'terms_heading_id' => 1,
            'title' => 'The following definitions apply in this Agreement:',
        ]);

        // 2
        TermsSubHeading::create([
            'terms_heading_id' => 2,
            'title' => '2.1 The Client agrees to:',
        ]);

        // 3
        TermsSubHeading::create([
            'terms_heading_id' => 2,
            'title' => '2.2 The Client will, as soon as practicable, advise MRT of any defect in the provision of the Services.',
        ]);

        // 4
        TermsSubHeading::create([
            'terms_heading_id' => 3,
            'title' => 'In providing the Services, MRT will:',
        ]);

        // 5
        TermsSubHeading::create([
            'terms_heading_id' => 4,
            'title' => 'Fees and Payment:',
        ]);

        // 6
        TermsSubHeading::create([
          'terms_heading_id' => 5,
          'title' => 'Goods and Services Tax:',
        ]);

        // 7
        TermsSubHeading::create([
          'terms_heading_id' => 6,
          'title' => 'Confidentiality:',
        ]);

        // 8
        TermsSubHeading::create([
          'terms_heading_id' => 7,
          'title' => 'Performance Guarantee:',
        ]);

        // 9
        TermsSubHeading::create([
          'terms_heading_id' => 8,
          'title' => 'Limitation of Liability and Indemnity:',
        ]);

        // 10
        TermsSubHeading::create([
          'terms_heading_id' => 9,
          'title' => 'General Matters:',
        ]);
    }
}
