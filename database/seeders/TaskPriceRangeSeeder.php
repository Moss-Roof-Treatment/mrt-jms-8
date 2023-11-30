<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskPriceRange;

class TaskPriceRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskPriceRange::create([
            'min' => 20,
            'max' => 39,
            'price' => 1200
        ]);

        TaskPriceRange::create([
            'min' => 40,
            'max' => 59,
            'price' => 875
        ]);

        TaskPriceRange::create([
            'min' => 60,
            'max' => 79,
            'price' => 583
        ]);

        TaskPriceRange::create([
            'min' => 80,
            'max' => 99,
            'price' => 562
        ]);

        TaskPriceRange::create([
            'min' => 100,
            'max' => 119,
            'price' => 500
        ]);

        TaskPriceRange::create([
            'min' => 120,
            'max' => 139,
            'price' => 410
        ]);

        TaskPriceRange::create([
            'min' => 140,
            'max' => 159,
            'price' => 350
        ]);

        TaskPriceRange::create([
            'min' => 160,
            'max' => 179,
            'price' => 370
        ]);

        TaskPriceRange::create([
            'min' => 180,
            'max' => 199,
            'price' => 360
        ]);

        TaskPriceRange::create([
            'min' => 200,
            'max' => 219,
            'price' => 320
        ]);

        TaskPriceRange::create([
            'min' => 220,
            'max' => 259,
            'price' => 310
        ]);

        TaskPriceRange::create([
            'min' => 260,
            'max' => 299,
            'price' => 280
        ]);

        TaskPriceRange::create([
            'min' => 300,
            'max' => 319,
            'price' => 400
        ]);

        TaskPriceRange::create([
            'min' => 320,
            'max' => 339,
            'price' => 380
        ]);

        TaskPriceRange::create([
            'min' => 340,
            'max' => 359,
            'price' => 360
        ]);

        TaskPriceRange::create([
            'min' => 360,
            'max' => 379,
            'price' => 350
        ]);

        TaskPriceRange::create([
            'min' => 380,
            'max' => 399,
            'price' => 330
        ]);

        TaskPriceRange::create([
            'min' => 400,
            'max' => 599,
            'price' => 320
        ]);

        TaskPriceRange::create([
            'min' => 600,
            'max' => 999,
            'price' => 330
        ]);

        TaskPriceRange::create([
            'min' => 1000,
            'max' => 1999,
            'price' => 290
        ]);

        TaskPriceRange::create([
            'min' => 2000,
            'max' => 2999,
            'price' => 200
        ]);

        TaskPriceRange::create([
            'min' => 3000,
            'max' => 5999,
            'price' => 160
        ]);

        TaskPriceRange::create([
            'min' => 6000,
            'max' => 10000,
            'price' => 140
        ]);
    }
}
