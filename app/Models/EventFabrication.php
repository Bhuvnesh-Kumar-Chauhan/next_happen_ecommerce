<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class EventFabrication extends Model
{
    use HasFactory;
     protected $table = 'event_fabrications';
        protected $fillable = [
            'event_id',
            'fabric_type',
            'tablecloths',
            'drapes_style',
            'fabric_color',
            'fabric_quantity',
            'custom_fabric_image',
        ];
 
   public function event()
    {
        return $this->belongsTo(Event::class);
    }
   
    public function tablecloth()
    {
        return $this->belongsTo(Fabrication::class, 'tablecloths');
    }
   
    public function drapesStyle()
    {
        return $this->belongsTo(Fabrication::class, 'drapes_style');
    }
     public function fabricType()
    {
        return $this->belongsTo(Fabrication::class, 'fabric_type');
    }
}
 
 