<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\HelpRequestController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DonationUpdateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;
use Illuminate\Http\Request;

// Language switching route
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/language-test', [LanguageController::class, 'test'])->name('language.test');
Route::get('/test-language', function() { return view('test-language'); })->name('test.language');

Route::get('/', fn() => view('home'))->name('home');



// Public routes
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', fn() => view('signup'))->name('signup');
Route::post('/signup', [AuthController::class, 'register']);

// Protected routes (require login)
Route::middleware('authcheck')->group(function () {
    Route::get('/request-help', [HelpRequestController::class, 'showForm'])->name('request.help');
    Route::post('/request-help', [HelpRequestController::class, 'submit']);
    Route::get('/my-requests', [HelpRequestController::class, 'myRequests'])->name('my.requests');

    Route::get('/volunteer/requests', [VolunteerController::class, 'showRequests'])->name('volunteer.requests');


    Route::post('/volunteer/requests/{id}/accept', [VolunteerController::class, 'acceptRequest'])->name('volunteer.requests.accept');
    Route::post('/volunteer/requests/{id}/decline', [VolunteerController::class, 'declineRequest'])->name('volunteer.requests.decline');

    // Donation routes
    Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations/store', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/schedule', [DonationController::class, 'schedule'])->name('donations.schedule');
    Route::post('/donations/schedule', [DonationController::class, 'storeSchedule'])->name('donations.storeSchedule');
    Route::get('/donations/my', [DonationController::class, 'myDonations'])->name('donations.my');

    // Sponsorships (Donor)
    Route::get('/sponsorships/create', [SponsorshipController::class, 'create'])->name('sponsorships.create');
    Route::post('/sponsorships', [SponsorshipController::class, 'store'])->name('sponsorships.store');
    Route::get('/sponsorships/my', [SponsorshipController::class, 'my'])->name('sponsorships.my');

    // Appointments (Beneficiary)
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/my', [AppointmentController::class, 'my'])->name('appointments.my');

    // Volunteer Appointments
    Route::get('/volunteer/appointments', [AppointmentController::class, 'volunteerAppointments'])->name('volunteer.appointments');
    Route::post('/volunteer/appointments/{id}/accept', [AppointmentController::class, 'acceptAppointment'])->name('volunteer.appointments.accept');
    Route::post('/volunteer/appointments/{id}/decline', [AppointmentController::class, 'declineAppointment'])->name('volunteer.appointments.decline');
    Route::post('/volunteer/appointments/{id}/outcome', [AppointmentController::class, 'updateOutcome'])->name('volunteer.appointments.outcome');

    Route::get('/volunteer/donations', [VolunteerController::class, 'showDonations'])->name('volunteer.donations');
    Route::post('/volunteer/donations/{id}/accept', [VolunteerController::class, 'acceptDonation'])->name('volunteer.donations.accept');

    Route::post('/volunteer/requests/{id}/accept', [VolunteerController::class, 'acceptRequest'])->name('volunteer.requests.accept');
    Route::post('/volunteer/requests/{id}/decline', [VolunteerController::class, 'declineRequest'])->name('volunteer.requests.decline');

    // Donation updates
    Route::get('/donations/{donationId}/updates/create', [DonationUpdateController::class, 'create'])->name('donations.updates.create');
    Route::post('/donations/{donationId}/updates', [DonationUpdateController::class, 'store'])->name('donations.updates.store');
    Route::get('/donations/{donationId}/updates', [DonationUpdateController::class, 'index'])->name('donations.updates.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Volunteer-only routes
    Route::middleware('volunteer')->group(function () {
        Route::get('/map', function () { return view('map'); })->name('map.view');
        Route::get('/map/data', [DonationController::class, 'mapData'])->name('map.data');
    });

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // User Management
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        
        // Clinic Management
        Route::get('/admin/clinics', [AdminController::class, 'clinics'])->name('admin.clinics');
        Route::get('/admin/clinics/create', [AdminController::class, 'createClinic'])->name('admin.clinics.create');
        Route::post('/admin/clinics', [AdminController::class, 'storeClinic'])->name('admin.clinics.store');
        Route::get('/admin/clinics/{id}/edit', [AdminController::class, 'editClinic'])->name('admin.clinics.edit');
        Route::put('/admin/clinics/{id}', [AdminController::class, 'updateClinic'])->name('admin.clinics.update');
        Route::delete('/admin/clinics/{id}', [AdminController::class, 'deleteClinic'])->name('admin.clinics.delete');
        
        // Student Management
        Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
        Route::get('/admin/students/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
        Route::post('/admin/students', [AdminController::class, 'storeStudent'])->name('admin.students.store');
        Route::get('/admin/students/{id}/edit', [AdminController::class, 'editStudent'])->name('admin.students.edit');
        Route::put('/admin/students/{id}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
        Route::delete('/admin/students/{id}', [AdminController::class, 'deleteStudent'])->name('admin.students.delete');
        
        // Appointment Management
        Route::get('/admin/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    });
});

Route::get('/logout', function() {
    session()->forget('user_id');
    return redirect('/');
})->name('logout');





