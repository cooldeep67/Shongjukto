<!DOCTYPE html>
<html>
<head>
    <title>My Help Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            min-height: 100vh;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="topbar">
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm" style="border-radius:10px;">Home</a>
        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:10px;">Profile</a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-sm" style="border-radius:10px;">Logout</a>
    </div>

    @if($requests->isEmpty())
        <p>You have not submitted any help requests yet.</p>
    @else
        <table class="table table-hover table-bordered" style="border-radius:12px;overflow:hidden;">
            <thead class="table-light" style="background:#e9f5ee;color:#2d6a4f;">
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->category }}</td>
                        <td>{{ $request->description ?? 'N/A' }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
