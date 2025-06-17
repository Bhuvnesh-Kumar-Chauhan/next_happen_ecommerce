<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabrication extends Model
{
    use HasFactory;


    protected $table = "fabrications";

    protected $fillable = [
        'service_id',
        'stage_with_grey_carpet',
        'stage_skirting',
        'console_masking',
        'standees',
        'selfie_point',
        'digital_podium_with_mic',
        'stairs',
        'side_flex',
        'main_flex',
        'led_letters',
        'length_in_feet',
        'width_in_feet',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

