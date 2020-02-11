<?php

namespace App\Http\Middleware;

use Closure;

class RemovePublicFromUrl
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(strpos(request()->fullUrl(), request()->getHost().'/public') !== false){
            return redirect()->to(str_replace(request()->getHost().'/public', request()->getHost(), request()->fullUrl()));
        }
        return $next($request);
    }

}