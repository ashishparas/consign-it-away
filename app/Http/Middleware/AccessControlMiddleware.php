<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessControlMiddleware
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
        if(Auth::check() || Auth::user()->status){
            // dd(Auth::user()->type);
               if(Auth::user()->type === '4'){
                return $next($request);
               }else{
                  
                   return abort(403);
               }
        }else{
            return response()->json(['status'=>'Please login first']);
        }
        return $next($request);
    }
}
