<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class RecentProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RecentProducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to check recent products and delete the all recent product after 30-days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $RecentProducts = \App\Models\RecentProducts::get();
        foreach($RecentProducts as $RecentProduct):
     
            // $date = Carbon::parse($RecentProduct['updated_at']);
            // $now = Carbon::now();
            // $diff = $date->diffInDays($now);
            $realTime = Carbon::now();
            $diff = $realTime->diffInDays($RecentProduct['updated_at']);
            if($diff == 30):
                \App\Models\RecentProducts::where('updated_at', $RecentProduct['updated_at'])->delete();
            endif;
            
 endforeach;
    }
}
