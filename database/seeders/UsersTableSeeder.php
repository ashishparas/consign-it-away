<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $data = [
            'name'  => 'Admin User',
            'fname' => 'Admin',
            'lname' => 'User',
            'email' => 'consign_it_away@admin.com',
            'password'  => Hash::make('12345678'),
            'mobile_no' => '98166422',
            'type'      => '4',
            'marital_status'    => '1',
  
        ];
        $user = \App\Models\User::create($data);
        $user->assignRole('admin');

    }
}
