<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        // Log the request for debugging
        Log::info('Language switch requested', ['locale' => $locale, 'url' => $request->url()]);
        
        // Validate locale
        if (!in_array($locale, ['en', 'bn'])) {
            $locale = 'en';
            Log::warning('Invalid locale provided, defaulting to English', ['provided_locale' => $locale]);
        }
        
        Session::put('locale', $locale);
        App::setLocale($locale);
        
        Log::info('Language switched successfully', ['new_locale' => $locale, 'session_locale' => Session::get('locale')]);
        
        return redirect()->back()->with('success', "Language switched to " . ($locale === 'bn' ? 'Bengali' : 'English'));
    }
    
    public function test()
    {
        return response()->json([
            'current_locale' => App::getLocale(),
            'session_locale' => Session::get('locale'),
            'available_locales' => ['en', 'bn'],
            'test_message_en' => __('messages.welcome'),
            'test_message_bn' => App::setLocale('bn') ? __('messages.welcome') : 'Error'
        ]);
    }
}
