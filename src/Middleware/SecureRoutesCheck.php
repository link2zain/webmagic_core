<?php


namespace Webmagic\Core\Middleware;

use \Closure;

class SecureRoutesCheck
{
    /**
     * Redirect on secure route if it is on production
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (app()->environment() == 'production' && !request()->secure()) {
            return redirect()->secure(request()->path(), 301);
        }

        return $next($request);
    }
}