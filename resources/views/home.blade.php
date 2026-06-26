<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shongjukto – Connect • Help • Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero { padding: 80px 0; }
        .hero-card { 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); 
            padding: 40px 32px; 
            border: 1px solid rgba(255,255,255,0.2);
        }
        .brand-title { 
            font-family: 'Segoe UI',sans-serif; 
            font-size: 2.6rem; 
            font-weight: 800; 
            color: #1b4332; 
        }
        .subtitle { font-size: 1.15rem; color: #495057; }
        .btn-pill { 
            border-radius: 12px; 
            padding: 12px 24px; 
            font-weight: 600; 
            transition: all 0.3s ease;
        }
        .btn-pill:hover {
            transform: translateY(-2px);
        }
        .feature-card { 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem; 
            box-shadow: 0 12px 40px rgba(0,0,0,0.12); 
            padding: 30px; 
            height: 100%; 
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        .feature-icon { width: 48px; height: 48px; }
        .section-title { font-weight: 800; color:#1b4332; }
        .gallery img { 
            border-radius: 14px; 
            box-shadow: 0 12px 40px rgba(0,0,0,0.15); 
            transition: all 0.3s ease;
        }
        .gallery img:hover {
            transform: scale(1.05);
        }
        .footer { color:#6c757d; font-size:.95rem; }
        .dashboard-section { padding: 60px 0; }
        .dashboard-card { 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); 
            padding: 40px; 
            margin-bottom: 24px; 
            border: 1px solid rgba(255,255,255,0.2);
        }
        .stat-card { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            color: white; 
            border-radius: 1rem; 
            padding: 30px; 
            text-align: center; 
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 45px rgba(0,0,0,0.2);
        }
        .stat-number { font-size: 2.5rem; font-weight: 800; margin-bottom: 8px; }
        .stat-label { font-size: 1rem; opacity: 0.9; }
        .quick-action { 
            background: rgba(248,249,250,0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem; 
            padding: 25px; 
            text-align: center; 
            transition: all 0.3s ease; 
            border: 1px solid rgba(255,255,255,0.3);
        }
        .quick-action:hover { 
            transform: translateY(-5px); 
            background: rgba(233,236,239,1);
            box-shadow: 0 15px 45px rgba(0,0,0,0.15);
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
        .action-icon { width: 45px; height: 45px; margin-bottom: 15px; }
        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.1) !important;
        }
        .navbar-brand {
            font-weight: 800;
            color: #1b4332 !important;
        }
    </style>
</head>
<body>

    
    <nav class="navbar navbar-expand-lg bg-transparent pt-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#" style="font-weight:800; color:#1b4332;">
                <img src="https://img.icons8.com/color/96/000000/handshake.png" alt="logo" style="width:36px;height:36px;"> Shongjukto
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="d-flex gap-2 align-items-center">
                    @if(session('user_id'))
                        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-pill">{{ __('messages.profile') }}</a>
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-pill">{{ __('messages.logout') }}</a>
                    @else
                        <a href="{{ route('map.view') }}" class="btn btn-outline-secondary btn-pill">Live Map</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-pill">{{ __('messages.login') }}</a>
                        <a href="{{ route('signup') }}" class="btn btn-success btn-pill">{{ __('messages.register') }}</a>
                    @endif
                    
                    @include('components.language-switcher')
                </div>
            </div>
        </div>
    </nav>

    @if(session('user_id'))
        @php
            $user = \App\Models\User::find(session('user_id'));
            $role = $user->role;
        @endphp
        
        <section class="dashboard-section">
            <div class="container">
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
                
                <div class="dashboard-card">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-8">
                            <h2 class="section-title mb-2">{{ __('messages.welcome_back') }}, {{ $user->name }}!</h2>
                            <p class="text-muted mb-0">{{ __('messages.here_is_your') }} {{ __('messages.' . $role) }} {{ __('messages.dashboard_with_quick_access') }}</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <span class="badge bg-primary fs-6 px-3 py-2" style="border-radius: 12px;">{{ ucfirst($role) }}</span>
                        </div>
                    </div>

                    @if($role === 'donor')
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="stat-number">{{ \App\Models\Donation::where('donor_id', session('user_id'))->count() }}</div>
                                    <div class="stat-label">{{ __('messages.total_donations') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <div class="stat-number">{{ \App\Models\Donation::where('donor_id', session('user_id'))->where('status', 'accepted')->count() }}</div>
                                    <div class="stat-label">{{ __('messages.accepted') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <div class="stat-number">{{ \App\Models\Donation::where('donor_id', session('user_id'))->where('status', 'pending')->count() }}</div>
                                    <div class="stat-label">{{ __('messages.pending') }}</div>
                                </div>
                            </div>
                        </div>
                    @elseif($role === 'volunteer')
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="stat-number">{{ \App\Models\Donation::where('volunteer_id', session('user_id'))->count() }}</div>
                                    <div class="stat-label">{{ __('messages.accepted_donations') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <div class="stat-number">{{ \App\Models\HelpRequest::where('status', 'accepted')->count() }}</div>
                                    <div class="stat-label">{{ __('messages.help_requests') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <div class="stat-number">{{ \App\Models\HelpRequest::where('status', 'pending')->count() }}</div>
                                    <div class="stat-label">{{ __('messages.pending_requests') }}</div>
                                </div>
                            </div>
                        </div>
                    @elseif($role === 'beneficiary')
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="stat-number">{{ \App\Models\HelpRequest::where('user_id', session('user_id'))->count() }}</div>
                                    <div class="stat-label">{{ __('messages.help_requests') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <div class="stat-number">{{ \App\Models\HelpRequest::where('user_id', session('user_id'))->where('status', 'accepted')->count() }}</div>
                                    <div class="stat-label">{{ __('messages.accepted') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                    <div class="stat-number">{{ \App\Models\HelpRequest::where('user_id', session('user_id'))->where('status', 'pending')->count() }}</div>
                                    <div class="stat-label">{{ __('messages.pending') }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h5 class="mb-3">{{ __('messages.quick_actions') }}</h5>
                    <div class="row g-3">
                        @if($role === 'donor')
                            <div class="col-md-3">
                                <a href="{{ route('donations.create') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/plus-math.png" class="action-icon" alt="Create">
                                        <h6>{{ __('messages.schedule_donation') }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('donations.my') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/list.png" class="action-icon" alt="My Donations">
                                        <h6>{{ __('messages.my_donations') }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('sponsorships.create') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/graduation-cap.png" class="action-icon" alt="Sponsorship">
                                        <h6>{{ __('messages.sponsorship') }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('sponsorships.my') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/list.png" class="action-icon" alt="My Sponsorships">
                                        <h6>{{ __('messages.my_sponsorships') }}</h6>
                                    </div>
                                </a>
                            </div>
                        @elseif($role === 'volunteer')
                            <div class="col-md-3">
                                <a href="{{ route('volunteer.donations') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/package.png" class="action-icon" alt="Donations">
                                        <h6>{{ __('messages.available_donations') }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('volunteer.requests') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/helping-hand.png" class="action-icon" alt="Requests">
                                        <h6>{{ __('messages.help_requests') }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('volunteer.appointments') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/calendar.png" class="action-icon" alt="Appointments">
                                        <h6>{{ __('messages.appointments') }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('map.view') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/marker.png" class="action-icon" alt="Map">
                                        <h6>{{ __('messages.live_map') }}</h6>
                                    </div>
                                </a>
                            </div>
                        @elseif($role === 'beneficiary')
                            <div class="col-md-3">
                                <a href="{{ route('request.help') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/helping-hand.png" class="action-icon" alt="Request Help">
                                        <h6>Request Help</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('my.requests') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/list.png" class="action-icon" alt="My Requests">
                                        <h6>My Requests</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('appointments.create') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/calendar-plus.png" class="action-icon" alt="Book Appointment">
                                        <h6>Book Appointment</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('appointments.my') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/list.png" class="action-icon" alt="My Appointments">
                                        <h6>My Appointments</h6>
                                    </div>
                                </a>
                            </div>
                        @elseif($role === 'admin')
                            <div class="col-md-3">
                                <a href="{{ route('admin.users') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/users.png" class="action-icon" alt="Users">
                                        <h6>Manage Users</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.clinics') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/hospital.png" class="action-icon" alt="Clinics">
                                        <h6>Manage Clinics</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.students') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/graduation-cap.png" class="action-icon" alt="Students">
                                        <h6>Manage Students</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.appointments') }}" class="text-decoration-none">
                                    <div class="quick-action">
                                        <img src="https://img.icons8.com/fluency/48/calendar.png" class="action-icon" alt="Appointments">
                                        <h6>View Appointments</h6>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <div class="hero-card">
                        <div class="brand-title mb-2">{{ __('messages.connecting_people') }}</div>
                        <p class="subtitle mb-4">{{ __('messages.shongjukto_description') }}</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('signup') }}" class="btn btn-success btn-pill">{{ __('messages.get_started') }}</a>
                            <a href="{{ route('map.view') }}" class="btn btn-outline-secondary btn-pill">{{ __('messages.explore_map') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img class="img-fluid" alt="Community Support" src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?q=80&w=1600&auto=format&fit=crop">
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <h3 class="section-title mb-4">{{ __('messages.how_it_works') }}</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <img class="feature-icon mb-3" src="https://img.icons8.com/fluency/48/marker.png" alt="map">
                        <h5>{{ __('messages.see_needs_realtime') }}</h5>
                        <p class="mb-0">{{ __('messages.see_needs_description') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <img class="feature-icon mb-3" src="https://img.icons8.com/fluency/48/helping-hand.png" alt="donate">
                        <h5>{{ __('messages.donate_or_volunteer') }}</h5>
                        <p class="mb-0">{{ __('messages.donate_volunteer_description') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100">
                        <img class="feature-icon mb-3" src="https://img.icons8.com/fluency/48/statistics.png" alt="impact">
                        <h5>{{ __('messages.track_impact') }}</h5>
                        <p class="mb-0">{{ __('messages.track_impact_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <h3 class="section-title mb-4">{{ __('messages.in_pictures') }}</h3>
            <div class="row g-3 gallery">
                <div class="col-md-4"><img class="img-fluid" alt="Community Support" src="https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=1600&auto=format&fit=crop"></div>
                <div class="col-md-4"><img class="img-fluid" alt="Volunteer Work" src="https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?q=80&w=1600&auto=format&fit=crop"></div>
                <div class="col-md-4"><img class="img-fluid" alt="Education Support" src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=1600&auto=format&fit=crop"></div>
            </div>
        </div>
    </section>

    <footer class="py-4">
        <div class="container text-center footer">
            © {{ date('Y') }} Shongjukto • <a href="{{ route('login') }}">Login</a> • <a href="{{ route('signup') }}">Sign up</a>
        </div>
    </footer>
    
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