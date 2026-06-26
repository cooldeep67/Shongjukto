<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    // Show create donation form (item selection and description)
    public function create()
    {
        return view('donations.create');
    }

    // Store donation item and description, redirect to scheduling
    public function store(Request $request)
    {
        $request->validate([
            'item' => 'required|string',
            'quantity' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        // Store in session for the next step
        session([
            'donation_item' => $request->item,
            'donation_quantity' => $request->quantity,
            'donation_description' => $request->description,
        ]);

        return redirect()->route('donations.schedule');
    }

    // Show scheduling form
    public function schedule()
    {
        if (!session('donation_item')) {
            return redirect()->route('donations.create');
        }
        return view('donations.schedule');
    }

    // Store complete donation with scheduling
    public function storeSchedule(Request $request)
    {
        $request->validate([
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string|max:255',
        ]);

        Donation::create([
            'donor_id' => session('user_id'),
            'item' => session('donation_item'),
            'quantity' => session('donation_quantity'),
            'description' => session('donation_description'),
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'status' => 'pending',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
        ]);

        // Clear session data
        session()->forget(['donation_item', 'donation_quantity', 'donation_description']);

        return redirect()->route('donations.my')->with('success', 'Donation scheduled successfully!');
    }

    // List donor's donations
    public function myDonations()
    {
       $donations = Donation::with('updates')->where('donor_id', session('user_id'))->latest()->get();
        return view('donations.my', compact('donations'));
    }

    // Volunteers can view available donations
    public function index()
    {
        $donations = Donation::where('status', 'pending')->latest()->get();
        return view('donations.available', compact('donations'));
    }

    // API endpoints for map
    public function mapData()
    {
        $help = \App\Models\HelpRequest::select('id','category','description','status','latitude','longitude','address','created_at')->whereNotNull('latitude')->whereNotNull('longitude')->get();
        $donations = Donation::select('id','item','quantity','description','status','latitude','longitude','address','scheduled_date','scheduled_time')->whereNotNull('latitude')->whereNotNull('longitude')->get();
        return response()->json([
            'helpRequests' => $help,
            'donations' => $donations,
        ]);
    }

    // Volunteer accepts donation
    public function accept($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->status = 'accepted';
        $donation->volunteer_id = session('user_id');
        $donation->save();

        return redirect()->back()->with('success', 'Donation accepted!');
    }
}
