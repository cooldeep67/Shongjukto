<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Scheduled Donations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .page-container { max-width: 1000px; margin: 90px auto; background: #fff; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.12); padding: 2rem; position: relative; }
        .btn-pill { border-radius: 12px; padding: 8px 16px; font-weight: 600; }
        .title { font-weight: 800; color: #1b4332; }
        .topbar { position: absolute; top: 16px; right: 16px; display: flex; gap: 8px; }
        .table thead th { background: #e9f5ee; color: #2d6a4f; font-weight: 600; }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-accepted { background: #d1e7dd; color: #0f5132; }
    </style>
</head>
<body>
<div class="page-container">
    <div class="topbar">
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm" style="border-radius:10px;">Home</a>
        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:10px;">Profile</a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-sm" style="border-radius:10px;">Logout</a>
    </div>

    <h3 class="title mb-4">My Scheduled Donations</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($donations->isEmpty())
        <div class="alert alert-info text-center">No donations scheduled yet.</div>
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
                        <th>Updates</th>
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
                                    <span class="status-badge status-pending">Pending</span>
                                @else
                                    <span class="status-badge status-accepted">Accepted</span>
                                @endif
                            </td>
                            <td>
                                @if($donation->status === 'accepted')
                                    <a href="{{ route('donations.updates.index', $donation->id) }}" class="btn btn-info btn-sm btn-pill">
                                        View Updates
                                        @if($donation->updates->count() > 0)
                                            <span class="badge bg-light text-dark ms-1">{{ $donation->updates->count() }}</span>
                                        @endif
                                    </a>
                                @else
                                    <span class="text-muted">No updates yet</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('donations.create') }}" class="btn btn-primary btn-pill">Schedule New Donation</a>
    </div>
</div>
</body>
</html>
