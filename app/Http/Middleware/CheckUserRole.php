<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($request->header('Accept') === 'application/json') {
            return $next($request);
        } else {
            if ($user->roles->isEmpty()) {
                return redirect()->route('choose.role'); // Replace 'no-role' with your desired route name
            }
        }
        return $next($request);
    }
}
