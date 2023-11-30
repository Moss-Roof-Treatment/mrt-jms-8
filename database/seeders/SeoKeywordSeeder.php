<?php

namespace Database\Seeders;

use App\Models\SeoKeyword;
use Illuminate\Database\Seeder;

class SeoKeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SeoKeyword::create([
            'keyword' => 'moss removal treatment'
        ]);

        SeoKeyword::create([
            'keyword' => 'moss roof treatment'
        ]);

        SeoKeyword::create([
            'keyword' => 'moss treatment'
        ]);

        SeoKeyword::create([
            'keyword' => 'moss removal'
        ]);

        SeoKeyword::create([
            'keyword' => 'roof cleaning'
        ]);

        SeoKeyword::create([
            'keyword' => 'roof cleaning geelong'
        ]);

        SeoKeyword::create([
            'keyword' => 'roof cleaning ballarat'
        ]);

        SeoKeyword::create([
            'keyword' => 'moss removal geelong'
        ]);

        SeoKeyword::create([
            'keyword' => 'moss removal ballarat'
        ]);

        SeoKeyword::create([
            'keyword' => 'roof moss removal'
        ]);

        SeoKeyword::create([
            'keyword' => 'roof moss'
        ]);

        SeoKeyword::create([
            'keyword' => 'cleaning moss'
        ]);

        SeoKeyword::create([
            'keyword' => 'moss cleaning'
        ]);

        SeoKeyword::create([
            'keyword' => 'cleaning'
        ]);
    }
}
