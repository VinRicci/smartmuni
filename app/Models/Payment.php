<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Domicile;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'made_in',
        'amount',
        'description',
        'domicile_id'
    ];

    public function domicile(): HasMany
    {
        return $this->hasMany(Domicile::class, 'domicile_id', 'id')->withTrashed();
    }
}
