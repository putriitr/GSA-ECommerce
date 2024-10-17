<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Parameter;

class ShareParameter
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
        // Fetch the parameter data from the database
        $parameter = Parameter::first();

        // Share the parameter data with all views
        view()->share('parameter', $parameter);

        return $next($request);
    }
}
