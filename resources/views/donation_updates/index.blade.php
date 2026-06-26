<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Updates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .updates-container { max-width: 800px; margin: 90px auto; background: #fff; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.12); padding: 2rem; position: relative; }
        .btn-pill { border-radius: 12px; padding: 10px 18px; font-weight: 600; }
        .title { font-weight: 800; color: #1b4332; }
        .topbar { position: absolute; top: 16px; right: 16px; display: flex; gap: 8px; }
        .donation-info { background: #f8f9fa; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1.5rem; }
        .update-card { border: 1px solid #e9ecef; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 1rem; }
        .update-photo { max-width: 100%; border-radius: 0.5rem; margin-top: 1rem; }
        .no-updates { text-align: center; padding: 3rem; color: #6c757d; }
    </style>
</head>
<body>
<div class="updates-container">
    <div class="topbar">
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm" style="border-radius:10px;">Home</a>
        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:10px;">Profile</a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-sm" style="border-radius:10px;">Logout</a>
    </div>

    <h3 class="title mb-4">Donation Updates</h3>
    
    <div class="donation-info">
        <h6 class="text-muted mb-2">Donation Details:</h6>
        <p class="mb-1"><strong>Item:</strong> {{ $donation->item }}</p>
        <p class="mb-1"><strong>Quantity:</strong> {{ $donation->quantity }}</p>
        <p class="mb-0"><strong>Donor:</strong> {{ $donation->donor->name }}</p>
    </div>

    @if($donation->updates->isEmpty())
        <div class="no-updates">
            <h5 class="text-muted">No updates yet</h5>
            <p>Volunteers will post updates here about how this donation was used.</p>
        </div>
    @else
        @foreach($donation->updates as $update)
            <div class="update-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-0 text-primary">{{ $update->title }}</h6>
                    <small class="text-muted">{{ $update->created_at->format('M d, Y') }}</small>
                </div>
                
                <p class="mb-2">{{ $update->report }}</p>
                
                @if($update->photo_url)
                    <img src="{{ $update->photo_url }}" alt="Donation Update Photo" class="update-photo">
                @endif
            </div>
        @endforeach
    @endif

    <div class="d-flex gap-2 mt-4">
        @if(session('user_role') === 'volunteer')
            <a href="{{ route('donations.updates.create', $donation->id) }}" class="btn btn-primary btn-pill">Add Update</a>
        @endif
        @if(session('user_role') === 'volunteer')
            <a href="{{ route('volunteer.donations') }}" class="btn btn-outline-secondary btn-pill">Back to Donations</a>
        @elseif(session('user_role') === 'donor')
            <a href="{{ route('donations.my') }}" class="btn btn-outline-secondary btn-pill">Back to My Donations</a>
        @endif
    </div>
</div>
</body>
</html>
