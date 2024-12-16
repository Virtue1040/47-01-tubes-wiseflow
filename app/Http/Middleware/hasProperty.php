<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Property;

class hasProperty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $property = Property::where('id_property', $request->id)->first();
        if ($property == null) { return redirect()->route('property'); }
        if ($property->id_user_owner !== $user->id_user) {
            session()->flash('alert', [
                'type' => 'error',
                'message' => 'You dont own this property!',
            ]);
            return redirect()->route('property'); 
        }
        if (session('alert'))
        {
            if (session('alert')['message'] === 'You dont own this property!') {
                session()->flash('alert', null);
            }
        }
        return $next($request);
    }
}
