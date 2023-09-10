<?php

namespace App\Models;
use App\Models\Residence;
use App\Models\Payment;
use App\Models\Village;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
        'cost',
        'delay_percentage',
        'deadline'
    ];

    public function residences()
    {
        return $this->belongsToMany(Residence::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function villages()
    {
        return $this->belongsToMany(Village::class);
    }
}
