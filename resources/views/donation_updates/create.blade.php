<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Donation Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .update-form { max-width: 600px; margin: 90px auto; background: #fff; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.12); padding: 2rem; position: relative; }
        .btn-pill { border-radius: 12px; padding: 10px 18px; font-weight: 600; }
        .title { font-weight: 800; color: #1b4332; }
        .topbar { position: absolute; top: 16px; right: 16px; display: flex; gap: 8px; }
        .donation-info { background: #f8f9fa; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
<div class="update-form">
    <div class="topbar">
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm" style="border-radius:10px;">Home</a>
        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:10px;">Profile</a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-sm" style="border-radius:10px;">Logout</a>
    </div>

    <h3 class="title mb-4">Submit Donation Update</h3>
    
    <div class="donation-info">
        <h6 class="text-muted mb-2">Donation Details:</h6>
        <p class="mb-1"><strong>Item:</strong> {{ $donation->item }}</p>
        <p class="mb-1"><strong>Quantity:</strong> {{ $donation->quantity }}</p>
        <p class="mb-0"><strong>Donor:</strong> {{ $donation->donor->name }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('donations.updates.store', $donation->id) }}" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Update Title *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g., Food distributed to 15 families">
        </div>

        <div class="mb-3">
            <label class="form-label">Detailed Report *</label>
            <textarea name="report" class="form-control" rows="6" placeholder="Describe how the donation was used, who benefited, and the impact made...">{{ old('report') }}</textarea>
            <div class="form-text">Provide detailed feedback about how the donation was utilized and its impact.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo (Optional)</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            <div class="form-text">Upload a photo showing the donation being used or distributed (max 2MB).</div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-pill">Submit Update</button>
            @if(session('user_role') === 'volunteer')
                <a href="{{ route('volunteer.donations') }}" class="btn btn-outline-secondary btn-pill">Back to Donations</a>
            @elseif(session('user_role') === 'donor')
                <a href="{{ route('donations.my') }}" class="btn btn-outline-secondary btn-pill">Back to My Donations</a>
            @endif
        </div>
    </form>
</div>
</body>
</html>
