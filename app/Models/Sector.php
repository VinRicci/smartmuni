<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Village;

class Sector extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
