<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Village;
use App\Models\Census;
use App\Models\Responsible;
use App\Models\ResidenceType;
use App\Models\Service;
use App\Models\Payment;

class Residence extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'reference',
        'domicile_number',
        'status',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function census()
    {
        return $this->hasMany(Census::class);
    }

    public function responsible()
    {
        return $this->hasOne(Responsible::class);
    }

    public function residenceType()
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


}
