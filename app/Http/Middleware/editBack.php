<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class editBack
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl = $request->fullUrl();
        $refererUrl = $request->headers->get('referer');

        // Check if the current URL is an edit page and the user is authenticated
        if ($request->is('demande-de-stage/*/edit') && Auth::check()) {
            // Check if the referer header is present and is different from the current URL
            if ($refererUrl && $refererUrl !== $currentUrl) {
                Auth::logout();
                return redirect()->route('login');
            }
        }
        return $next($request);
    }
}
