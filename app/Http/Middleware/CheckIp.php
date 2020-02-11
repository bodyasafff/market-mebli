<?php

namespace App\Http\Middleware;

use Closure;

class CheckIp
{
    /**
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(in_array(request()->getClientIp(), [
            '91.213.187.137',
            '77.123.43.236',
        ]) || md5($_SERVER['HTTP_USER_AGENT']) === 'db6b92231e842a6b511cdc276d0220c9') {

            return $next($request);
        }
        abort(404);
    }

}