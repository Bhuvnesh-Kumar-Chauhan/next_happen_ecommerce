<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoundEquipment extends Model
{
    use HasFactory;

    protected $table="sound_equipments";
    protected $fillable = [
        'service_id', 'name', 'description', 'is_active',
        'mixer', 'woofers', 'line_array', 'monitor_speakers',
        'microphones', 'wireless_mics', 'amplifiers', 'equalizers',
        'setup_area_size'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
