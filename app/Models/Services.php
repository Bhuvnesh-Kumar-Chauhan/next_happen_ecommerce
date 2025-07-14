<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
   use HasFactory;
    protected $table = 'services';

     protected $fillable = [
        'service_category_id',
        'name',
        'price',
        'offered_price',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
}
