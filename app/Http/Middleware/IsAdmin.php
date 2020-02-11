<?php

namespace App\Http\Middleware;

use App\Models\Datasets\UserRole;
use App\Models\User;
use Closure;

class IsAdmin
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(User::hasRole(UserRole::ADMIN)){
            return $next($request);
        }

        return redirect()->route('login');
    }

}