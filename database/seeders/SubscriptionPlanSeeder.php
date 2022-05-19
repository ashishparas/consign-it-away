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
                'content'       => 'Sell for free, you can get started today with all the features and add-ons you need. More info on this package shows you how much you will earn on an item based on its profit.' ,
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name' => 'Silver',
                'monthly_price' => '9.99',
                'yearly_price'  => '99.99',
                'content'       => 'Experience more earnings on profit with fewer fees and a larger listing limit than the free package. More info on this package shows you now much you will earn on an item based on profit. More info',
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

            [
                'name' => 'Gold',
                'monthly_price' => '39.99',
                'yearly_price'  => '399.99',
                'status'        => '1',
                'content'       => 'Our most popular package increases your earnings, listing limit, backgrounds removed per listing, and lowers your fees than the Seller package. More info about this package shows you how much you will earn on an item based on its profit. More info',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

            [
                'name' => 'Platinum',
                'monthly_price' => '99.99',
                'yearly_price'  => '999.99',
                'status'        => '1',
                'content'       => ' ❌ Our most popular package increases your earnings, listing limit, backgrounds removed per listing, and lowers your fees than the Seller package. More info about this package shows you how much you will earn on an item based on its profit. More info',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

            [
                'name' => 'Premium',
                'monthly_price' => '499.99',
                'yearly_price'  => '4999.99',
                'status'        => '1',
                'content'       => 'Raise earnings, lower fees, and receive more background removals for photos on a listing than the Business package. More info about this package shows you how much you will earn on an item based on its profit',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name' => 'Unlimited',
                'monthly_price' => '999.99',
                'yearly_price'  => '9999.99',
                'content'       => 'Raise earnings, lower fees, and receive more background removals for photos on a listing than the Business package. More info about this package shows you how much you will earn on an item based on its profit',
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

        ]);
    }
}
