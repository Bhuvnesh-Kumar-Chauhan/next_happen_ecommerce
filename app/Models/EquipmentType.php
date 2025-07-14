<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $table = 'equipment_types';

     protected $fillable = [
        'name',
        'is_active'
    ];

    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'equipment_type_id');
    }
}
