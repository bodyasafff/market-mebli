<?php

namespace App\Http\Middleware;

use Closure;

class CheckKey
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->key === config('app.ajax_key')){
            return $next($request);
        }
        return redirect()->route('login');
    }

}