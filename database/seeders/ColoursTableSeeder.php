<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colours')->insert([
            [
                'name' => 'Black',
                'code' => '#000000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Cool black',
                'code' => '#002e63',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Purple',
                'code' => '#800080',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Dark brown',
                'code' => '#654321',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Red brown',
                'code' => '#a52a2a',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Light brown',
                'code' => '#b5651d',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Blue',
                'code' => '#0000ff',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],  
            [
                'name' => 'Waterspout',
                'code' => '#00ffff',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], 
            [
                'name' => 'Green',
                'code' => '#00ff00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], 
            [
                'name' => 'Yellow',
                'code' => '#ffff00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], 
            [
                'name' => 'Gold',
                'code' => '#ffd700',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Orange',
                'code' => '#ffa500',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Orange red',
                'code' => '#ff4500',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Red',
                'code' => '#ff0000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Bronze',
                'code' => '#cd7f32',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Gray',
                'code' => '#808080',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Red Orange',
                'code' => '#ff5349',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Orange Yellow',
                'code' => '#f8d568',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Light green',
                'code' => '#90ee90',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Silver',
                'code' => '#c0c0c0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Light blue',
                'code' => '#add8e6',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pink',
                'code' => '#ffc0cb',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Light yellow',
                'code' => '#ffffed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'White',
                'code' => '#ffffff',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
