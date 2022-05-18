<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscription_plans')->insert([
            [
                'name' => 'Bronze',
                'monthly_price' => '0.00',
                'yearly_price'  => '0.00',
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name' => 'Silver',
                'monthly_price' => '9.99',
                'yearly_price'  => '99.99',
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

            [
                'name' => 'Gold',
                'monthly_price' => '39.99',
                'yearly_price'  => '399.99',
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name' => 'Premium',
                'monthly_price' => '499.99',
                'yearly_price'  => '4999.99',
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name' => 'Unlimited',
                'monthly_price' => '999.99',
                'yearly_price'  => '9999.99',
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

        ]);
    }
}
