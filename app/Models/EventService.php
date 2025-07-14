<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventService extends Model
{
    use HasFactory;

    protected $table = 'event_service';
    protected $fillable = [
        'service_id',
        'event_id',
        'service_category_id',
        'event_date',
        'is_active'
    ];
}
