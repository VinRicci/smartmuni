<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Domicile;

class Responsable extends Model
{
    use HasFactory;
    protected $fillable = [
        'dpi',
        'name',
        'phone'
    ];


    public function domicile(): BelongsTo
    {
        return $this->belongsTo(Domicile::class, 'responsable_id', 'id')->withTrashed();
    }
}
