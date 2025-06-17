<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Venue.php
class Venue extends Model
{

    use HasFactory;
    protected $fillable = [
        'name', 'location', 'capacity', 'indoor', 'outdoor', 'air_conditioned', 'parking_available',
        'stage_available', 'audio_system_included', 'video_system_included', 'catering_services',
        'venue_type', 'seating_style', 'booking_hours', 'pricing_per_hour', 'photos',
        'contact_person', 'contact_number', 'amenities', 'is_active','service_id'
    ];

    protected $casts = [
        'indoor' => 'boolean',
        'outdoor' => 'boolean',
        'air_conditioned' => 'boolean',
        'parking_available' => 'boolean',
        'stage_available' => 'boolean',
        'audio_system_included' => 'boolean',
        'video_system_included' => 'boolean',
        'catering_services' => 'boolean',
        'is_active' => 'boolean',
        'photos' => 'array',
        'amenities' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
