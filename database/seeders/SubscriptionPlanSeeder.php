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
                'features' => '[{"name":"Your product will be posted under Consign It Away Account."},{"name":"You have 24\/7 support on all your products just call our toll free number or you can chat with us on the Chat Box!"},{"name":"All messages answered for you by one of our staff, if question is to complex about your product and you did not give us enough information about your item"},{"name":"You will be asked answer these question."},{"name":"Consign It Away keeps track of every dollar and you have access anytime to look at realtime transactions."},{"name":"We make sure all the governent tax has been paid."},{"name":"Once you take a photo the background of the product will disaper!"},{"name":"Once you enter your products deminstions the best shipping provider will caculate and you can pick the best shipping for the purchaser."},{"name":"We will have schedualed pick up and delivery from your house to the purchaser for you!"},{"name":"scan barcodes"},{"name":"A Storefront to showcase your products and seller profile"},{"name":"Add Multiple stores"},{"name":"Print labels and scedule picks for your orders all within your Consign It Away account!"},{"name":"Add upto 2 staff members in your team for full business managemnet"},{"name":"Your product will be posted under your own instagram Account."},{"name":"Your product will be posted under your own facebook Account."},{"name":"Your product will be posted under your own consignt it away Account."}]',
                'active_img' =>'activate_1@3x.png',
                'inactive_img' => 'deactivate_1@3x.png',
                'status'        => '1',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name' => 'Silver',
                'monthly_price' => '9.99',
                'yearly_price'  => '99.99',
                'content'       => 'Experience more earnings on profit with fewer fees and a larger listing limit than the free package. More info on this package shows you now much you will earn on an item based on profit. More info',
                'features' => '[{"name":"Your product will be posted under Consign It Away Account."},{"name":"You have 24\\\/7 support on all your products just call our toll free number or you can chat with us on the Chat Box!"},{"name":"All messages answered for you by one of our staff, if question is to complex about your product and you did not give us enough information about your item. You will be asked answer these question."},{"name":"Consign It Away keeps track of every dollar and you have access anytime to look at realtime transactions."},{"name":"We make sure all the governent tax has been paid."},{"name":"Once you take a photo the background of the product will disaper!"},{"name":"Once you enter your products deminstions the best shipping provider will caculate and you can pick the best shipping for the purchaser."},{"name":"scan barcodes"},{"name":"A Storefront to showcase your products and seller profile"},{"name":"Add Multiple stores"},{"name":"Print labels and scedule picks for your orders all within your Consign It Away account!"},{"name":"Add upto 10 staff members in your team for full business managemnet"},{"name":"Your product will be posted under your own ebay Account."},{"name":"Your product will be posted under your own instagram Account"},{"name":"Your product will be posted under your own facebook Account."},{"name":"Your product will be posted under your own consignt it away Account."}]',
                'active_img' =>'activate_2@3x.png',
                'inactive_img' => 'deactivate_2@3x.png',
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
                'features' => '[{"name":"Your product will be posted under Consign It Away Account."},{"name":"You have 24\/7 support on all your products just call our toll free number or you can chat with us on the Chat Box!"},{"name":"All messages answered for you by one of our staff, if question is to complex about your product and you did not give us enough information about your item. You will be asked answer these question."},{"name":"Consign It Away keeps track of every dollar and you have access anytime to look at realtime transactions."},{"name":"We make sure all the governent tax has been paid."},{"name":"Once you take a photo the background of the product will disaper!"},{"name":"Once you enter your products deminstions the best shipping provider will caculate and you can pick the best shipping for the purchaser."},{"name":"We will have schedualed pick up and delivery from your house to the purchaser for you!"},{"name":"scan barcodes"},{"name":"A Storefront to showcase your products and seller profile"},{"name":"Add Multiple stores"},{"name":"Print labels and scedule picks for your orders all within your Consign It Away account!"},{"name":"Add upto 50 staff members in your team for full business managemnet"},{"name":"Your product will be posted under your own amazon Account."},{"name":"Your product will be posted under your own ebay Account."},{"name":"Your product will be posted under your own instagram Account."},{"name":"Your product will be posted under your own facebook Account."},{"name":"Your product will be posted under your own etsy Account."},{"name":"Your product will be posted under your own google Account."},{"name":"Your product will be posted under your own walmart Account."},{"name":"Your product will be posted under your own consignt it away Account."}]',
                'active_img' =>'activate_3@3x.png',
                'inactive_img' => 'deactivate_3@3x.png',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

            [
                'name' => 'Platinum',
                'monthly_price' => '99.99',
                'yearly_price'  => '999.99',
                'status'        => '1',
                'content'       => 'Our most popular package increases your earnings, listing limit, backgrounds removed per listing, and lowers your fees than the Seller package. More info about this package shows you how much you will earn on an item based on its profit. More info',
                'features' => '[
                    {"name":"Your product will be posted under Consign It Away Account."},
                    {"name":"You have 24\/7 support on all your products just call our toll free number or you can chat with us on the Chat Box!"},
                    {"name":"All messages answered for you by one of our staff, if question is to complex about your product and you did not give us enough information about your item. You will be asked answer these question."},
                    {"name":"Consign It Away keeps track of every dollar and you have access anytime to look at realtime transactions."},
                    {"name":"We make sure all the governent tax has been paid."},
                    {"name":"Once you take a photo the background of the product will disaper!"},
                    {"name":"Once you enter your products deminstions the best shipping provider will caculate and you can pick the best shipping for the purchaser."},
                    {"name":"We will have schedualed pick up and delivery from your house to the purchaser for you!"},
                    {"name":"scan barcodes"},
                    {"name":"A Storefront to showcase your products and seller profile"},
                    {"name":"Add Multiple stores"},{"name":"Print labels and scedule picks for your orders all within your Consign It Away account!"},
                    {"name":"Add upto 100 staff members in your team for full business managemnet"},
                    {"name":"Your product will be posted under your own amazon Account."},
                    {"name":"Your product will be posted under your own ebay Account."},
                    {"name":"Your product will be posted under your own instagram Account."},
                    {"name":"Your product will be posted under your own facebook Account."},
                    {"name":"Your product will be posted under your own etsy Account."},
                    {"name":"Your product will be posted under your own google Account."},
                    {"name":"Your product will be posted under your own walmart Account."},
                    {"name":"Your product will be posted under your own consignt it away Account."}
                    ]',
                'active_img' =>'activate_4@3x.png',
                'inactive_img' => 'deactivate_4@3x.png',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

            [
                'name' => 'Premium',
                'monthly_price' => '499.99',
                'yearly_price'  => '4999.99',
                'status'        => '1',
                'content'       => 'Raise earnings, lower fees, and receive more background removals for photos on a listing than the Business package. More info about this package shows you how much you will earn on an item based on its profit',
                'features' => '[{"name":"Your product will be posted under Consign It Away Account."},{"name":"You have 24\/7 support on all your products just call our toll free number or you can chat with us on the Chat Box!"},{"name":"All messages answered for you by one of our staff, if question is to complex about your product and you did not give us enough information about your item. You will be asked answer these question."},{"name":"Consign It Away keeps track of every dollar and you have access anytime to look at realtime transactions."},{"name":"We make sure all the governent tax has been paid."},{"name":"Once you take a photo the background of the product will disaper!"},{"name":"Once you enter your products deminstions the best shipping provider will caculate and you can pick the best shipping for the purchaser."},{"name":"We will have schedualed pick up and delivery from your house to the purchaser for you!"},{"name":"scan barcodes"},{"name":"A Storefront to showcase your products and seller profile"},{"name":"Add Multiple stores"},{"name":"Print labels and scedule picks for your orders all within your Consign It Away account!"},{"name":"Add upto 500 staff members in your team for full business managemnet"},{"name":"Your product will be posted under your own amazon Account."},{"name":"Your product will be posted under your own ebay Account."},{"name":"Your product will be posted under your own instagram Account."},{"name":"Your product will be posted under your own facebook Account."},{"name":"Your product will be posted under your own etsy Account."},{"name":"Your product will be posted under your own google Account."},{"name":"Your product will be posted under your own walmart Account."},{"name":"Your product will be posted under your own consignt it away Account."}]',
                'active_img' =>'activate_5@3x.png',
                'inactive_img' => 'deactivate_5@3x.png',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name' => 'Unlimited',
                'monthly_price' => '999.99',
                'yearly_price'  => '9999.99',
                'content'       => 'Raise earnings, lower fees, and receive more background removals for photos on a listing than the Business package. More info about this package shows you how much you will earn on an item based on its profit',
                'status'        => '1',
                'features' => '[{"name":"Your product will be posted under Consign It Away Account."},{"name":"You have 24\/7 support on all your products just call our toll free number or you can chat with us on the Chat Box!"},{"name":"All messages answered for you by one of our staff, if question is to complex about your product and you did not give us enough information about your item. You will be asked answer these question."},{"name":"Consign It Away keeps track of every dollar and you have access anytime to look at realtime transactions."},{"name":"We make sure all the governent tax has been paid."},{"name":"Once you take a photo the background of the product will disaper!"},{"name":"Once you enter your products deminstions the best shipping provider will caculate and you can pick the best shipping for the purchaser."},{"name":"We will have schedualed pick up and delivery from your house to the purchaser for you!"},{"name":"scan barcodes"},{"name":"A Storefront to showcase your products and seller profile"},{"name":"Add Multiple stores"},{"name":"Print labels and scedule picks for your orders all within your Consign It Away account!"},{"name":"Add Unlimited staff members in your team for full business managemnet"},{"name":"Your product will be posted under your own amazon Account."},{"name":"Your product will be posted under your own ebay Account."},{"name":"Your product will be posted under your own instagram Account."},{"name":"Your product will be posted under your own facebook Account."},{"name":"Your product will be posted under your own etsy Account."},{"name":"Your product will be posted under your own google Account."},{"name":"Your product will be posted under your own walmart Account."},{"name":"Your product will be posted under your own consignt it away Account."}]',
                'active_img'   => 'activate_6@3x.png',
                'inactive_img' => 'deactivate_6@3x.png',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

        ]);
    }
}
