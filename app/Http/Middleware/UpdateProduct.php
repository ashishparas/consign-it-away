<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\ApiController;
use Closure;
use Illuminate\Http\Request;

class UpdateProduct extends ApiController
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
            $rules = ['product_id'=>'required|exists:products,id','name'=> 'required','image'=>'','category_id' =>'required',
            'subcategory_id' => 'required|exists:subcategories,id',
            'description' => 'required', 'price' => 'required', 'discount' => '',
            'brand' => 'required', 'color' =>'required', 'quantity' => 'required',
            'weight' =>'required', 'condition'=>'required', 'dimensions' =>'',
            'available_for_sale' => 'required|in:1,2','constomer_contact'=> 'required|in:1,2',
            'inventory_track' => 'required|in:1,2','product_offer' => '','ships_from'=>'required', 'shipping_type' => 'required','free_shipping' => 'required|in:1,2', 'meta_description' => '',
            'meta_tags' => '', 'meta_keywords' => '', 'title' => '', 'variants' => '',
            'state'=> '','tags' =>'','advertisement' =>'', 'selling_fee' =>'required', 
            'amount' => 'required','type'=>'required|in:1,2','store_id' =>'required|exists:stores,id'
];
        }elseif($request->type === '2'){
           
            $rules = [
                'product_id'=>'required|exists:products,id',
                'name'=> 'required',
                'image'=>'',
                'category_id' =>'required',
                'subcategory_id' => 'required|exists:subcategories,id',
                'description' => 'required',
                'price' => 'required',
                'discount' => '',
                'brand' => 'required',
                'color' =>'required', 
                'quantity' => 'required',
                'weight' =>'required', 
                'condition'=>'required', 
                'dimensions' =>'',
                'available_for_sale' => 'required|in:1,2',
                'constomer_contact'=> 'required|in:1,2',
                'inventory_track' => 'required|in:1,2',
                'product_offer' => '',
                'ships_from'=>'required', 
                'shipping_type' => 'required', 
                'meta_description' => '',
                'meta_tags' => '', 
                'meta_keywords' => '', 
                'title' => '', 
                'variants' => 'required',
                'state'=> '',
                'tags' =>'',
                'advertisement' =>'', 
                'selling_fee' =>'required', 
                'amount' => 'required',
                'type'=>'required|in:1,2',
                'store_id' =>'required|exists:stores,id'];
        }

        $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
        if($validateAttributes):
            return $validateAttributes;
        endif;

        return $next($request);
    }
}
