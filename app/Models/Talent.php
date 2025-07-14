<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;
    protected $table = 'talents';

    protected $fillable = [
       
        'name',
        'talent_category_id',
        'rate',
        'offered_rate',
        'audience_type',
        'talent_image',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(TalentCategory::class, 'talent_category_id');
    }
}