<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTalent extends Model
{
    use HasFactory;
     protected $table = 'event_talent';
    protected $fillable = [ 
        'event_id',
        'talent_category',
        'talent_id',
        'event_date',
        'is_active'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function talents()
    {
        return $this->hasMany(EventTalent::class);
    }
}
