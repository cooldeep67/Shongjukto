<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsorship;
use App\Models\Student;

class SponsorshipController extends Controller
{
    public function create()
    {
        $students = Student::where('is_active', true)->orderBy('name')->get();
        return view('sponsorships.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:fees,books,supplies',
            'amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Sponsorship::create([
            'donor_id' => session('user_id'),
            'student_id' => $request->student_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
        ]);

        return back()->with('success', 'Sponsorship created successfully');
    }

    public function my()
    {
        $items = Sponsorship::where('donor_id', session('user_id'))
            ->with('student')
            ->latest()
            ->get();
        return view('sponsorships.my', compact('items'));
    }
}


