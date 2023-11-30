<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaterialType;

class MaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaterialType::create([
            'title' => 'Cement',
            'description' => 'This material is made of Cement.',
            'mpa_coverage' => 1.00
        ]);

        MaterialType::create([
            'title' => 'Terracotta',
            'description' => 'This material is made of Terracotta.',
            'mpa_coverage' => 1.10
        ]);

        MaterialType::create([
            'title' => 'Iron/Colorbond',
            'description' => 'This material is made of Metal.',
            'mpa_coverage' => 1.20
        ]);

        MaterialType::create([
            'title' => 'Laser Light',
            'description' => 'This material is made of Laser Light.',
            'mpa_coverage' => 1.30
        ]);

        MaterialType::create([
            'title' => 'Slate',
            'description' => 'This material is made of Slate.',
            'mpa_coverage' => 1.40
        ]);

        MaterialType::create([
            'title' => 'Pre-Painted',
            'description' => 'Pre-Painted Iron or tiled roof.',
            'mpa_coverage' => 1.50
        ]);
    }
}
