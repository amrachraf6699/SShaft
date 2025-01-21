<?php

namespace App\Http\Middleware;

use Closure;

class CheckDonorActivated
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
        if (auth('donor')->check() && auth('donor')->user()->status === 'inactive')
        {
            auth('donor')->logout();
            session()->flash('sessionError', __('translation.sorry_inactive'));
            return redirect()->route('frontend.home');
        }

        return $next($request);
    }
}
