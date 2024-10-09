<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventDirectLoginAccess
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
        // Ambil nilai referer dari header
        $referer = $request->headers->get('referer');
        
        // Cek apakah referer valid (berasal dari domain yang sama)
        if (!$referer || !str_contains($referer, $request->getHost())) {
            // Jika referer tidak valid, redirect ke halaman / dengan query parameter ?login=true
            return redirect('/?login=true');
        }

        // Jika referer valid, lanjutkan request ke /login
        return $next($request);
    }
}
