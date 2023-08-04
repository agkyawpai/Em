<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Middleware class to  set admin
 * @author AungKyawPaing
 * create 27/06/2023
*/
class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
    */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('adminId')) {
            return $next($request);
        }
        Session::flash('error', 'You are not authorized to access this page.');
        return redirect()->back();
    }
}
