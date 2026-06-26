<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HelpRequest;
use App\Models\Donation;
use Illuminate\Support\Facades\Session;

class VolunteerController extends Controller
{
    // Show all pending help requests
    public function showRequests()
    {
        $requests = HelpRequest::where('status', 'pending')->get();
        return view('volunteer.requests', compact('requests'));
    }

    // Show all available donations
    public function showDonations()
    {
        $donations = Donation::whereIn('status', ['pending', 'accepted'])->get();
        return view('volunteer.donations', compact('donations'));
    }

    // Accept a pending help request
    public function acceptRequest($id)
    {
        $request = HelpRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            return back()->with('error', 'Request is already accepted or completed.');
        }

        $request->status = 'accepted';
        $request->save();

        return back()->with('success', 'Request accepted successfully!');
    }

    // Decline a pending request
    public function declineRequest($id)
    {
        $request = HelpRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            return back()->with('error', 'Request is already processed.');
        }

        $request->status = 'declined';
        $request->save();

        return back()->with('success', 'Request declined successfully!');
    }

    // Accept a donation
    public function acceptDonation($id)
    {
        $donation = Donation::findOrFail($id);

        if ($donation->status !== 'pending') {
            return back()->with('error', 'Donation is already processed.');
        }

        $donation->status = 'accepted';
        $donation->save();

        return back()->with('success', 'Donation accepted successfully!');
    }
}
