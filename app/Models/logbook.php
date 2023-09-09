<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logbook extends Model
{
    use HasFactory;
    protected $table = "logbook";
    protected $fillable = [
        'amount',
        'description',
        'created_at',
        // 'total',
        'responsable',
        'residence_id',
        'service_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

}
