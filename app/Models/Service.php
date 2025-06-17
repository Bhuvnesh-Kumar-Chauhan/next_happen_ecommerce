<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;


    protected $table = 'services';
    protected $fillable = ['name', 'type', 'description', 'is_active'];
    protected $casts = [
       
        'is_active' => 'boolean'
    ];
    
    // Scopes
    public function scopeActive($query)
    {                                                                                                                                                                                                                                                                
        return $query->where('is_active', true);
    }

    public function venues()
    {
        return $this->hasMany(Venue::class);
    }
    public function fabrications()
    {
        return $this->hasMany(Fabrication::class);
    }
    public function soundEquipments()
    {
        return $this->hasMany(SoundEquipment::class);
    }
    public function aVEquipments()
    {
        return $this->hasMany(AVEquipment::class);
    }
    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }
    public function celebrities()
    {
        return $this->hasMany(Celebrity::class);
    }
    public function influencers()
    {
        return $this->hasMany(Influencer::class);
    }
    public function sponsers()
    {
        return $this->hasMany(Sponsor::class);
    }
    public function sponserships()
    {
        return $this->hasMany(Sponsorship::class);
    }
    public function productionservices()
    {
        return $this->hasMany(ProductionService::class);
    }
    public function marketingservices()
    {
        return $this->hasMany(MarketingService::class);
    }
    
   
}