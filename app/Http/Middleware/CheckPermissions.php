<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|boolean  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = false)
    {
        if($user = Auth::user()){
            if($user->profile){
                $rolesCount = count($user->roles());
                if(!$rolesCount){
                    return response()->json([
                        'status' => false,
                        'message' => 'User must have at least a profile'
                    ]);
                }

                if($role && !$user->hasRole($role)){
                    return response()->json([
                        'status' => false,
                        'message' => "User can't access this resource"
                    ]);
                }
            }
        }

        return $next($request);
    }
}
