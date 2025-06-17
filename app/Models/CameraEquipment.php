<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraEquipment extends Model {
    use HasFactory;


    protected $table = "camera_equipments";

    protected $fillable = [
        'title', 'category', 'details', 'length', 'width', 'service_id', 'is_active'
    ];

    public function service() {
        return $this->belongsTo(Service::class);
    }
}
