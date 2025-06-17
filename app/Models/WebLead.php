<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebLead extends Model
{
    use HasFactory;

    protected $table = 'webleads';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_type',
        'requirement',
        'description',
    ];
}
