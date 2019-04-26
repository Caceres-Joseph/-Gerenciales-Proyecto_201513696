<?php

namespace App\Http\Middleware;

use Closure;

class session_middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('my_name')){
            return $next($request);
        }
        return redirect('login')->with('error','You have not admin access');
    }
}
