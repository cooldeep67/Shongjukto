<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect('/login')->withErrors(['message' => __('messages.please_login')]);
        }

        $user = User::find(session('user_id'));
        
        if (!$user || $user->role !== 'admin') {
            return redirect('/')->withErrors(['message' => __('messages.access_denied')]);
        }

        return $next($request);
    }
}
