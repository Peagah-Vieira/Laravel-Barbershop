<?php

namespace App\Filament\Resources\PaymentResource\Widgets;

use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PaymentStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Quantidade de Pagamentos', Payment::all()->count()),
            Card::make('Valor dos Pagamentos', 'R$' . ' ' . Payment::all()->sum('category.amount')),
            Card::make('Ultimos Pagamentos (7 dias)', 'R$' . ' ' . Payment::all()->where('created_at', '>=', Carbon::now()->subDays(7))->sum('category.amount')),
        ];
    }
}
