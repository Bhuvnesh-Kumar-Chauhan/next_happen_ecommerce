<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'audience',
        'platform',
        'followers_count',
        'rate_card',
        'service_id',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

