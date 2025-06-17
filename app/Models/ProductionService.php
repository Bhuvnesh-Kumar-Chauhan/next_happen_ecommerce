<?php

// app/Models/ProductionService.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',  // include service_id in fillable fields
        'video_coverage',
        'livestream_setup',
        'photography',
        'post_event_editing',
        'notes',
        'status'
    ];

    // Define relationship with Service model
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
