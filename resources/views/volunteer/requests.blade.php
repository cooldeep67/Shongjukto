<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .dashboard-card { background: #fff; border-radius: 1.5rem; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 2.5rem 2rem 2rem 2rem; margin-top: 40px; margin-bottom: 40px; }
        .dashboard-title { font-family: 'Segoe UI', sans-serif; font-size: 2.1rem; font-weight: 700; color: #2d6a4f; margin-bottom: 1.2rem; }
        .table thead th { background: #e9f5ee; color: #2d6a4f; font-weight: 600; }
        .btn-success.btn-sm { background: linear-gradient(90deg, #2d6a4f 60%, #40916c 100%); border: none; font-weight: 600; letter-spacing: 1px; }
        .btn-success.btn-sm:hover { background: linear-gradient(90deg, #40916c 60%, #2d6a4f 100%); }
        .logout-btn { font-size: 0.95rem; padding: 0.4rem 1.1rem; }
        .accepted-badge { background: #b7e4c7; color: #2d6a4f; font-weight: 600; border-radius: 0.5rem; padding: 0.3rem 0.8rem; }
    </style>
</head>
<body>
<div class="container">

    <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="dashboard-title d-flex align-items-center">
                <span style="font-size:2.2rem; font-weight:800; letter-spacing:1px; color:#1b4332;">Volunteer Dashboard</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-primary logout-btn">Home</a>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary logout-btn">Profile</a>
                <a href="{{ route('volunteer.donations') }}" class="btn btn-primary logout-btn" style="background:linear-gradient(90deg, #40916c 60%, #2d6a4f 100%); border:none;">
                    View Donations
                </a>
                <a href="{{ route('logout') }}" class="btn btn-danger logout-btn">Logout</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($requests->isEmpty())
            <div class="alert alert-info text-center mt-4 mb-0" style="border-radius:1rem; box-shadow:0 2px 12px #b7e4c7;">
                <span style="font-size:1.15rem; color:#1b4332; font-weight:600;">No pending help requests available at the moment.</span>
            </div>
        @else
            <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mt-3" style="border-radius:1rem; overflow:hidden;">
                <thead class="table-light">
                    <tr style="font-size:1.08rem;">
                        <th>Category</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                    <tr>
                        <td>
                            <span class="fw-semibold" style="color:#2d6a4f;">{{ $request->category }}</span>
                        </td>
                        <td>{{ $request->description ?? 'N/A' }}</td>
                        <td>
                            @if($request->status === 'pending')
                                <span class="badge bg-warning text-dark" style="font-size:1rem; padding:0.5em 1.1em; border-radius:0.7em;">Pending</span>
                            @elseif($request->status === 'accepted')
                                <span class="accepted-badge" style="font-size:1rem;">Accepted</span>
                            @else
                                <span class="badge bg-danger" style="font-size:1rem; padding:0.5em 1.1em; border-radius:0.7em;">Declined</span>
                            @endif
                        </td>
                        <td>
                            @if($request->status === 'pending')
                                <div class="d-flex gap-2">
                                    <form method="POST" action="{{ route('volunteer.requests.accept', $request->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" style="border-radius:0.7em;">Accept</button>
                                    </form>
                                    <form method="POST" action="{{ route('volunteer.requests.decline', $request->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" style="border-radius:0.7em;">Decline</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted">Processed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
