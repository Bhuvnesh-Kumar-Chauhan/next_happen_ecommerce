<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Celebrity extends Model
{
    protected $fillable = [
        'service_id', 'name', 'category', 'audience', 'rate_card', 'available_from', 'available_to', 'status',
    ];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

