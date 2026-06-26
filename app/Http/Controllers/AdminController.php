<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Student;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalClinics = Clinic::count();
        $totalStudents = Student::count();
        $pendingAppointments = Appointment::where('status', 'booked')->count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalClinics', 'totalStudents', 'pendingAppointments'));
    }

    // User Management
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Don't allow admin to delete themselves
        if ($user->id == session('user_id')) {
            return back()->withErrors(['message' => 'You cannot delete your own account.']);
        }
        
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    // Clinic Management
    public function clinics()
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('admin.clinics.index', compact('clinics'));
    }

    public function createClinic()
    {
        return view('admin.clinics.create');
    }

    public function storeClinic(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Clinic::create($request->all());
        return redirect()->route('admin.clinics')->with('success', 'Clinic created successfully.');
    }

    public function editClinic($id)
    {
        $clinic = Clinic::findOrFail($id);
        return view('admin.clinics.edit', compact('clinic'));
    }

    public function updateClinic(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $clinic = Clinic::findOrFail($id);
        $clinic->update($request->all());
        return redirect()->route('admin.clinics')->with('success', 'Clinic updated successfully.');
    }

    public function deleteClinic($id)
    {
        $clinic = Clinic::findOrFail($id);
        $clinic->delete();
        return back()->with('success', 'Clinic deleted successfully.');
    }

    // Student Management
    public function students()
    {
        $students = Student::orderBy('name')->get();
        return view('admin.students.index', compact('students'));
    }

    public function createStudent()
    {
        return view('admin.students.create');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:students',
            'school' => 'required|string|max:255',
            'grade' => 'required|string|max:50',
            'description' => 'nullable|string',
            'monthly_fee' => 'required|numeric|min:0',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
        ]);

        Student::create($request->all());
        return redirect()->route('admin.students')->with('success', 'Student added successfully.');
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:students,student_id,' . $id,
            'school' => 'required|string|max:255',
            'grade' => 'required|string|max:50',
            'description' => 'nullable|string',
            'monthly_fee' => 'required|numeric|min:0',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());
        return redirect()->route('admin.students')->with('success', 'Student updated successfully.');
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return back()->with('success', 'Student deleted successfully.');
    }

    // Appointment Management
    public function appointments()
    {
        $appointments = Appointment::with(['beneficiary', 'volunteer'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();
        return view('admin.appointments.index', compact('appointments'));
    }
}
