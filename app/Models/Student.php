<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_id',
        'school',
        'grade',
        'description',
        'monthly_fee',
        'contact_person',
        'contact_phone',
        'contact_email',
        'is_active',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }
}
