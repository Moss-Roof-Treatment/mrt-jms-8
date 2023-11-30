<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Moss Roof Treatment Colorbond 5Lt',
            'slug' => 'moss-roof-treatment-colorbond-5Lt',
            'details' => 'Spray moss roof treatment to colorbond surfaces that are covered in moss.',
            'description' => '1 x 5Lt container of Moss Roof Treatment for you to apply yourself.',
            'cost_price' => 7200,
            'profit_amount' => 2200,
            'postage_price' => 500,
            'price' => 9900,
            'is_visible' => 1,
            'document_path' => 'storage/documents/products/mrt-technical-bulletin.pdf'
        ]);

        Product::create([
            'name' => 'Moss Roof Treatment Terracotta 5Lt',
            'slug' => 'moss-roof-treatment-terracotta-5Lt',
            'details' => 'Spray moss roof treatment to terracotta surfaces that are covered in moss.',
            'description' => '1 x 5Lt container of Moss Roof Treatment for you to apply yourself.',
            'cost_price' => 7200,
            'profit_amount' => 2200,
            'postage_price' => 500,
            'price' => 9900,
            'is_visible' => 1,
            'document_path' => 'storage/documents/products/mrt-technical-bulletin.pdf'
        ]);

        Product::create([
            'name' => 'Moss Roof Treatment Colorbond 15Lt',
            'slug' => 'moss-roof-treatment-colorbond-15Lt',
            'details' => 'Spray moss roof treatment to colorbond surfaces that are covered in moss.',
            'description' => '1 x 15Lt container of Moss Roof Treatment for you to apply yourself.',
            'cost_price' => 18800,
            'profit_amount' => 5200,
            'postage_price' => 1000,
            'price' => 25000,
            'is_visible' => 1,
            'document_path' => 'storage/documents/products/mrt-technical-bulletin.pdf'
        ]);

        Product::create([
            'name' => 'Moss Roof Treatment Terracotta 15Lt',
            'slug' => 'moss-roof-treatment-terracotta-15Lt',
            'details' => 'Spray moss roof treatment to terracotta surfaces that are covered in moss.',
            'description' => '1 x 15Lt container of Moss Roof Treatment for you to apply yourself.',
            'cost_price' => 18800,
            'profit_amount' => 5200,
            'postage_price' => 1000,
            'price' => 25000,
            'is_visible' => 1,
            'document_path' => 'storage/documents/products/mrt-technical-bulletin.pdf'
        ]);

        Product::create([
            'name' => 'MRT 15Lt Bottle',
            'slug' => 'mrt-15Lt-bottle',
            'details' => 'The generic bottle used by tradespersons on jobs.',
            'description' => '1 x 15Lt container of Moss Roof Treatment for the tradsperson to apply.',
            'cost_price' => 0,
            'profit_amount' => 0,
            'postage_price' => 0,
            'price' => 0,
            'is_visible' => 0,
            'document_path' => 'storage/documents/products/mrt-technical-bulletin.pdf'
        ]);

        Product::create([
            'name' => 'Petrol',
            'slug' => 'petrol',
            'details' => 'The petrol used by tradespersons to travel to and from jobs.',
            'description' => '1 x Litre of petrol for the work vehicle.',
            'cost_price' => 0,
            'profit_amount' => 0,
            'postage_price' => 0,
            'price' => 0,
            'is_visible' => 0,
        ]);
    }
}
