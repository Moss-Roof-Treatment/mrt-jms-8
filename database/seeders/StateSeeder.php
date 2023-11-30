<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'id' => 1,
            'title' => 'Australian Capital Territory'
        ]);

        State::create([
            'id' => 2,
            'title' => 'New South Wales'
        ]);

        State::create([
            'id' => 3,
            'title' => 'Northern Territory'
        ]);

        State::create([
            'id' => 4,
            'title' => 'Queensland'
        ]);

        State::create([
            'id' => 5,
            'title' => 'South Australia'
        ]);

        State::create([
            'id' => 6,
            'title' => 'Tasmania'
        ]);

        State::create([
            'id' => 7,
            'title' => 'Victoria'
        ]);

        State::create([
            'id' => 8,
            'title' => 'Western Australia'
        ]);
    }
}
