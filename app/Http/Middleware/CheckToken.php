<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckToken
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('Authorization') == 'Bearer df34fdsas38n3kd'){
            return $next($request);
        }
        return abort(Response::HTTP_FORBIDDEN);
    }

}