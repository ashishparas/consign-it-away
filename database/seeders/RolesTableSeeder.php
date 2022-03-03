<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
               'name' => 'admin',
               'label' => 'admin',
               'created_at' => \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now(),
             ],
            [
               'name' => 'user',
               'label' => 'user',
               'created_at' => \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now(),
             ],
            [
               'name' => 'vendor',
               'label' => 'vendor',
               'created_at' => \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now(),
             ],
 
 
         ]);
    }
}
