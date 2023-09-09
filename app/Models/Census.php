<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Residence;

class Census extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type'
    ];

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }
}
