<?php

namespace App\Models;
use App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;
    protected $table = "payment_history";
    protected $fillable = [
        'old_data',
        'new_data',
        'description',
        'payment_date',
        'amount',
        'responsable',
        'is_fix'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
