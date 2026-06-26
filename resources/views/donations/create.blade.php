<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Donation - Shongjukto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .donation-form { 
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
            background: #667eea;
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
            background: #28a745;
        }
        .step.active .step-text {
            color: #28a745;
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

<div class="donation-form">
    <div class="step-indicator">
        <div class="step active">
            <div class="step-number">1</div>
            <div class="step-text">Item Details</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-number">2</div>
            <div class="step-text">Schedule</div>
        </div>
    </div>

    <h3 class="page-title">
        <i class="fas fa-gift text-primary"></i> Create Your Donation
    </h3>

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

    <form action="{{ route('donations.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-box text-primary"></i> What are you donating?
            </label>
            <select name="item" class="form-select @error('item') is-invalid @enderror">
                <option value="">-- Select an item --</option>
                <option value="Food" {{ old('item')=='Food'?'selected':'' }}>🍽️ Food</option>
                <option value="Clothes" {{ old('item')=='Clothes'?'selected':'' }}>👕 Clothes</option>
                <option value="Medicine" {{ old('item')=='Medicine'?'selected':'' }}>💊 Medicine</option>
                <option value="Books" {{ old('item')=='Books'?'selected':'' }}>📚 Books</option>
                <option value="Toys" {{ old('item')=='Toys'?'selected':'' }}>🧸 Toys</option>
                <option value="Electronics" {{ old('item')=='Electronics'?'selected':'' }}>📱 Electronics</option>
                <option value="Other" {{ old('item')=='Other'?'selected':'' }}>📦 Other</option>
            </select>
            @error('item')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-hashtag text-primary"></i> Quantity
            </label>
            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                   value="{{ old('quantity') }}" placeholder="e.g., 5 bags, 10 pieces">
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Optional - specify the quantity of items</small>
        </div>

        <div class="mb-4">
            <label class="form-label">
                <i class="fas fa-align-left text-primary"></i> Description
            </label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                      rows="4" placeholder="Tell us more about your donation...">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Optional - provide details about the condition, brand, expiry date, etc.</small>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-custom" style="padding: 12px; font-size: 1.1rem;">
                <i class="fas fa-arrow-right"></i> Next: Schedule Pickup
            </button>
            <a href="{{ route('donations.my') }}" class="btn btn-outline-secondary btn-custom">
                <i class="fas fa-list"></i> View My Donations
            </a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
