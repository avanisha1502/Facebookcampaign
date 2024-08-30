<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       // Check if user is authenticated
        if (Auth::check()) {
            $lastActivity = Session::get('last_activity');
            // Check if last activity time is set
            if ($lastActivity && now()->diffInMinutes($lastActivity) >= 60) {
                // Logout user
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with('message', 'You have been logged out due to inactivity.');
            }

            // Update last activity time
            Session::put('last_activity', now());

          
        } 
        return $next($request);
    //    return redirect()->route('login');
    }
}
