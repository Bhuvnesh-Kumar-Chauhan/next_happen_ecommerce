<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AVEquipment extends Model
{
    use HasFactory;

    protected $table ="av_equipments";

    protected $fillable = [
        'title', 'description', 'type', 'brand', 'model', 'quantity', 'length', 'width', 'is_active', 'service_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

