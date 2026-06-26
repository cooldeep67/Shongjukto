<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.login') }} - Shongjukto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-form { 
            max-width: 450px; 
            margin: 80px auto; 
            padding: 40px; 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); 
            border: 1px solid rgba(255,255,255,0.2);
        }
        .title { 
            font-weight: 800; 
            color:#1b4332; 
            margin-bottom: 30px;
        }
        .btn-custom {
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
        }
        .topbar { 
            position: absolute; 
            top: 20px; 
            right: 20px; 
            display:flex; 
            gap:10px; 
        }
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        .brand-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .brand-logo img {
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
        }
        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 12px 0 0 12px;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }
        .input-group:focus-within .input-group-text {
            border-color: #667eea;
        }
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        /* Alert positioning and styling */
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
            border-radius: 8px;
            animation: slideInRight 0.3s ease-out;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .alert ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Responsive alert positioning */
        @media (max-width: 768px) {
            .alert {
                top: 10px;
                right: 10px;
                left: 10px;
                min-width: auto;
                max-width: none;
            }
        }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-custom">
        <i class="fas fa-home"></i> {{ __('messages.home') }}
    </a>
    @if(session('user_id'))
        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-custom">
            <i class="fas fa-user"></i> {{ __('messages.profile') }}
        </a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-custom">
            <i class="fas fa-sign-out-alt"></i> {{ __('messages.logout') }}
        </a>
    @endif
    
    @include('components.language-switcher')
</div>

@php
    $successMessage = session('success');
@endphp
@if($successMessage)
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" data-message="{{ $successMessage }}">
        <i class="fas fa-check-circle me-2"></i>
        {{ $successMessage }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="login-form">
    <div class="brand-logo">
        <img src="https://img.icons8.com/color/96/000000/handshake.png" alt="Shongjukto">
        <h2 class="title">{{ __('messages.welcome_back') }}</h2>
        <p class="text-muted">{{ __('messages.sign_in_account') }}</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ __('messages.fix_errors') }}
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="/login" method="post">
        @csrf

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-envelope text-primary"></i> {{ __('messages.email_address') }}
            </label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email') }}" placeholder="{{ __('messages.enter_email') }}">
            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-lock text-primary"></i> {{ __('messages.password') }}
            </label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="{{ __('messages.enter_password') }}">
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary btn-custom" style="padding: 14px; font-size: 1.1rem;">
                <i class="fas fa-sign-in-alt"></i> {{ __('messages.sign_in') }}
            </button>
        </div>
    </form>

    <div class="text-center">
        <p class="text-muted mb-0">
            {{ __('messages.dont_have_account') }} 
            <a href="{{ route('signup') }}" class="text-decoration-none fw-bold">
                <i class="fas fa-user-plus"></i> {{ __('messages.sign_up_now') }}
            </a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Prevent duplicate alerts and auto-dismiss functionality
document.addEventListener('DOMContentLoaded', function() {
    // Remove any duplicate success alerts (keep only the first one)
    const successAlerts = document.querySelectorAll('.alert-success');
    if (successAlerts.length > 1) {
        // Keep only the first success alert, remove the rest
        for (let i = 1; i < successAlerts.length; i++) {
            successAlerts[i].remove();
        }
    }
    
    // Remove any duplicate error alerts (keep only the first one)
    const errorAlerts = document.querySelectorAll('.alert-danger');
    if (errorAlerts.length > 1) {
        // Keep only the first error alert, remove the rest
        for (let i = 1; i < errorAlerts.length; i++) {
            errorAlerts[i].remove();
        }
    }
    
    // Auto-dismiss remaining alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            if (alert && alert.parentNode) {
                alert.classList.remove('show');
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }
        }, 5000);
    });
    
    // Add click to dismiss functionality
    document.querySelectorAll('.alert').forEach(alert => {
        alert.addEventListener('click', function() {
            this.classList.remove('show');
            setTimeout(() => {
                if (this && this.parentNode) {
                    this.remove();
                }
            }, 300);
        });
    });
});
</script>
</body>
</html>
