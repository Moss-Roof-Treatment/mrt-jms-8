<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuildingType;

class BuildingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          BuildingType::create([
            'id' => 1,
            'title' => 'House',
            'description' => 'This building is a house'
        ]);

        BuildingType::create([
            'id' => 2,
            'title' => 'Carport',
            'description' => 'This building is a carport'
        ]);

        BuildingType::create([
            'id' => 3,
            'title' => 'Veranda',
            'description' => 'This building is a veranda'
        ]);

        BuildingType::create([
            'id' => 4,
            'title' => 'Pergola',
            'description' => 'This building is a pergola'
        ]);

        BuildingType::create([
            'id' => 5,
            'title' => 'Garage',
            'description' => 'This building is a garage'
        ]);

        BuildingType::create([
            'id' => 6,
            'title' => 'Garden Shed',
            'description' => 'This building is a garden shed'
        ]);

        BuildingType::create([
            'id' => 7,
            'title' => 'Barn',
            'description' => 'This building is a barn.'
        ]);

        BuildingType::create([
            'id' => 8,
            'title' => 'Retirement Village',
            'description' => 'Expansive area with several buildings.'
        ]);

        BuildingType::create([
            'id' => 9,
            'title' => 'Industrial Shed',
            'description' => 'Big metal shed for a company or private property.'
        ]);

        BuildingType::create([
            'id' => 10,
            'title' => 'House Unit',
            'description' => 'Small roof area unit.'
        ]);

        BuildingType::create([
            'id' => 11,
            'title' => 'School Buildings',
            'description' => 'School buildings can vary.'
        ]);

        BuildingType::create([
            'id' => 12,
            'title' => 'Church',
            'description' => 'Church building generally pretty big and slate/terracotta tiles.'
        ]);

        BuildingType::create([
            'id' => 13,
            'title' => 'Shops',
            'description' => 'Shop front or shop and house combined.'
        ]);
    }
}
