<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Schedule Donation - Shongjukto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .schedule-form { 
            max-width: 600px; 
            margin: 60px auto; 
            padding: 40px; 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); 
            position: relative;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .topbar { 
            position: absolute; 
            top: 20px; 
            right: 20px; 
            display:flex; 
            gap:10px; 
        }
        .btn-custom {
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
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
        .page-title {
            color: #1b4332;
            font-weight: 800;
            margin-bottom: 30px;
            text-align: center;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .step {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #28a745;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        .step-text {
            font-weight: 600;
            color: #495057;
        }
        .step-line {
            width: 60px;
            height: 2px;
            background: #dee2e6;
            margin: 0 10px;
        }
        .step.active .step-number {
            background: #667eea;
        }
        .step.active .step-text {
            color: #667eea;
        }
        .donation-summary {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .summary-label {
            font-weight: 600;
            color: #495057;
        }
        .summary-value {
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-custom">
        <i class="fas fa-home"></i> Home
    </a>
    <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-custom">
        <i class="fas fa-user"></i> Profile
    </a>
    <a href="{{ route('logout') }}" class="btn btn-danger btn-custom">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<div class="schedule-form">
    <div class="step-indicator">
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-text">Item Details</div>
        </div>
        <div class="step-line"></div>
        <div class="step active">
            <div class="step-number">2</div>
            <div class="step-text">Schedule</div>
        </div>
    </div>

    <h3 class="page-title">
        <i class="fas fa-calendar-alt text-primary"></i> Schedule Pickup
    </h3>

    <div class="donation-summary">
        <h6 class="mb-3 fw-bold">
            <i class="fas fa-clipboard-list text-primary"></i> Donation Summary
        </h6>
        <div class="summary-item">
            <span class="summary-label">Item:</span>
            <span class="summary-value">{{ session('donation_item') }}</span>
        </div>
        @if(session('donation_quantity'))
        <div class="summary-item">
            <span class="summary-label">Quantity:</span>
            <span class="summary-value">{{ session('donation_quantity') }}</span>
        </div>
        @endif
        @if(session('donation_description'))
        <div class="summary-item">
            <span class="summary-label">Description:</span>
            <span class="summary-value">{{ session('donation_description') }}</span>
        </div>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('donations.storeSchedule') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-calendar text-primary"></i> Pickup Date
                </label>
                <input type="date" name="scheduled_date" class="form-control @error('scheduled_date') is-invalid @enderror" 
                       value="{{ old('scheduled_date') }}" min="{{ date('Y-m-d') }}">
                @error('scheduled_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-clock text-primary"></i> Pickup Time
                </label>
                <input type="time" name="scheduled_time" class="form-control @error('scheduled_time') is-invalid @enderror" 
                       value="{{ old('scheduled_time') }}">
                @error('scheduled_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-map-marker-alt text-primary"></i> Pickup Address
            </label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                   value="{{ old('address') }}" placeholder="Enter your full address for pickup">
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">This will help volunteers locate your donation</small>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-globe text-primary"></i> Latitude (Optional)
                </label>
                <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" 
                       value="{{ old('latitude') }}" placeholder="e.g., 23.7809">
                @error('latitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-globe text-primary"></i> Longitude (Optional)
                </label>
                <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" 
                       value="{{ old('longitude') }}" placeholder="e.g., 90.2792">
                @error('longitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success btn-custom" style="padding: 12px; font-size: 1.1rem;">
                <i class="fas fa-check"></i> Complete Donation
            </button>
            <a href="{{ route('donations.create') }}" class="btn btn-outline-secondary btn-custom">
                <i class="fas fa-arrow-left"></i> Back to Item Details
            </a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
