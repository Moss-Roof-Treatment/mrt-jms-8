<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dimension;

class DimensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dimension::create([
            'title' => 'Length',
            'unit' => 'Metre',
            'sign' => 'm',
            'description' => 'Length per Metre'
        ]);

        Dimension::create([
            'title' => 'Area',
            'unit' => 'Metre',
            'sign' => 'm2',
            'description' => 'Area per Metre'
        ]);

        Dimension::create([
            'title' => 'Volume',
            'unit' => 'Metre',
            'sign' => 'm3',
            'description' => 'Volume per Metre'
        ]);

        Dimension::create([
            'title' => 'Time',
            'unit' => 'Hour',
            'sign' => 'Hours',
            'description' => 'Length per Hour'
        ]);

        Dimension::create([
            'title' => 'Each',
            'unit' => 'Item',
            'sign' => 'Item',
            'description' => 'Each per Item'
        ]);

        Dimension::create([
            'title' => 'Distance',
            'unit' => 'Kilometre',
            'sign' => 'km',
            'description' => 'Distance per Kilometre'
        ]);
    }
}
