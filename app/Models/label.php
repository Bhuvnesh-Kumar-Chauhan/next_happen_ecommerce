<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class label extends Model
{
    use HasFactory;
    protected $table = 'labels';
    public $fillable = [
        'name','status'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);  
    }
  
}
