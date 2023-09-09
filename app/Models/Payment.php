<?php

namespace App\Models;
use App\Models\Service;
use App\Models\Residence;
use App\Models\PaymentHistory;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'description',
        'payment_date',
        'user_id',
        'service_id',
        'status',
        'residence_id',
        'total',
        'balance'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    public function paymentHistory()
    {
        return $this->hasMany(PaymentHistory::class, 'payment_id');
    }
}
