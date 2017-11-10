<?php

namespace Askaoru\Routable\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class RoutableLocalize
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (defined('ROUTABLE_LOCALE')) {
            App::setLocale(ROUTABLE_LOCALE);
        }

        return $next($request);
    }
}
