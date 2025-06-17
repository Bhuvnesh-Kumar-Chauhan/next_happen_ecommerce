<?php

// app/Models/Speaker.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;


    protected $table="speakers";

    protected $fillable = [
        'service_id', 'name', 'topic', 'experience_years', 'language',
        'category', 'fee', 'available_from', 'available_to', 'status'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

