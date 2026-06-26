<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Lewravel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ __('messages.edit_student') }}</h1>
            <a href="{{ route('admin.students') }}" class="btn btn-secondary">{{ __('messages.back_to_students') }}</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 1050; min-width: 300px; max-width: 500px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: none; border-radius: 8px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; border-left: 4px solid #dc3545;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('messages.student_information') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('messages.student_name') }} *</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="student_id" class="form-label">{{ __('messages.student_id') }} *</label>
                                <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id', $student->student_id) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="school" class="form-label">{{ __('messages.school') }} *</label>
                                <input type="text" class="form-control" id="school" name="school" value="{{ old('school', $student->school) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="grade" class="form-label">{{ __('messages.grade') }} *</label>
                                <input type="text" class="form-control" id="grade" name="grade" value="{{ old('grade', $student->grade) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="monthly_fee" class="form-label">{{ __('messages.monthly_fee') }} *</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" class="form-control" id="monthly_fee" name="monthly_fee" value="{{ old('monthly_fee', $student->monthly_fee) }}" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_person" class="form-label">{{ __('messages.contact_person') }}</label>
                                <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person', $student->contact_person) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">{{ __('messages.contact_phone') }}</label>
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $student->contact_phone) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact_email" class="form-label">{{ __('messages.contact_email') }}</label>
                                <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email', $student->contact_email) }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('messages.description') }}</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $student->description) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.students') }}" class="btn btn-secondary me-2">{{ __('messages.cancel') }}</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('messages.update_student') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
