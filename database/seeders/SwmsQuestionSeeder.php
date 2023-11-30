<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SwmsQuestion;

class SwmsQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SWMS 1

        SwmsQuestion::create([
            'id' => 1,
            'swms_question_category_id' => 1,
            'question' => 'Location of anchor points if required.'
        ]);

        SwmsQuestion::create([
            'id' => 2,
            'swms_question_category_id' => 1,
            'question' => 'Location of ladder.'
        ]);

        SwmsQuestion::create([
            'id' => 3,
            'swms_question_category_id' => 1,
            'question' => 'No go zones identified.'
        ]);

        // SWMS 2

        SwmsQuestion::create([
            'id' => 4,
            'swms_question_category_id' => 2,
            'question' => 'Working above 2m in height.'
        ]);

        SwmsQuestion::create([
            'id' => 5,
            'swms_question_category_id' => 2,
            'question' => 'Working from ladders.'
        ]);

        SwmsQuestion::create([
            'id' => 6,
            'swms_question_category_id' => 2,
            'question' => 'Loose hoses.'
        ]);

        SwmsQuestion::create([
            'id' => 7,
            'swms_question_category_id' => 2,
            'question' => 'Pets in the backyard.'
        ]);

        SwmsQuestion::create([
            'id' => 8,
            'swms_question_category_id' => 2,
            'question' => 'Spray coming off the roof.'
        ]);

        SwmsQuestion::create([
            'id' => 9,
            'swms_question_category_id' => 2,
            'question' => 'Contact with product.'
        ]);

        SwmsQuestion::create([
            'id' => 10,
            'swms_question_category_id' => 2,
            'question' => 'UV Rays.'
        ]);

        SwmsQuestion::create([
            'id' => 11,
            'swms_question_category_id' => 2,
            'question' => 'Electrical hazards.'
        ]);

        SwmsQuestion::create([
            'id' => 12,
            'swms_question_category_id' => 2,
            'question' => 'Moving spray unit.'
        ]);

        SwmsQuestion::create([
            'id' => 13,
            'swms_question_category_id' => 2,
            'question' => 'Filling motorized machine with petrol when hot.'
        ]);

        SwmsQuestion::create([
            'id' => 14,
            'swms_question_category_id' => 2,
            'question' => 'Working in adverse weather.'
        ]);

        // SWMS 3

        SwmsQuestion::create([
            'id' => 15,
            'swms_question_category_id' => 3,
            'question' => 'Application of Moss Roof Treatment.'
        ]);

        SwmsQuestion::create([
            'id' => 16,
            'swms_question_category_id' => 3,
            'question' => 'Disconnection of water tanks.'
        ]);

        SwmsQuestion::create([
            'id' => 17,
            'swms_question_category_id' => 3,
            'question' => 'Securing work site.'
        ]);

        SwmsQuestion::create([
            'id' => 18,
            'swms_question_category_id' => 3,
            'question' => 'Measuring product from one container to spray unit.'
        ]);

        SwmsQuestion::create([
            'id' => 19,
            'swms_question_category_id' => 3,
            'question' => 'Ladder secured top & bottom.'
        ]);

        SwmsQuestion::create([
            'id' => 20,
            'swms_question_category_id' => 3,
            'question' => 'Working above 2m, fall protection must be used.'
        ]);

        SwmsQuestion::create([
            'id' => 21,
            'swms_question_category_id' => 3,
            'question' => 'Secure work area with sign indicating roofer on-site.'
        ]);

        // SWMS 4

        SwmsQuestion::create([
            'id' => 22,
            'swms_question_category_id' => 4,
            'question' => 'Applying & using correct fall protection, including fall-arrest devices.'
        ]);

        SwmsQuestion::create([
            'id' => 23,
            'swms_question_category_id' => 4,
            'question' => 'Three point ladder contact.'
        ]);

        SwmsQuestion::create([
            'id' => 24,
            'swms_question_category_id' => 4,
            'question' => 'Secure hoses with ties.'
        ]);

        SwmsQuestion::create([
            'id' => 25,
            'swms_question_category_id' => 4,
            'question' => 'Pets to be separated from tradesmen when on site.'
        ]);

        SwmsQuestion::create([
            'id' => 26,
            'swms_question_category_id' => 4,
            'question' => 'No go zones for foot traffic.'
        ]);

        SwmsQuestion::create([
            'id' => 27,
            'swms_question_category_id' => 4,
            'question' => 'Goggles & long sleeves to be worn, correct spraying distance.'
        ]);

        SwmsQuestion::create([
            'id' => 28,
            'swms_question_category_id' => 4,
            'question' => 'Safety switch on electrical equipment. Set up away from wires.'
        ]);

        SwmsQuestion::create([
            'id' => 29,
            'swms_question_category_id' => 4,
            'question' => 'Locate trailer in position so spray unit can easily be loaded.'
        ]);

        SwmsQuestion::create([
            'id' => 30,
            'swms_question_category_id' => 4,
            'question' => 'Fill machine once it has cooled.'
        ]);

        SwmsQuestion::create([
            'id' => 31,
            'swms_question_category_id' => 4,
            'question' => 'Check weather conditions regularly.'
        ]);

        SwmsQuestion::create([
            'id' => 32,
            'swms_question_category_id' => 4,
            'question' => 'Call 000 in an emergency.'
        ]);
    }
}
