<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .dashboard-card { background: #fff; border-radius: 1.5rem; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 2.5rem 2rem 2rem 2rem; margin-top: 40px; margin-bottom: 40px; }
        .dashboard-title { font-family: 'Segoe UI', sans-serif; font-size: 2.1rem; font-weight: 700; color: #2d6a4f; margin-bottom: 1.2rem; }
        .table thead th { background: #e9f5ee; color: #2d6a4f; font-weight: 600; }
        .btn-success.btn-sm { background: linear-gradient(90deg, #2d6a4f 60%, #40916c 100%); border: none; font-weight: 600; letter-spacing: 1px; }
        .btn-success.btn-sm:hover { background: linear-gradient(90deg, #40916c 60%, #2d6a4f 100%); }
        .logout-btn { font-size: 0.95rem; padding: 0.4rem 1.1rem; }
        .accepted-badge { background: #b7e4c7; color: #2d6a4f; font-weight: 600; border-radius: 0.5rem; padding: 0.3rem 0.8rem; }
        .section-card { background: #f8f9fa; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; border: 1px solid #e9ecef; }
        .section-title { color: #2d6a4f; font-weight: 700; font-size: 1.3rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="dashboard-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="dashboard-title d-flex align-items-center">
                <span style="font-size:2.2rem; font-weight:800; letter-spacing:1px; color:#1b4332;">Volunteer Appointments</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-primary logout-btn">Home</a>
                <a href="{{ route('volunteer.requests') }}" class="btn btn-outline-secondary logout-btn">Help Requests</a>
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

        <!-- Available Appointments -->
        <div class="section-card">
            <h5 class="section-title">
                <i class="fas fa-calendar-plus text-primary"></i> 
                Available Appointments
            </h5>
            @if($appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" style="border-radius:1rem; overflow:hidden;">
                        <thead class="table-light">
                            <tr style="font-size:1.08rem;">
                                <th>Beneficiary</th>
                                <th>Clinic</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>
                                        <span class="fw-semibold" style="color:#2d6a4f;">{{ $appointment->beneficiary->name }}</span>
                                    </td>
                                    <td>{{ $appointment->clinic_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('volunteer.appointments.accept', $appointment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" style="border-radius:0.7em;">
                                                    <i class="fas fa-check"></i> Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('volunteer.appointments.decline', $appointment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary btn-sm" style="border-radius:0.7em;">
                                                    <i class="fas fa-times"></i> Decline
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center" style="border-radius:1rem; box-shadow:0 2px 12px #b7e4c7;">
                    <span style="font-size:1.15rem; color:#1b4332; font-weight:600;">No available appointments at the moment.</span>
                </div>
            @endif
        </div>

        <!-- My Assigned Appointments -->
        <div class="section-card">
            <h5 class="section-title">
                <i class="fas fa-calendar-check text-success"></i> 
                My Assigned Appointments
            </h5>
            @if($myAppointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" style="border-radius:1rem; overflow:hidden;">
                        <thead class="table-light">
                            <tr style="font-size:1.08rem;">
                                <th>Beneficiary</th>
                                <th>Clinic</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Outcome</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myAppointments as $appointment)
                                <tr>
                                    <td>
                                        <span class="fw-semibold" style="color:#2d6a4f;">{{ $appointment->beneficiary->name }}</span>
                                    </td>
                                    <td>{{ $appointment->clinic_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</td>
                                    <td>
                                        @if($appointment->status === 'completed')
                                            <span class="accepted-badge" style="font-size:1rem;">Completed</span>
                                        @else
                                            <span class="badge bg-warning text-dark" style="font-size:1rem; padding:0.5em 1.1em; border-radius:0.7em;">Booked</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($appointment->outcome !== 'pending')
                                            @if($appointment->outcome === 'attended')
                                                <span class="accepted-badge" style="font-size:1rem;">Attended</span>
                                            @elseif($appointment->outcome === 'missed')
                                                <span class="badge bg-danger" style="font-size:1rem; padding:0.5em 1.1em; border-radius:0.7em;">Missed</span>
                                            @else
                                                <span class="badge bg-secondary" style="font-size:1rem; padding:0.5em 1.1em; border-radius:0.7em;">Cancelled</span>
                                            @endif
                                        @else
                                            <span class="badge bg-light text-dark" style="font-size:1rem; padding:0.5em 1.1em; border-radius:0.7em;">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($appointment->status !== 'completed')
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#outcomeModal{{ $appointment->id }}" style="border-radius:0.7em;">
                                                <i class="fas fa-edit"></i> Update Outcome
                                            </button>
                                        @else
                                            <span class="text-muted">Completed</span>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Outcome Modal -->
                                <div class="modal fade" id="outcomeModal{{ $appointment->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Appointment Outcome</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('volunteer.appointments.outcome', $appointment->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="outcome" class="form-label">Outcome *</label>
                                                        <select class="form-select" id="outcome" name="outcome" required>
                                                            <option value="">Select outcome</option>
                                                            <option value="attended">Attended</option>
                                                            <option value="missed">Missed</option>
                                                            <option value="cancelled">Cancelled</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="notes" class="form-label">Notes</label>
                                                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Add any additional notes about the appointment..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Outcome</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center" style="border-radius:1rem; box-shadow:0 2px 12px #b7e4c7;">
                    <span style="font-size:1.15rem; color:#1b4332; font-weight:600;">You haven't accepted any appointments yet.</span>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
