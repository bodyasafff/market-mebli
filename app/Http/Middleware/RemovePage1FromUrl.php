<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class RemovePage1FromUrl
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Str::endsWith(request()->fullUrl(), '?page=1')){
            return redirect()->to(str_replace('?page=1', '', request()->fullUrl()));
        }
        return $next($request);
    }

}