<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.register') }} - Shongjukto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .signup-form { 
            max-width: 500px; 
            margin: 60px auto; 
            padding: 40px; 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); 
            border: 1px solid rgba(255,255,255,0.2);
        }
        .title { 
            font-weight:800; 
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
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
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
        .role-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .role-card:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }
        .role-card.selected {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }
        .role-icon {
            font-size: 24px;
            margin-right: 10px;
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

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute; top: 80px; right: 20px; z-index: 1000;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="signup-form">
    <div class="brand-logo">
        <img src="https://img.icons8.com/color/96/000000/handshake.png" alt="Shongjukto">
        <h2 class="title">{{ __('messages.join_shongjukto') }}</h2>
        <p class="text-muted">{{ __('messages.create_account_start_making_difference') }}</p>
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

    <form action="/signup" method="post">
        @csrf

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-user text-primary"></i> {{ __('messages.full_name') }}
            </label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="form-control @error('name') is-invalid @enderror" 
                       placeholder="{{ __('messages.enter_full_name') }}">
            </div>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-envelope text-primary"></i> {{ __('messages.email_address') }}
            </label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="form-control @error('email') is-invalid @enderror" 
                       placeholder="{{ __('messages.enter_email') }}">
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
                <input type="password" name="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       placeholder="{{ __('messages.create_strong_password') }}">
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-users text-primary"></i> {{ __('messages.i_want_to_join_as') }}
            </label>
            <div class="role-options">
                <div class="role-card {{ old('role') == 'beneficiary' ? 'selected' : '' }}" 
                     onclick="selectRole('beneficiary')">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-hands-helping role-icon text-success"></i>
                        <div>
                            <strong>{{ __('messages.beneficiary') }}</strong>
                            <div class="text-muted small">{{ __('messages.i_need_help_and_support') }}</div>
                        </div>
                    </div>
                </div>
                <div class="role-card {{ old('role') == 'volunteer' ? 'selected' : '' }}" 
                     onclick="selectRole('volunteer')">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-heart role-icon text-danger"></i>
                        <div>
                            <strong>{{ __('messages.volunteer') }}</strong>
                            <div class="text-muted small">{{ __('messages.i_want_to_help_others') }}</div>
                        </div>
                    </div>
                </div>
                <div class="role-card {{ old('role') == 'donor' ? 'selected' : '' }}" 
                     onclick="selectRole('donor')">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-gift role-icon text-primary"></i>
                        <div>
                            <strong>{{ __('messages.donor') }}</strong>
                            <div class="text-muted small">{{ __('messages.i_want_to_donate_items') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <select name="role" id="roleSelect" class="form-select @error('role') is-invalid @enderror" style="display: none;">
                <option value="">-- Select Role --</option>
                <option value="beneficiary" {{ old('role') == 'beneficiary' ? 'selected' : '' }}>Beneficiary</option>
                <option value="volunteer" {{ old('role') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                <option value="donor" {{ old('role') == 'donor' ? 'selected' : '' }}>Donor</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary btn-custom" style="padding: 14px; font-size: 1.1rem;">
                <i class="fas fa-user-plus"></i> {{ __('messages.create_account') }}
            </button>
        </div>
    </form>

    <div class="text-center">
        <p class="text-muted mb-0">
            {{ __('messages.already_have_account') }} 
            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                <i class="fas fa-sign-in-alt"></i> {{ __('messages.sign_in_here') }}
            </a>
        </p>
    </div>
</div>

<script>
function selectRole(role) {
    // Remove selected class from all cards
    document.querySelectorAll('.role-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    event.currentTarget.classList.add('selected');
    
    // Update the hidden select
    document.getElementById('roleSelect').value = role;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
