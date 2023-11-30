<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuildingStylePostType;

class BuildingStylePostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingStylePostType::create([
            'id' => 1,
            'title' => 'Retirement Villages',
            'description' => 'Retirement Facilities and Villages are perfect for MRT as it is cost effective and is an easier, hassle free job to complete.',
            'image_path' => 'storage/images/buildingStylePostTypes/retirement-villages-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 2,
            'title' => 'Garages & Sheds',
            'description' => 'MRT is great for garages and garden sheds that are at the back of the property. Often, they are overlooked with the house being the main concern. MRT can be easily applied to these buildings.',
            'image_path' => 'storage/images/buildingStylePostTypes/garages-and-garden-sheds-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 3,
            'title' => 'Standard House',
            'description' => 'Standard housing is the most common for our treatment service. These jobs can take roughly between 2-3 hours for a standard size home, making it hassle free and simple for the customer.',
            'image_path' => 'storage/images/buildingStylePostTypes/standard-house-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 4,
            'title' => 'Steep Pitched Roofs',
            'description' => 'Moss Roof Treatment is fantastic for steep pitch roofs, as pressure cleaning them can be a challenge and generally costs more. Our medium pressure spray unit can reach up to 10 metres making these steep roofs much more suitable for the treatment.',
            'image_path' => 'storage/images/buildingStylePostTypes/steep-pitch-roof-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 5,
            'title' => 'Pergolas & Verandas',
            'description' => 'Pergola and Veranda areas are also ideal for MRT as these are generally are laserlight and it is not recommended to high pressure clean them. You also get to watch the progress of these areas from underneath.',
            'image_path' => 'storage/images/buildingStylePostTypes/pergola-and-verandas-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 6,
            'title' => 'Double Storey Roofs',
            'description' => 'MRT is great for double storey roofs as it is much safe to apply the treatment than use pressure cleaning. Using specialised ladders, we can reach double storey roofs with ease and apply the treatment.',
            'image_path' => 'storage/images/buildingStylePostTypes/double-storey-roofs-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 7,
            'title' => 'Churches',
            'description' => 'MRT is great for older styled buildings such as churches as the treatment can be applied quicker to large areas at a lower cost, compared to pressure cleaning. Also, a great maintenance option to keeping roofs clean for these buildings.',
            'image_path' => 'storage/images/buildingStylePostTypes/churches-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 8,
            'title' => 'Schools',
            'description' => 'MRT is great for Schools as the treatment can be applied quicker to large areas at a lower cost, compared to pressure cleaning. Also, a great maintenance option to keeping roofs clean for these buildings.',
            'image_path' => 'storage/images/buildingStylePostTypes/schools-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 9,
            'title' => 'Grand Designs',
            'description' => 'MRT is great for odd shaped or grand design buildings where pressure cleaning may prove to be difficult or not ideal. The moss treatment can be applied from ladders and can be done completed with ease.',
            'image_path' => 'storage/images/buildingStylePostTypes/grand-designs-500x375.jpg'
        ]);

        BuildingStylePostType::create([
            'id' => 10,
            'title' => 'Industrial Buildings',
            'description' => 'Colorbond Industrial sheds or buildings can get more growing on them, especially on the light sheets. Applying MRT to these surfaces will kill any moss and wash it away overtime, keeping the colorbond and the laserlight sheets clean. Much easier process then pressure cleaning which can disturb day to day work within the industrial shed.',
            'image_path' => 'storage/images/buildingStylePostTypes/industrial-buildings-500x375.jpg'
        ]);
    }
}
