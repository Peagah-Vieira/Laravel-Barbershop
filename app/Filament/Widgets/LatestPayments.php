<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;
use HusamTariq\FilamentTimePicker\Forms\Components\TimePickerField;

class LatestPayments extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Ultimos Pagamentos';

    protected function getTableQuery(): Builder
    {
        return Payment::latest()->where('paid', 1);
    }

    protected function getTableColumns(): array
    {
        return ([
            TextColumn::make('fullname')
                ->label('Nome Completo')
                ->searchable()
                ->sortable(),
            BadgeColumn::make('category.amount')
                ->label('Valor')
                ->prefix('R$')
                ->searchable()
                ->sortable(),
            TextColumn::make('payment_date')
                ->label('Hora de Pagamento')
                ->searchable()
                ->sortable()
                ->date(),
            TextColumn::make('payment_time')
                ->label('Data de Pagamento')
                ->time()
                ->searchable()
                ->sortable()
        ]);
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->form([
                    TextInput::make('fullname')
                        ->label('Nome Completo')
                        ->placeholder('John Doe Maia'),
                    TextInput::make('category.amount')
                        ->label('Valor'),
                    TimePickerField::make('payment_time')
                        ->label('Hora de Pagamento')
                        ->okLabel('Confirm')
                        ->cancelLabel('Cancel'),
                    DatePicker::make('payment_date')
                        ->label('Data de Pagamento')
                        ->placeholder('Jan 5, 2023')
                        ->maxDate(now()),
                ])
        ];
    }

    protected function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 5;
    }

    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }
}
