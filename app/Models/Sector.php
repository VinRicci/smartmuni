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
        'description',
        'village_id',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
