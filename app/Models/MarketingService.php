<?php

// app/Models/MarketingService.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingService extends Model
{
    protected $fillable = [
        'service_id',
        'social_media_campaigns',
        'influencer_shoutouts',
        'email_campaigns',
        'whatsapp_promotions',
        'status'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

