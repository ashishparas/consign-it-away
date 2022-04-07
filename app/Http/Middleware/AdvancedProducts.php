<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\ApiController;
use Closure;
use Illuminate\Http\Request;

class AdvancedProducts extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       
        if($request->type === '1'){
            $rules = ['name'=> 'required','image'=>'required','category_id' =>'required',
            'description' => 'required', 'price' => 'required', 'discount' => '',
            'brand' => 'required', 'color' =>'required', 'quantity' => 'required',
            'weight' =>'required', 'condition'=>'required', 'dimensions' =>'required',
            'available_for_sale' => 'required|in:1,2','constomer_contact'=> 'required|in:1,2',
            'inventory_track' => 'required|in:1,2','product_offer' => '','ships_from'=>'required', 'shipping_type' => 'required','free_shipping' => 'required|in:1,2', 'meta_description' => '',
            'meta_tags' => '', 'meta_keywords' => '', 'title' => 'required', 'variants' => '',
            'state'=> '','tags' =>'','advertisement' =>'', 'selling_fee' =>'required', 
            'amount' => 'required'
];
        }elseif($request->type === '2'){
           
            $rules = ['name'=> 'required','image'=>'required','category_id' =>'required',
                'description' => 'required', 'price' => 'required', 'discount' => '',
                'brand' => 'required', 'color' =>'required', 'quantity' => 'required',
                'weight' =>'required', 'condition'=>'required', 'dimensions' =>'required',
                'available_for_sale' => 'required|in:1,2','constomer_contact'=> 'required|in:1,2',
                'inventory_track' => 'required|in:1,2','product_offer' => '','ships_from'=>'required', 'shipping_type' => 'required', 'meta_description' => '',
                'meta_tags' => '', 'meta_keywords' => '', 'title' => 'required', 'variants' => 'required',
                'state'=> '','tags' =>'','advertisement' =>'', 'selling_fee' =>'required', 
                'amount' => 'required'
    ];
        }

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;
        return $next($request);
    }
}
