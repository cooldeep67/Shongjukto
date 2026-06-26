<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Book Clinic Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .clinic-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 3px solid transparent;
        }
        .clinic-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-color: #007bff;
        }
        .clinic-card.selected {
            border-color: #28a745;
            background-color: #f8fff9;
        }
        .clinic-avatar {
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
        .clinic-info {
            text-align: center;
        }
        .clinic-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .clinic-address {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .clinic-contact {
            color: #007bff;
            font-size: 0.9rem;
        }
        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-4">
        <a class="btn btn-outline-primary" href="{{ route('home') }}">Home</a>
        <a class="btn btn-outline-secondary" href="{{ route('my.requests') }}">My Requests</a>
        <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
    </div>
    
    <div class="text-center mb-4">
        <h2 class="mb-3">
            <i class="fas fa-hospital text-primary"></i> 
            Book Clinic Appointment
        </h2>
        <p class="text-muted">Choose a clinic and schedule your appointment</p>
    </div>

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

    @if($clinics->count() > 0)
        <!-- Clinic Selection -->
        <div class="mb-4">
            <h4 class="mb-3">
                <i class="fas fa-hospital text-primary"></i> 
                Available Clinics
            </h4>
            <div class="row g-4">
                @foreach($clinics as $clinic)
                    <div class="col-md-4 col-lg-3">
                        <div class="card clinic-card h-100" onclick="selectClinic('{{ $clinic->name }}', '{{ $clinic->address }}')">
                            <div class="card-body">
                                <div class="clinic-avatar">
                                    <i class="fas fa-hospital"></i>
                                </div>
                                <div class="clinic-info">
                                    <div class="clinic-name">{{ $clinic->name }}</div>
                                    <div class="clinic-address">{{ $clinic->address }}</div>
                                    @if($clinic->phone)
                                        <div class="clinic-contact">
                                            <i class="fas fa-phone"></i> {{ $clinic->phone }}
                                        </div>
                                    @endif
                                    @if($clinic->description)
                                        <small class="text-muted mt-2 d-block">{{ Str::limit($clinic->description, 60) }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Appointment Form -->
        <div class="form-section">
            <h4 class="mb-3">
                <i class="fas fa-calendar-plus text-success"></i> 
                Schedule Appointment
            </h4>
            <form method="post" action="{{ route('appointments.store') }}" id="appointmentForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-hospital text-primary"></i> 
                                Selected Clinic *
                            </label>
                            <input type="text" class="form-control" id="selectedClinicName" readonly placeholder="Click on a clinic above to select">
                            <input type="hidden" name="clinic_name" id="selectedClinicNameHidden" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt text-info"></i> 
                                Clinic Address
                            </label>
                            <input type="text" class="form-control" id="selectedClinicAddress" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-calendar text-primary"></i> 
                                Appointment Date *
                            </label>
                            <input type="date" class="form-control" name="appointment_date" value="{{ old('appointment_date') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-clock text-warning"></i> 
                                Appointment Time *
                            </label>
                            <input type="time" class="form-control" name="appointment_time" value="{{ old('appointment_time') }}" required>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                        <i class="fas fa-calendar-check"></i> 
                        Book Appointment
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-hospital fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No clinics available</h4>
            <p class="text-muted">There are currently no clinics available for appointments.</p>
            <p class="text-muted">Please contact an administrator to add clinics.</p>
        </div>
    @endif
</div>

<script>
function selectClinic(clinicName, clinicAddress) {
    // Remove previous selection
    document.querySelectorAll('.clinic-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selection to clicked card
    event.currentTarget.classList.add('selected');
    
    // Update form fields
    document.getElementById('selectedClinicName').value = clinicName;
    document.getElementById('selectedClinicNameHidden').value = clinicName;
    document.getElementById('selectedClinicAddress').value = clinicAddress;
    document.getElementById('submitBtn').disabled = false;
    
    // Scroll to form
    document.querySelector('.form-section').scrollIntoView({ 
        behavior: 'smooth' 
    });
}
</script>
</body>
</html>


