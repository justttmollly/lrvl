<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class Adldap
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     */

    public function handle(Request $request, Closure $next)
    {

        return $next($request);
    }
}
