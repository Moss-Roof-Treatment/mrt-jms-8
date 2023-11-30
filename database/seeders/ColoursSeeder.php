<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colour;

class ColoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Colour::create([
            'id' => 1,
            'title' => 'Blue',
            'colour' => '#0712a6',
            'brand' => 'primary',
            'text_colour' => '#ffffff',
            'text_brand' => 'white'
        ]);

        Colour::create([
            'id' => 2,
            'title' => 'Red',
            'colour' => '#ff3860',
            'brand' => 'danger',
            'text_colour' => '#ffffff',
            'text_brand' => 'white'
        ]);

        Colour::create([
            'id' => 3,
            'title' => 'Yellow',
            'colour' => '#ffed4a',
            'brand' => 'warning',
            'text_colour' => '#000000',
            'text_brand' => 'dark'
        ]);

        Colour::create([
            'id' => 4,
            'title' => 'Green',
            'colour' => '#00d1b2',
            'brand' => 'success',
            'text_colour' => '#000000',
            'text_brand' => 'dark'
        ]);

        Colour::create([
            'id' => 5,
            'title' => 'Orange',
            'colour' => '#db5800',
            'brand' => 'secondary',
            'text_colour' => '#ffffff',
            'text_brand' => 'white'
        ]);

        Colour::create([
            'id' => 6,
            'title' => 'Light',
            'colour' => '#f5f5f5',
            'brand' => 'light',
            'text_colour' => '#000000',
            'text_brand' => 'dark'
        ]);

        Colour::create([
            'id' => 7,
            'title' => 'Dark',
            'colour' => '#363636',
            'brand' => 'dark',
            'text_colour' => '#ffffff',
            'text_brand' => 'white'
        ]);
    }
}
