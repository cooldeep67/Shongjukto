<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    // Table name (optional if follows Laravel convention)
    protected $table = 'donations';

    // Mass assignable fields
    protected $fillable = [
        'donor_id',
        'item',
        'quantity',
        'description',
        'scheduled_date',
        'scheduled_time',
        'status',
        'volunteer_id',
        'latitude',
        'longitude',
        'address'
    ];

    // Default attribute values
    protected $attributes = [
        'status' => 'pending', // new donations are pending by default
    ];

    // Relationship: a donation belongs to a donor (user)
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
    
    public function volunteer() {
        return $this->belongsTo(User::class, 'volunteer_id');
    }
    
    public function updates()
    {
        return $this->hasMany(DonationUpdate::class);
    }
}
