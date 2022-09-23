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

            if($request->social_id === ''):
                $rules = ['fname' => 'required', 'lname' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required',  'mobile_no' => 'required|exists:users,mobile_no', 'phonecode' => 'required', 'type' => 'required|in:1,2','marital_status' =>'required|in:1,2,3','social_id'=>'','social_type'=> ''];
            else:

                $rules = ['fname' => 'required', 'lname' => 'required', 'email' => 'required|email|unique:users', 'password' => '',  'mobile_no' => 'required|exists:users,mobile_no', 'phonecode' => 'required', 'type' => 'required|in:1,2','marital_status' =>'required|in:1,2,3','social_id'=>'','social_type'=> ''];
            endif;
            
            $rules = array_merge($this->requiredParams, $rules);
    
            $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
            if($validateAttributes):
                return $validateAttributes;
            endif;
            
        }elseif($request->type === '2'){
            $rules = ['email' => 'required|email|unique:users', 'password' => 'required', 'type' => 'required|in:1,2','social_id'=>'','social_type'=> ''];
            $rules = array_merge($this->requiredParams, $rules);
    
            $validateAttributes = parent::validateAttributes($request,'POST', $rules, array_keys($rules), false);
            if($validateAttributes):
                return $validateAttributes;
            endif;

        }
        return $next($request);
    }
}
