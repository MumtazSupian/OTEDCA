<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDirectAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil data referer (halaman asal user sebelum masuk ke URL ini)
        $referer = $request->header('referer');
        // Jika referer kosong (artinya user ngetik manual di URL bar atau copas link di tab baru)
        // Dan route yang dituju saat ini BUKAN dashboard (biar gak error looping)
         if (empty($referer) && 
            !in_array($request->route()?->getName(), ['dashboard', 'dashboard.v1', 'dashboard.v2', 'sales.leads.dashboard']) &&
            !$request->is('sales/leads/*')
        ) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}