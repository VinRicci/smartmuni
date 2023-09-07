<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {  
        $data['balance'] = $data['total'];
        // $data['key'] = self::$orderService->setAKey($data['key']);
        return $data;
    }

}
