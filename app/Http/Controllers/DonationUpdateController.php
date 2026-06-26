<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationUpdate;
use App\Models\Donation;
use Illuminate\Support\Facades\Storage;

class DonationUpdateController extends Controller
{
    public function store(Request $request, $donationId)
    {
        // Only volunteers can create updates
        if (session('user_role') !== 'volunteer') {
            return redirect('/')->with('error', 'Only volunteers can create donation updates.');
        }

        \Log::info('DonationUpdate store method called', [
            'donation_id' => $donationId,
            'has_file' => $request->hasFile('photo'),
            'file_size' => $request->file('photo') ? $request->file('photo')->getSize() : 'no file',
            'file_name' => $request->file('photo') ? $request->file('photo')->getClientOriginalName() : 'no file',
            'file_mime' => $request->file('photo') ? $request->file('photo')->getMimeType() : 'no file'
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'report' => 'required|string|min:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            try {
                $photoPath = $request->file('photo')->store('donation-updates', 'public');
                \Log::info('Photo uploaded successfully: ' . $photoPath);
            } catch (\Exception $e) {
                \Log::error('Photo upload failed: ' . $e->getMessage());
                return back()->with('error', 'Photo upload failed: ' . $e->getMessage());
            }
        } else {
            \Log::info('No photo uploaded');
        }

        DonationUpdate::create([
            'donation_id' => $donationId,
            'title' => $request->title,
            'report' => $request->report,
            'photo_path' => $photoPath,
        ]);

        return back()->with('success', 'Update posted successfully with feedback and photo!');
    }

    public function create($donationId)
    {
        // Only volunteers can create updates
        if (session('user_role') !== 'volunteer') {
            return redirect('/')->with('error', 'Only volunteers can create donation updates.');
        }
        
        $donation = Donation::with('donor')->findOrFail($donationId);
        return view('donation_updates.create', compact('donation'));
    }

    public function index($donationId)
    {
        $donation = Donation::with(['donor', 'updates'])->findOrFail($donationId);
        return view('donation_updates.index', compact('donation'));
    }
}


