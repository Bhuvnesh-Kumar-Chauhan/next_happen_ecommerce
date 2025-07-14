<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueAvailability extends Model
{
    use HasFactory;

    // VenueAvailability.php
    protected $fillable = ['venue_id', 'date', 'is_available'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

}

