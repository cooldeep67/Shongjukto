<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@lewravel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sample clinics
        Clinic::create([
            'name' => 'City General Hospital',
            'description' => 'A comprehensive healthcare facility providing various medical services.',
            'address' => '123 Main Street, Downtown',
            'phone' => '+1-555-0123',
            'email' => 'info@citygeneral.com',
            'is_active' => true,
        ]);

        Clinic::create([
            'name' => 'Community Health Center',
            'description' => 'Focused on providing affordable healthcare to the community.',
            'address' => '456 Oak Avenue, Westside',
            'phone' => '+1-555-0456',
            'email' => 'contact@communityhealth.org',
            'is_active' => true,
        ]);

        Clinic::create([
            'name' => 'Family Medical Clinic',
            'description' => 'Specialized in family medicine and preventive care.',
            'address' => '789 Pine Road, Eastside',
            'phone' => '+1-555-0789',
            'email' => 'hello@familymedical.com',
            'is_active' => true,
        ]);

        // Create sample students
        Student::create([
            'name' => 'Sarah Johnson',
            'student_id' => 'STU001',
            'school' => 'Lincoln High School',
            'grade' => '11th Grade',
            'description' => 'Sarah is a bright student with a passion for science and mathematics.',
            'monthly_fee' => 150.00,
            'contact_person' => 'Mrs. Johnson',
            'contact_phone' => '+1-555-1001',
            'contact_email' => 'johnson@email.com',
            'is_active' => true,
        ]);

        Student::create([
            'name' => 'Michael Chen',
            'student_id' => 'STU002',
            'school' => 'Riverside Middle School',
            'grade' => '8th Grade',
            'description' => 'Michael excels in arts and music, showing great creativity.',
            'monthly_fee' => 120.00,
            'contact_person' => 'Mr. Chen',
            'contact_phone' => '+1-555-1002',
            'contact_email' => 'chen@email.com',
            'is_active' => true,
        ]);

        Student::create([
            'name' => 'Emily Rodriguez',
            'student_id' => 'STU003',
            'school' => 'Central Elementary',
            'grade' => '5th Grade',
            'description' => 'Emily is a young learner with a love for reading and writing.',
            'monthly_fee' => 100.00,
            'contact_person' => 'Ms. Rodriguez',
            'contact_phone' => '+1-555-1003',
            'contact_email' => 'rodriguez@email.com',
            'is_active' => true,
        ]);

        // Create sample volunteer
        User::create([
            'name' => 'Volunteer Helper',
            'email' => 'volunteer@lewravel.com',
            'password' => Hash::make('password'),
            'role' => 'volunteer',
        ]);

        // Create sample beneficiary
        User::create([
            'name' => 'Beneficiary User',
            'email' => 'beneficiary@lewravel.com',
            'password' => Hash::make('password'),
            'role' => 'beneficiary',
        ]);
    }
}
