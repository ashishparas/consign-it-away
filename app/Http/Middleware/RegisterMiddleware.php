<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ApiController;
class RegisterMiddleware extends ApiController
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
            $rules = ['fname' => 'required', 'lname' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required',  'mobile_no' => 'required', 'phonecode' => 'required', 'type' => 'required|in:1,2','marutal_status' =>'required|in:1,2,3'];
            $rules = array_merge($this->requiredParams, $rules);
    
            $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
            if($validateAttributes):
                return $validateAttributes;
            endif;
            
        }elseif($request->type === '2'){
            $rules = ['email' => 'required|email|unique:users', 'password' => 'required', 'type' => 'required|in:1,2'];
            $rules = array_merge($this->requiredParams, $rules);
    
            $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
            if($validateAttributes):
                return $validateAttributes;
            endif;

        }
        return $next($request);
    }
}