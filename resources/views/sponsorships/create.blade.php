<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sponsor a Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .student-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 3px solid transparent;
        }
        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-color: #007bff;
        }
        .student-card.selected {
            border-color: #28a745;
            background-color: #f8fff9;
        }
        .student-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }
        .student-info {
            text-align: center;
        }
        .student-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .student-details {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .student-fee {
            color: #28a745;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
        }
        
        /* Alert positioning and styling */
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
            border-radius: 8px;
            animation: slideInRight 0.3s ease-out;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .alert ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Responsive alert positioning */
        @media (max-width: 768px) {
            .alert {
                top: 10px;
                right: 10px;
                left: 10px;
                min-width: auto;
                max-width: none;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-4">
        <a class="btn btn-outline-primary" href="{{ route('home') }}">{{ __('messages.home') }}</a>
        <a class="btn btn-outline-secondary" href="{{ route('sponsorships.my') }}">{{ __('messages.my_sponsorships') }}</a>
        <a class="btn btn-danger" href="{{ route('logout') }}">{{ __('messages.logout') }}</a>
    </div>
    
    <div class="text-center mb-4">
        <h2 class="mb-3">
            <i class="fas fa-heart text-danger"></i> 
            {{ __('messages.sponsor_student') }}
        </h2>
        <p class="text-muted">{{ __('messages.choose_student_sponsor') }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($students->count() > 0)
        <!-- Student Selection -->
        <div class="mb-4">
            <h4 class="mb-3">
                <i class="fas fa-users text-primary"></i> 
                {{ __('messages.available_students') }}
            </h4>
            <div class="row g-4">
                @foreach($students as $student)
                    <div class="col-md-4 col-lg-3">
                        <div class="card student-card h-100" onclick="selectStudent({{ $student->id }}, '{{ $student->name }}')">
                            <div class="card-body">
                                <div class="student-avatar">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="student-info">
                                    <div class="student-name">{{ $student->name }}</div>
                                    <div class="student-details">{{ $student->school }}</div>
                                    <div class="student-details">{{ $student->grade }}</div>
                                    <div class="student-fee">৳{{ number_format($student->monthly_fee, 2) }}/month</div>
                                    @if($student->description)
                                        <small class="text-muted mt-2 d-block">{{ Str::limit($student->description, 60) }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Sponsorship Form -->
        <div class="form-section">
            <h4 class="mb-3">
                <i class="fas fa-handshake text-success"></i> 
                {{ __('messages.create_sponsorship') }}
            </h4>
            <form method="post" action="{{ route('sponsorships.store') }}" id="sponsorshipForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-user-graduate text-primary"></i> 
                                {{ __('messages.selected_student') }} *
                            </label>
                            <input type="text" class="form-control" id="selectedStudentName" readonly placeholder="Click on a student above to select">
                            <input type="hidden" name="student_id" id="selectedStudentId" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-gift text-success"></i> 
                                {{ __('messages.support_type') }} *
                            </label>
                            <select class="form-select" name="type" required>
                                <option value="">{{ __('messages.select_support_type') }}</option>
                                <option value="fees" {{ old('type') == 'fees' ? 'selected' : '' }}>
                                    <i class="fas fa-graduation-cap"></i> {{ __('messages.school_fees') }}
                                </option>
                                <option value="books" {{ old('type') == 'books' ? 'selected' : '' }}>
                                    <i class="fas fa-book"></i> {{ __('messages.books') }}
                                </option>
                                <option value="supplies" {{ old('type') == 'supplies' ? 'selected' : '' }}>
                                    <i class="fas fa-pencil-alt"></i> {{ __('messages.supplies') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-coins text-success"></i> 
                                {{ __('messages.monthly_amount') }}
                            </label>
                            <input type="number" step="0.01" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Enter monthly amount">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-calendar-plus text-primary"></i> 
                                {{ __('messages.start_date') }}
                            </label>
                            <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-calendar-minus text-warning"></i> 
                                {{ __('messages.end_date') }}
                            </label>
                            <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}">
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn" disabled>
                        <i class="fas fa-heart"></i> 
                        {{ __('messages.create_sponsorship') }}
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-users fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">{{ __('messages.no_students_available') }}</h4>
            <p class="text-muted">{{ __('messages.no_students_message') }}</p>
        </div>
    @endif
</div>

<script>
function selectStudent(studentId, studentName) {
    // Remove previous selection
    document.querySelectorAll('.student-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selection to clicked card
    event.currentTarget.classList.add('selected');
    
    // Update form fields
    document.getElementById('selectedStudentId').value = studentId;
    document.getElementById('selectedStudentName').value = studentName;
    document.getElementById('submitBtn').disabled = false;
    
    // Scroll to form
    document.querySelector('.form-section').scrollIntoView({ 
        behavior: 'smooth' 
    });
}

// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert && alert.parentNode) {
                alert.classList.remove('show');
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }
        }, 5000);
    });
    
    // Add click to dismiss functionality
    alerts.forEach(alert => {
        alert.addEventListener('click', function() {
            this.classList.remove('show');
            setTimeout(() => {
                if (this && this.parentNode) {
                    this.remove();
                }
            }, 300);
        });
    });
});
</script>
</body>
</html>


