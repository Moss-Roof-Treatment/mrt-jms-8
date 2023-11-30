<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EquipmentGroup;

class EquipmentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EquipmentGroup::create([
            'title' => 'category 1',
            'description' => 'Migas fanny pack edison bulb listicle dreamcatcher iPhone live-edge. Mlkshk gastropub yuccie meggings.'
        ]);

        EquipmentGroup::create([
            'title' => 'category 2',
            'description' => 'Migas fanny pack edison bulb listicle dreamcatcher iPhone live-edge. Mlkshk gastropub yuccie meggings.'
        ]);

        EquipmentGroup::create([
            'title' => 'category 3',
            'description' => 'Migas fanny pack edison bulb listicle dreamcatcher iPhone live-edge. Mlkshk gastropub yuccie meggings.'
        ]);
    }
}
