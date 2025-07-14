<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipment';

    protected $fillable = [
        'equipment_type_id',
        'name',
        'price',
        'offered_price',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }
    public function usedAsCameraAccessoryInEvents()
    {
        return $this->hasMany(EventEquipment::class, 'camera_accessories');
    }

    public function usedAsSoundSystemInEvents()
    {
        return $this->hasMany(EventEquipment::class, 'sound_system');
    }

    public function usedAsLightingInEvents()
    {
        return $this->hasMany(EventEquipment::class, 'lighting');
    }

    public function usedAsAvEquipmentInEvents()
    {
        return $this->hasMany(EventEquipment::class, 'av_equipment');
    }


}
