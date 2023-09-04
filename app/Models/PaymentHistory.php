<?php

namespace App\Models;
use App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'old_data',
        'new_data',
        'description',
        'payment_date'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

}
