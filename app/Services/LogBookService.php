<?php

namespace App\Services;

use App\Models\logbook;
use App\Models\Payment;
use App\Models\PaymentHistory;

class LogBookService
{
    public function insertALogBook($payment_history_id, $payment_id): string
    {
        $payment = Payment::find($payment_id);
        $payment_history = PaymentHistory::find($payment_history_id);
        $log_book_entry = new logbook();
        $log_book_entry->amount = $payment_history->amount;
        $log_book_entry->description = $payment_history->description;
        $log_book_entry->created_at = $payment_history->payment_date;
        // $log_book_entry->total = $payment->total;
        // $log_book_entry->balance = $payment->balance;
        $log_book_entry->responsable = $payment_history->responsable;
        $log_book_entry->residence_id = $payment->residence->id;
        $log_book_entry->service_id = $payment->service->id;
        $log_book_entry->save();
        return strval($log_book_entry->balance);
    }
}