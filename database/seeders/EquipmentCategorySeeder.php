<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquipmentCategory;

class EquipmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EquipmentCategory::create([
            'title' => 'category 1',
            'description' => 'Migas fanny pack edison bulb listicle dreamcatcher iPhone live-edge. Mlkshk gastropub yuccie meggings.'
        ]);

        EquipmentCategory::create([
            'title' => 'category 2',
            'description' => 'Migas fanny pack edison bulb listicle dreamcatcher iPhone live-edge. Mlkshk gastropub yuccie meggings.'
        ]);

        EquipmentCategory::create([
            'title' => 'category 3',
            'description' => 'Migas fanny pack edison bulb listicle dreamcatcher iPhone live-edge. Mlkshk gastropub yuccie meggings.'
        ]);
    }
}
