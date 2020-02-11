<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::check()){
            app()->setLocale(\Auth::user()->language_id);
        }
        return $next($request);
    }

}