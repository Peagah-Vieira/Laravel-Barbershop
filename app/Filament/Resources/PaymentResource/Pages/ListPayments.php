<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use Filament\Pages\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PaymentResource;
use App\Filament\Resources\PaymentResource\Widgets\PaymentStatsOverview;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Criar pagamento'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PaymentStatsOverview::class,
        ];
    }
}
