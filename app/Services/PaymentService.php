<?php

namespace App\Services;

use App\Models\Payment;

class PaymentService
{
    public function updateBalance($paymentId): string
    {
        $payment = Payment::find($paymentId);
        $payment_history = $payment->paymentHistory;
        $total_payed = 0;
        $payment->balance = 0;
        foreach($payment_history as $pay)
        {
            if ($pay->is_fix == 0) {
                $total_payed += $pay->amount;
            } else {
                $total_payed -= $pay->amount;
            }
        }
        $payment->balance = $payment->total - $total_payed;
        if ($payment->balance <= 0) {
            $payment->balance = 0;
            $payment->status = 'cancelada';
        }
        $payment->save();
        return strval($payment->balance);
    }
}