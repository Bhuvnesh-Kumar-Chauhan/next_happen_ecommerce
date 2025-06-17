<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'event_name',
        'event_description',
        'event_type',
        'location',
        'event_date',
        'proposal_file',
        'matched_sponsor_id',
        'message',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'matched_sponsor_id');
    }
}


