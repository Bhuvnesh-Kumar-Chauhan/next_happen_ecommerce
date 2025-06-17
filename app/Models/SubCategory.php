<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'status',
        'category_id',
    ];

    protected $table = 'subcategories';
    protected $appends = ['imagePath'];

    
    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);  
    }


}
