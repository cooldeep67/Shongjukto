<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Photo Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 50px; }
        .test-form { max-width: 500px; margin: 0 auto; background: #fff; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.12); padding: 2rem; }
    </style>
</head>
<body>
<div class="test-form">
    <h3 class="mb-4">Test Photo Upload</h3>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('test.upload.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Test Photo</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            <div class="form-text">Upload a test image (max 2MB)</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Test Text</label>
            <input type="text" name="test_text" class="form-control" value="Test upload">
        </div>

        <button type="submit" class="btn btn-primary">Test Upload</button>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Back to Home</a>
    </form>
</div>
</body>
</html>
