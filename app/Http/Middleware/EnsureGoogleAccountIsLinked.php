<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureGoogleAccountIsLinked
{
    public function handle(Request $request, Closure $next)
    {
        // If user is authenticated but hasn't linked their Google account...
        if (Auth::check() && ! Auth::user()->google_linked_at) {
            // ...and they are not already on the page that tells them to link...
            if (! $request->routeIs('google.link.notice')) {
                // ...redirect them to that page.
                return redirect()->route('google.link.notice');
            }
        }

        return $next($request);
    }
}
