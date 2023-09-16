<?php

namespace App\Models;

use App\Models\Residence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    use HasFactory;
    protected $fillable = [
        'dpi',
        'name',
        'email',
        'phone'
    ];

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }
}
