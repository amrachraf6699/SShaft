<?php

namespace App\Http\Middleware;

use Closure;

class SwitchLanguage
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

        if ($language = session()->get('language')) {
            app()->setLocale($language);
        }

        return $next($request);
    }
}
