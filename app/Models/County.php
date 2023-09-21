<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $fillable = [
        'state_id',
        'county',
        'state_index',
    ];
}
