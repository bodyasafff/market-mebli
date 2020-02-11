<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CheckUserRoles
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = [])
    {
        $allowedRoles = array_slice(func_get_args(), 2);
        foreach ($allowedRoles as $role){
            if(User::hasRole($role)){
                return $next($request);
            }
        }
        return redirect()->route('login');
    }

}