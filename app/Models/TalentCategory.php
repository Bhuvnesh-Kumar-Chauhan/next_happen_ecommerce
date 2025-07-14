<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentCategory extends Model
{
    use HasFactory;
    protected $table = 'talent_categories';
    protected $fillable = [
        'name',
        'is_active'
    ];

    public function talents()
    {
        return $this->hasMany(Talent::class);
    }
}