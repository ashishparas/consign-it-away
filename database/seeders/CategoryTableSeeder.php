<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $arr = array(
        [
            'title' => 'Appliances',
            'image' => null,
            'type'  => 'Appliances',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ],
            [
                'title' => 'Auto Parts',
                'image' => null,
                'type'  => 'Auto_Parts',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Books',
                'image' => null,
                'type'  => 'books',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Clothing,Shoes,Jewelry',
                'image' => null,
                'type'  => 'Clothing_Shoes_Jewelry',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Collectibles & Fine Art',
                'image' => null,
                'type'  => 'Collectibles_Fine_Art',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Electronics',
                'image' => null,
                'type'  => 'Electronics',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Furniture',
                'image' => null,
                'type'  => 'Furniture',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Garden & Outdoors',
                'image' => null,
                'type'  => 'Garden_&_Outdoors',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Handmade',
                'image' => null,
                'type'  => 'Handmade',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Home Decor',
                'image' => null,
                'type'  => 'Home_Decor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Kitchen & Dinning',
                'image' => null,
                'type'  => 'Kitchen_&_Dinning',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Movies, Music & Games',
                'image' => null,
                'type'  => 'Movies_Music_Games',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Musical Instruments',
                'image' => null,
                'type'  => 'Musical_Instruments',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Office Products',
                'image' => null,
                'type'  => 'Office_Products',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Pet Supplies',
                'image' => null,
                'type'  => 'Pet_Supplies',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Sports and Outdoors',
                'image' => null,
                'type'  => 'Sports_and_Outdoors',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Toys & Games',
                'image' => null,
                'type'  => 'Toys_&_Games',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Tools & Home Improvements',
                'image' => null,
                'type'  => 'Tools_&_Home_Improvements',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
          
      );
     
      DB::table('categories')->insert($arr);
    }
}
