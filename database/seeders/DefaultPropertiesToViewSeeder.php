<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DefaultPropertiesToView;

class DefaultPropertiesToViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultPropertiesToView::create([
            'title' => 'Geelong Cement Properties',
            'property_1' => '7 Shannahan Dr, Norlane VIC 3214',
            'property_2' => '1 Westmoreland St, St Albans Park VIC 3219',
            'property_3' => '43 Olympic Ave, Norlane VIC 3214',
            'property_4' => '36 Westmoreland St, St Albans Park VIC 3219'
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Geelong Terracotta Properties',
            'property_1' => '212 McKillop St, East Geelong VIC 3219',
            'property_2' => '210 McKillop St, East Geelong VIC 3219',
            'property_3' => '17 Spring St, Belmont VIC 3216',
            'property_4' => '232 Myers St, Geelong VIC 3220'
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Geelong Iron/Colorbond Properties',
            'property_1' => '3/155 Hope St, Geelong West',
            'property_2' => '37 Victory Way, Highton VIC 3216',
            'property_3' => '40 Meakin St, East Geelong VIC 3219',
            'property_4' => '7 Jabiru Cl, Ocean Grove VIC 3226'
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Geelong Laser Light Properties',
            'property_1' => '',
            'property_2' => '',
            'property_3' => '',
            'property_4' => ''
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Geelong Slate Properties',
            'property_1' => '',
            'property_2' => '',
            'property_3' => '',
            'property_4' => ''
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Geelong Pre-Painted Properties',
            'property_1' => '17 Spring Street, Belmont - Applied 3/8/2018',
            'property_2' => '15 Fairbrae Ave, Belmont - Applied 20/3/2018',
            'property_3' => '33 Laura Avenue, Belmont - Applied 24/3/2020',
            'property_4' => '46 Barrabool Rd, Highton - Applied 27/6/2018'
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Ballarat Cement Properties',
            'property_1' => '',
            'property_2' => '',
            'property_3' => '',
            'property_4' => ''
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Ballarat Terracotta Properties',
            'property_1' => '22 Lovenear Grove, Ballarat East - Applied 22/10/2019',
            'property_2' => '11 Robert Drive, Ballarat North - Applied 28/01/2020',
            'property_3' => '2 Malmesbury Street, Wendouree - Applied 31/7/2019',
            'property_4' => '60, 84, 86 Cunninghams Road, Werribee South - Applied 3/3/2020'
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Ballarat Iron/Colorbond Properties',
            'property_1' => '',
            'property_2' => '',
            'property_3' => '',
            'property_4' => ''
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Ballarat Laser Light Properties',
            'property_1' => '',
            'property_2' => '',
            'property_3' => '',
            'property_4' => ''
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Ballarat Slate Properties',
            'property_1' => '',
            'property_2' => '',
            'property_3' => '',
            'property_4' => ''
        ]);

        DefaultPropertiesToView::create([
            'title' => 'Ballarat Pre-Painted Properties',
            'property_1' => '',
            'property_2' => '',
            'property_3' => '',
            'property_4' => ''
        ]);
    }
}
