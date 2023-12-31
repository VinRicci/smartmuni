<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sector;
use App\Models\Residence;
use App\Models\Census;
use App\Models\Service;

class Village extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }

    public function residences()
    {
        return $this->hasMany(Residence::class);
    }

    public function census()
    {
        return $this->hasMany(Census::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
