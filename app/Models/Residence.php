<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Village;
use App\Models\Census;
use App\Models\Location;
use App\Models\Responsible;
use App\Models\Sector;
use App\Models\ResidenceType;
use App\Models\Service;
use App\Models\Payment;

class Residence extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'reference',
        'village_id',
        'sector_id',
        'residence_type_id',
        'domicile_number',
        'status',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

     // Definir la relación con Sectores a través de Aldea
    // public function sectores()
    // {
    //     return $this->hasManyThrough(Sector::class, Village::class, );
    // }

    public function census()
    {
        return $this->hasMany(Census::class);
    }

    public function responsible()
    {
        return $this->hasOne(Responsible::class);
    }

    public function residence_type()
    {
        return $this->belongsTo(ResidenceType::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function location()
    {
        return $this->hasOne(Responsible::class);
    }

    // public function location(): BelongsTo
    // {
    //     return $this->belongsTo(Location::class);
    // }


    protected $casts = [
        'processed' => 'bool',
        'geojson' => 'array',
    ];

    /**
     * The following code was generated for use with Filament Google Maps
     *
     * php artisan fgm:model-code Location --lat=lat --lng=lng --location=location --terse
     */

    function getLocationAttribute(): array
    {
        return [
            "lat" => (float)$this->lat,
            "lng" => (float)$this->lng,
        ];
    }

    function setLocationAttribute(?array $location): void
    {
        if (is_array($location))
        {
            $this->attributes['lat'] = $location['lat'];
            $this->attributes['lng'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'lat',
            'lng' => 'lng',
        ];
    }

    public static function getComputedLocation(): string
    {
        return 'location';
    }


}
