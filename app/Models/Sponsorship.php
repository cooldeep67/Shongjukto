<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'student_id',
        'type',
        'amount',
        'start_date',
        'end_date',
        'status',
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}


