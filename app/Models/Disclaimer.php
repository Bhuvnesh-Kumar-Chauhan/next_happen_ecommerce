<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disclaimer extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'user_id',
        'disclaimer',
        'is_deleted',
    ];

    protected $table = 'disclaimers';
    protected $dates = ['start_time','end_time'];
    
    function event(){
        return $this->hasOne(Event::class,'id','event_id');
    }
}
