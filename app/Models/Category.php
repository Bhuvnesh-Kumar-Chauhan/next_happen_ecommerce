<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategory;
use App\Models\Event;



class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'status',
    ];

    protected $table = 'category';
    protected $appends = ['imagePath'];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);  
    }

    public function events()
    {
        return $this->hasMany(Event::class);  
    }
    
    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }
}
