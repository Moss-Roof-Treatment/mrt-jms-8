<?php

namespace Database\Seeders;

use App\Models\SeoTag;
use Illuminate\Database\Seeder;

class SeoTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeoTag::create([
            'description' => 'Roof Cleaning and Moss Removal in Regional Victoria - Cost effective roof cleaning and moss removal treatment for all surfaces. Freecall 1300 007 411',
            'thumbnail' => 'https://mossrooftreatment.com.au/public/images/seo-thumbnail.jpg'
        ]);
    }
}
