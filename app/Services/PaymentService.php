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
        // $order = $this->orderRepository->get($orderId)[0];
        
        $payment->balance = 0;
        
        // $paymentsOrder = $this->orderRepository->getOrders($orderId);
        // $totalPayed = 0;
        foreach($payment_history as $pay)
        {
            $total_payed += $pay->amount;
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