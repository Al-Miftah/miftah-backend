<?php

namespace App\Http\Middleware;

use Closure;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class Admin
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
        return $next($request);
    }
}
