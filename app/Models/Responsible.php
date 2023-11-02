<?php

namespace App\Models;

use App\Models\Residence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsible extends Model implements HasMedia
{
    use HasFactory, SoftDeletes;
    use InteractsWithMedia;
    protected $fillable = [
        'name',
        'dpi',
        'gender',
        'email',
        'birthday',
        'phone'
    ];

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }
}
