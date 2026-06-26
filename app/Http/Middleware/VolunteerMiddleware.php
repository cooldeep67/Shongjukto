<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class VolunteerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect('/login')->withErrors(['message' => 'Please log in first.']);
        }

        $user = User::find(session('user_id'));
        
        if (!$user || $user->role !== 'volunteer') {
            return redirect('/')->withErrors(['message' => 'Access denied. Volunteers only.']);
        }

        return $next($request);
    }
}
