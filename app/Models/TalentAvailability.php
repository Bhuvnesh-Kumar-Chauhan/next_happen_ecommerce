<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentAvailability extends Model
{
    use HasFactory;
    protected $table = 'talents_availabilites';
    // VenueAvailability.php
    protected $fillable = ['talent_id', 'date', 'is_available'];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
