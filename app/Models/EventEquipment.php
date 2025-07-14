<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class EventEquipment extends Model
{
    use HasFactory;
    protected $table = 'event_equipment';
    protected $fillable = [
        'event_id',
        'camera_accessories',
        'sound_system',
        'lighting',
        'av_equipment',
        'additional_requirements',
    ];
 
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
 
    public function cameraAccessories()
    {
        return $this->belongsTo(Equipment::class, 'camera_accessories');
    }
   
    public function soundSystem()
    {
        return $this->belongsTo(Equipment::class, 'sound_system');
    }
     public function lightingEquipment()
    {
        return $this->belongsTo(Equipment::class, 'lighting');
    }
     public function avEquipment()
    {
        return $this->belongsTo(Equipment::class, 'av_equipment');
    }
 
}
 
 