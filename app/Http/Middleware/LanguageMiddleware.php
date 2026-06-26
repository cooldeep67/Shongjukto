<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user has selected a language
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            // Set default language to English
            Session::put('locale', 'en');
            App::setLocale('en');
        }

        return $next($request);
    }
}
