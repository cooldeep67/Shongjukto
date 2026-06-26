<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .profile-card { max-width: 600px; margin: 90px auto; background:#fff; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.12); padding: 28px; position: relative; }
        .btn-pill { border-radius: 12px; padding: 10px 18px; font-weight: 600; }
        .title { font-weight: 800; color:#1b4332; }
        .toolbar { position:absolute; right: 18px; top: 18px; }
    </style>
</head>
<body>
<div class="profile-card">
    <div class="toolbar d-flex gap-2">
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">Home</a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-sm" style="border-radius:10px;">Logout</a>
    </div>
    <h3 class="title mb-3">My Profile</h3>

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

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">New Password (optional)</label>
            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-pill">Save Changes</button>
        </div>
    </form>
</div>
</body>
</html>


