<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcategories')->insert([

            [
                'category_id' => 1,
                'title'   =>'Refrigerators, Freezers & Ice Makers',
                'image' => rand().'.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => carbon::now()
            ],
            [
                'category_id' => 1,
                'title'   =>'Dishwashers',
                'image' => rand().'.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => carbon::now()
            ],
            [
                'category_id' => 1,
                'title'   =>'Washers & Dryers',
                'image' => rand().'.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => carbon::now()
            ],
            [
                'category_id' => 1,
                'title'   =>'Ranges, Ovens & Cooktops',
                'image' => rand().'.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => carbon::now()
            ],
            [
                'category_id' => 1,
                'title'   =>'Heating, Cooling & Air Quality',
                'image' => rand().'.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => carbon::now()
            ],
            [
                'category_id' => 1,
                'title'   =>'Vacuums & Floor Care',
                'image' => rand().'.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => carbon::now()
            ],
            [
                'category_id' => 1,
                'title'   =>'Microwave Oven',
                'image' => rand().'.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => carbon::now()
            ]

        ]);
    }
}
