<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Venue; 

class EventVenue extends Model
{
    use HasFactory;
    protected $table = 'event_venue';
    protected $fillable = [
        'venue_id',
        'event_id',
        'event_date',
        
    ];


    public function venue_images()
    {
        return $this->hasMany(VenueImages::class);
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }
}
