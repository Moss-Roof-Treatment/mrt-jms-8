<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class IsTradesperson
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
        // CHECK USER ACCOUNT ROLE
        // Check if role id is tradesperson.
        if (Auth::user()->account_role_id == 3) {
            // User account role is tradesperson.
            // Continue to the next request.
            return $next($request);
        } else {
            // User account role is not tradesperson.
            // Return redirect to the profile index.
            return redirect()
                ->route('profile.index')
                ->with('warning', 'You do not have the required permission to perform that action.');
        }
    }
}
