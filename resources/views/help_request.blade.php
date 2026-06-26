<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Help - Shongjukto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .help-card { 
            max-width: 600px; 
            margin: 60px auto; 
            border-radius: 20px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); 
            padding: 40px; 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .help-title {
            font-family: 'Segoe UI', sans-serif;
            font-size: 2.1rem;
            font-weight: 700;
            color: #1b4332;
            margin-bottom: 1.2rem;
        }
        .help-icon {
            width: 60px;
            margin-bottom: 1rem;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
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
        .alert {
            border-radius: 12px;
            border: none;
        }
        .category-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .category-card:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }
        .category-card.selected {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }
        .category-icon {
            font-size: 24px;
            margin-right: 10px;
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

<div class="help-card">
    <div class="text-center mb-4">
        <img src="https://img.icons8.com/color/96/000000/helping-hand.png" class="help-icon" alt="Help Icon">
        <div class="help-title">Request Help</div>
        <p class="text-muted" style="font-size:1.1rem;">
            Tell us what you need and we'll connect you with volunteers who can help.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="/request-help">
        @csrf

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-tags text-primary"></i> What type of help do you need?
            </label>
            <div class="category-options">
                <div class="category-card {{ old('category') == 'Food' ? 'selected' : '' }}" 
                     onclick="selectCategory('Food')">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-utensils category-icon text-warning"></i>
                        <div>
                            <strong>Food</strong>
                            <div class="text-muted small">Need food assistance</div>
                        </div>
                    </div>
                </div>
                <div class="category-card {{ old('category') == 'Clothes' ? 'selected' : '' }}" 
                     onclick="selectCategory('Clothes')">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tshirt category-icon text-info"></i>
                        <div>
                            <strong>Clothes</strong>
                            <div class="text-muted small">Need clothing items</div>
                        </div>
                    </div>
                </div>
                <div class="category-card {{ old('category') == 'Education' ? 'selected' : '' }}" 
                     onclick="selectCategory('Education')">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-graduation-cap category-icon text-success"></i>
                        <div>
                            <strong>Education</strong>
                            <div class="text-muted small">Need educational support</div>
                        </div>
                    </div>
                </div>
                <div class="category-card {{ old('category') == 'Medical' ? 'selected' : '' }}" 
                     onclick="selectCategory('Medical')">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-heartbeat category-icon text-danger"></i>
                        <div>
                            <strong>Medical</strong>
                            <div class="text-muted small">Need medical assistance</div>
                        </div>
                    </div>
                </div>
            </div>
            <select name="category" id="categorySelect" class="form-select @error('category') is-invalid @enderror" style="display: none;" required>
                <option value="">-- Select Category --</option>
                <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food</option>
                <option value="Clothes" {{ old('category') == 'Clothes' ? 'selected' : '' }}>Clothes</option>
                <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                <option value="Medical" {{ old('category') == 'Medical' ? 'selected' : '' }}>Medical</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-align-left text-primary"></i> Tell us more about your need
            </label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                      rows="4" placeholder="Please provide details about your situation...">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Optional - but helpful for volunteers to understand your situation better</small>
        </div>

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-map-marker-alt text-primary"></i> Your Address
            </label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                   value="{{ old('address') }}" placeholder="Enter your address for pickup/delivery">
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Optional - helps volunteers locate you</small>
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
            <button type="submit" class="btn btn-primary btn-custom" style="padding: 14px; font-size: 1.1rem;">
                <i class="fas fa-paper-plane"></i> Submit Request
            </button>
            <a href="{{ route('my.requests') }}" class="btn btn-outline-secondary btn-custom">
                <i class="fas fa-list"></i> View My Requests
            </a>
        </div>
    </form>
</div>

<script>
function selectCategory(category) {
    // Remove selected class from all cards
    document.querySelectorAll('.category-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    event.currentTarget.classList.add('selected');
    
    // Update the hidden select
    document.getElementById('categorySelect').value = category;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>