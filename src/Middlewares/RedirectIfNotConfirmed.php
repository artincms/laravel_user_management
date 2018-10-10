<?php

namespace ArtinCMS\LUM\Middlewares;

use Closure;

class RedirectIfNotConfirmed
{
    public function handle($request, Closure $next, $guard = null)
    {
        dd(1);
        if (auth()->check())
        {
            if (config('laravel_user_management.the_email_must_be_checked'))
            {
                if (auth()->user()->email_confirmed == '0')
                {
                    return abort(403);
                }
                else
                {
                    return $next($request);
                }
            }
            return $next($request);
        }
        else
        {
            return abort(403);
        }
    }
}
