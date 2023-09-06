<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

use App\Models\Responsable;

class Domicile extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'reference',
        'domicile_number',
        'status',
        'responsable_id',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'domicile_id', 'id')->withTrashed();
    }
    
    public function responsable(): HasMany
    {
        return $this->hasMany(Responsable::class, 'responsable_id', 'id')->withTrashed();
    }

}
