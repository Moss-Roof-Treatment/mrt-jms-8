<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rate;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rate::create([
            'title' => 'Trainee Easy',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 1000
        ]);

        Rate::create([
            'title' => 'Trainee Intermediate',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 2000
        ]);

        Rate::create([
            'title' => 'Trainee Hard',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 3000
        ]);

        Rate::create([
            'title' => 'Intermediate Easy',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 1000
        ]);

        Rate::create([
            'title' => 'Intermediate Intermediate',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 2000
        ]);

        Rate::create([
            'title' => 'Intermediate Hard',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 3000
        ]);

        Rate::create([
            'title' => 'Expert Easy',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 1000
        ]);

        Rate::create([
            'title' => 'Expert Intermediate',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 2000
        ]);

        Rate::create([
            'title' => 'Expert Hard',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 3000
        ]);
    }
}
