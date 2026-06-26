<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Clinic;

class AppointmentController extends Controller
{
    public function create()
    {
        $clinics = Clinic::where('is_active', true)->get();
        return view('appointments.create', compact('clinics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        $appointment = Appointment::create([
            'beneficiary_id' => session('user_id'),
            'clinic_name' => $request->clinic_name,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'booked',
            'outcome' => 'pending',
        ]);

        // Notify available volunteers
        $this->notifyVolunteers($appointment);

        return back()->with('success', 'Appointment booked successfully. Volunteers will be notified.');
    }

    public function my()
    {
        $appointments = Appointment::where('beneficiary_id', session('user_id'))
            ->with('volunteer')
            ->latest()
            ->get();
        return view('appointments.my', compact('appointments'));
    }

    private function notifyVolunteers($appointment)
    {
        // Get all volunteers
        $volunteers = User::where('role', 'volunteer')->get();
        
        // In a real application, you would send notifications here
        // For now, we'll just store the notification in session
        session()->flash('volunteer_notification', [
            'appointment_id' => $appointment->id,
            'beneficiary_name' => $appointment->beneficiary->name,
            'clinic_name' => $appointment->clinic_name,
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
        ]);
    }

    // Volunteer methods for accepting/declining appointments
    public function volunteerAppointments()
    {
        $appointments = Appointment::where('status', 'booked')
            ->whereNull('volunteer_id')
            ->with('beneficiary')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
        
        $myAppointments = Appointment::where('volunteer_id', session('user_id'))
            ->with('beneficiary')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
        
        return view('appointments.volunteer', compact('appointments', 'myAppointments'));
    }

    public function acceptAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        
        if ($appointment->volunteer_id) {
            return back()->withErrors(['message' => 'This appointment has already been accepted by another volunteer.']);
        }
        
        $appointment->update(['volunteer_id' => session('user_id')]);
        return back()->with('success', 'Appointment accepted successfully.');
    }

    public function declineAppointment($id)
    {
        // In a real application, you might want to track declined appointments
        // For now, we'll just redirect back
        return back()->with('success', 'Appointment declined.');
    }

    public function updateOutcome(Request $request, $id)
    {
        $request->validate([
            'outcome' => 'required|in:attended,missed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::where('volunteer_id', session('user_id'))
            ->findOrFail($id);
        
        $appointment->update([
            'outcome' => $request->outcome,
            'notes' => $request->notes,
            'status' => 'completed',
        ]);

        return back()->with('success', 'Appointment outcome updated successfully.');
    }
}


