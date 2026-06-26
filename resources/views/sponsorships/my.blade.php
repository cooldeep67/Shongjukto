<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Sponsorships - Shongjukto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            min-height: 100vh; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .page-container { 
            max-width: 1000px; 
            margin: 90px auto; 
            background: #fff; 
            border-radius: 1rem; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.12); 
            padding: 2rem; 
            position: relative; 
        }
        .btn-pill { 
            border-radius: 12px; 
            padding: 8px 16px; 
            font-weight: 600; 
        }
        .title { 
            font-weight: 800; 
            color: #1b4332; 
        }
        .topbar { 
            position: absolute; 
            top: 16px; 
            right: 16px; 
            display: flex; 
            gap: 8px; 
        }
        .table thead th { 
            background: #e9f5ee; 
            color: #2d6a4f; 
            font-weight: 600; 
        }
        .status-badge { 
            padding: 0.25rem 0.75rem; 
            border-radius: 0.5rem; 
            font-size: 0.875rem; 
            font-weight: 600; 
        }
        .status-active { 
            background: #d1e7dd; 
            color: #0f5132; 
        }
        .status-inactive { 
            background: #f8d7da; 
            color: #721c24; 
        }
    </style>
</head>
<body>
<div class="page-container">
    <div class="topbar">
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm btn-pill">Home</a>
        <a href="{{ route('donations.my') }}" class="btn btn-outline-secondary btn-sm btn-pill">My Donations</a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-sm btn-pill">Logout</a>
    </div>
    <h3 class="title mb-4">My Sponsorships</h3>

    @if($items->isEmpty())
        <div class="alert alert-info text-center">No sponsorships yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="border-radius: 12px; overflow: hidden;">
                <thead>
                <tr>
                    <th>Student</th>
                    <th>School</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Period</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $s)
                    <tr>
                        <td>
                            <strong>{{ $s->student->name }}</strong><br>
                            <small class="text-muted">{{ $s->student->grade }}</small>
                        </td>
                        <td>{{ $s->student->school }}</td>
                        <td>{{ ucfirst($s->type) }}</td>
                        <td>
                            @if($s->amount)
                                <span class="text-success fw-bold">৳{{ number_format($s->amount, 2) }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($s->start_date && $s->end_date)
                                {{ \Carbon\Carbon::parse($s->start_date)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($s->end_date)->format('M d, Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($s->status === 'active')
                                <span class="status-badge status-active">Active</span>
                            @else
                                <span class="status-badge status-inactive">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    <div class="text-center mt-4">
        <a href="{{ route('sponsorships.create') }}" class="btn btn-primary btn-pill">Create New Sponsorship</a>
    </div>
</div>
</body>
</html>


