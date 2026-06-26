<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Volunteer Donations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .donations-container { max-width: 1000px; margin: 90px auto; background: #fff; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.12); padding: 2rem; position: relative; }
        .btn-pill { border-radius: 12px; padding: 8px 16px; font-weight: 600; }
        .title { font-weight: 800; color: #1b4332; }
        .topbar { position: absolute; top: 16px; right: 16px; display: flex; gap: 8px; }
        .table thead th { background: #e9f5ee; color: #2d6a4f; font-weight: 600; }
        .action-buttons { display: flex; gap: 8px; flex-wrap: wrap; }
    </style>
</head>
<body>
<div class="donations-container">
    <div class="topbar">
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm" style="border-radius:10px;">Home</a>
        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:10px;">Profile</a>
        <a href="{{ route('volunteer.requests') }}" class="btn btn-primary btn-sm" style="border-radius:10px;">Help Requests</a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-sm" style="border-radius:10px;">Logout</a>
    </div>

    <h3 class="title mb-4">Available Donations</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($donations->isEmpty())
        <div class="alert alert-info text-center">No donations available at the moment.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td><strong>{{ $donation->item }}</strong></td>
                            <td>
                                @if($donation->description)
                                    <span class="text-muted">{{ Str::limit($donation->description, 50) }}</span>
                                    @if(strlen($donation->description) > 50)
                                        <span class="text-primary" title="{{ $donation->description }}" style="cursor: help;">...</span>
                                    @endif
                                @else
                                    <span class="text-muted">No description</span>
                                @endif
                            </td>
                            <td>{{ $donation->quantity ?? '-' }}</td>
                            <td>{{ $donation->scheduled_date }}</td>
                            <td>{{ $donation->scheduled_time }}</td>
                            <td>
                                @if($donation->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-success">Accepted</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($donation->status === 'pending')
                                        <form action="{{ route('volunteer.donations.accept', $donation->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm btn-pill">Accept</button>
                                        </form>
                                    @endif
                                    
                                    @if($donation->status === 'accepted' && session('user_role') === 'volunteer')
                                        <a href="{{ route('donations.updates.create', $donation->id) }}" class="btn btn-primary btn-sm btn-pill">Submit Update</a>
                                        <a href="{{ route('donations.updates.index', $donation->id) }}" class="btn btn-info btn-sm btn-pill">View Updates</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
</body>
</html>
