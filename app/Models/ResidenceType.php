<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Residence;

class ResidenceType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];  

    public function residences()
    {
        return $this->hasMany(Residence::class);
    }
}
