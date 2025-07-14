<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabrication extends Model
{
    use HasFactory;


    protected $table = "fabrications";

    protected $fillable = [
        'fabrication_type',
        'name',
        'description',
        'images',
        'status',
    ];

    public function usedAsTableclothInEvents()
    {
        return $this->hasMany(EventFabrication::class, 'tablecloths');
    }
    public function usedAsDrapesStyleInEvents()
    {
        return $this->hasMany(EventFabrication::class, 'drapes_style');
    }
    public function usedAsFabricTypeInEvents()
    {
        return $this->hasMany(EventFabrication::class, 'fabric_type');
    }
    
}

