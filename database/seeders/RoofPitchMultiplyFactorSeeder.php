<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoofPitchMultiplyFactor;

class RoofPitchMultiplyFactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoofPitchMultiplyFactor::create([
            'min' => 1,
            'max' => 4,
            'value' => 1.003
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 5,
            'max' => 9,
            'value' => 1.014
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 10,
            'max' => 14,
            'value' => 1.031
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 15,
            'max' => 19,
            'value' => 1.054
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 20,
            'max' => 24,
            'value' => 1.083
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 25,
            'max' => 29,
            'value' => 1.158
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 30,
            'max' => 34,
            'value' => 1.250
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 35,
            'max' => 39,
            'value' => 1.302
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 40,
            'max' => 44,
            'value' => 1.414
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 45,
            'max' => 49,
            'value' => 1.537
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 50,
            'max' => 54,
            'value' => 1.734
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 55,
            'max' => 59,
            'value' => 1.944
        ]);

        RoofPitchMultiplyFactor::create([
            'min' => 60,
            'max' => 65,
            'value' => 2.236
        ]);
    }
}
