<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'capacity',
        'venue_type',
        'price',
        'offer_price',
        'video',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function availabilities()
    {
        return $this->hasMany(VenueAvailability::class);
    }
    
}
