<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Language Test - Shongjukto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Language Test Page</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Current Language Status
                    </div>
                    <div class="card-body">
                        <p><strong>Current Locale:</strong> {{ app()->getLocale() }}</p>
                        <p><strong>Session Locale:</strong> {{ session('locale', 'Not set') }}</p>
                        <p><strong>Welcome Message:</strong> {{ __('messages.welcome') }}</p>
                        <p><strong>Language:</strong> {{ __('messages.language') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Language Switching
                    </div>
                    <div class="card-body">
                        <p>Click the links below to test language switching:</p>
                        <a href="{{ route('language.switch', ['locale' => 'en']) }}" class="btn btn-primary mb-2">Switch to English</a>
                        <br>
                        <a href="{{ route('language.switch', ['locale' => 'bn']) }}" class="btn btn-success mb-2">Switch to Bengali</a>
                        <br>
                        <a href="{{ route('language.test') }}" class="btn btn-info" target="_blank">Test API</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Language Switcher Component
                    </div>
                    <div class="card-body">
                        @include('components.language-switcher')
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Debug Information
                    </div>
                    <div class="card-body">
                        <p><strong>Route URLs:</strong></p>
                        <ul>
                            <li>English: {{ route('language.switch', ['locale' => 'en']) }}</li>
                            <li>Bengali: {{ route('language.switch', ['locale' => 'bn']) }}</li>
                        </ul>
                        <p><strong>Current URL:</strong> {{ request()->url() }}</p>
                        <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
