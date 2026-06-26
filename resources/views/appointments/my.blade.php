<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Appointments</title>
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
    <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-outline-primary" href="{{ route('home') }}">Home</a>
        <a class="btn btn-outline-secondary" href="{{ route('request.help') }}">Request Help</a>
        <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
    </div>
    <h3 class="mb-3">My Appointments</h3>

    @if($appointments->isEmpty())
        <div class="alert alert-info">No appointments yet.</div>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Clinic</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($appointments as $a)
                <tr>
                    <td>{{ $a->clinic_name }}</td>
                    <td>{{ $a->appointment_date }}</td>
                    <td>{{ $a->appointment_time }}</td>
                    <td>{{ ucfirst($a->status) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('appointments.create') }}" class="btn btn-primary mt-3">Book Appointment</a>
</div>
</body>
</html>


