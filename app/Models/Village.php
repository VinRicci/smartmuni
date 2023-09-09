<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sector;
use App\Models\Residence;
use App\Models\Census;

class Village extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function residences()
    {
        return $this->hasMany(Residence::class);
    }

    public function census()
    {
        return $this->hasMany(Census::class);
    }
}
