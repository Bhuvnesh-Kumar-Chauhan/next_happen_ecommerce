<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueImages extends Model
{
    use HasFactory;
    protected $table = 'venue_images';
    protected $fillable = ['venue_id', 'image'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

}
