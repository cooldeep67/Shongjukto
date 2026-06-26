<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'title',
        'report',
        'photo_path',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo_path) {
            return null;
        }

        return asset('storage/'.$this->photo_path);
    }
}


