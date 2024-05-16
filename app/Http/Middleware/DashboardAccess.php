<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(isset(Auth::user()->role_id)){
            $role_id = Auth::user()->role_id;
            if($role_id !=1){
                return redirect()->route('logout');
               }
                return $next($request);
        }else{
            return redirect()->route('logout');
        }
       
       
    }
}
