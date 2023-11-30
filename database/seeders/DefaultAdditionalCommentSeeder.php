<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DefaultAdditionalComment;

class DefaultAdditionalCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultAdditionalComment::create([
            'text' => 'Quote is to apply Moss Roof Treatment to colorbond roof.',
        ]);

        DefaultAdditionalComment::create([
            'text' => 'Moss Roof Treatment is applied to the affected areas as indicated on the site plan & in discussion with the customer. The product is applied to completely saturate the moss & lichen to penetrate the surface. We use a Eco-friendly and Bio-degradable product to remove moss, mould and lichen. Our product has been tested & proven to kill moss, mould, lichen and algae from all roof types. The product is slow activating and works over a period of time. It will break down the moss and wash away overtime depending on wind and rain. We generally allow 12-18 months for this process. Please note gutters are not cleaned out as part of this process.',
        ]);
    }
}
