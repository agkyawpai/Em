<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

/**
 * Middleware class to set language
 * @author AungKyawPaing
 * create 05/06/2023
*/
class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
    */
    public function handle($request, Closure $next)
    {
        $locale = session('locale', 'en');
        App::setLocale($locale);

        return $next($request);
    }
}
