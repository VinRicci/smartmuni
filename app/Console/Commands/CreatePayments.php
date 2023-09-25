<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Residence;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class CreatePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $all_residences = Residence::all();
        foreach ($all_residences as $residence) {
            $services = $residence->services();
            foreach ($services as $service) {
                $new_payment = new Payment;
                $new_payment->amount = 0;
                $new_payment->description = "Pago automatizado de servicios cada mes";
                $new_payment->payment_date = Date::now();
                $new_payment->user_id = 1;
                $new_payment->service_id = $service->id;
                $new_payment->status = "por pagar";
                $new_payment->residence_id = $residence->id;
                $new_payment->total = $service->cost;
                $new_payment->balance = $service->cost;
                $new_payment->save();
            }
        }
    }
}
