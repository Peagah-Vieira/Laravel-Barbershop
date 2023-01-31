<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use HusamTariq\FilamentTimePicker\Forms\Components\TimePickerField;
use App\Filament\Resources\PaymentResource\Widgets\PaymentStatsOverview;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $breadcrumb = 'Pagamentos';

    protected static ?string $label = 'Pagamentos';

    protected static ?string $slug = 'pagamentos';

    protected static ?string $recordTitleAttribute = 'Pagamentos';

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationLabel = 'Pagamentos';

    protected static ?string $navigationGroup = 'Recursos';


    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->fullname;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Valor' => $record->amount,
            'Data de Pagamento' => Carbon::parse($record->payment_date)->format('d-m-Y'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['fullname', 'amount'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('fullname')
                            ->label('Nome Completo')
                            ->placeholder('John Doe Maia')
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Valor')
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->money(prefix: 'R$', isSigned: false)
                            )
                            ->required(),
                        TimePickerField::make('payment_time')
                            ->label('Hora de Pagamento')
                            ->okLabel('Confirm')
                            ->cancelLabel('Cancel')
                            ->required(),
                        Forms\Components\DatePicker::make('payment_date')
                            ->label('Data de Pagamento')
                            ->placeholder('Jan 5, 2023')
                            ->maxDate(now())
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fullname')
                    ->label('Nome Completo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('amount')
                    ->label('Valor')
                    ->prefix('R$')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Hora de Pagamento')
                    ->searchable()
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('payment_time')
                    ->label('Data de Pagamento')
                    ->searchable()
                    ->sortable()
                    ->time()
            ])->defaultSort('id')
            ->filters([
                Tables\Filters\Filter::make('payment_date')
                    ->form([
                        Forms\Components\DatePicker::make('payment_date_from')
                            ->label('Data de Pagamento desde')
                            ->placeholder('Jan 30, 2022')
                            ->maxDate(now()),
                        Forms\Components\DatePicker::make('payment_date_until')
                            ->label('Data de Pagamento até')
                            ->placeholder('Jan 11, 2023')
                            ->maxDate(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['payment_date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('payment_date', '>=', $date), 
                            )
                            ->when(
                                $data['payment_date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('payment_date', '<=', $date), 
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['payment_date_from'] ?? null) {
                            $indicators['from'] = 'Data de Pagamento desde ' . Carbon::parse($data['payment_date_from'])->toFormattedDateString();
                        }

                        if ($data['payment_date_until'] ?? null) {
                            $indicators['until'] = 'Data de Pagamento até ' . Carbon::parse($data['payment_date_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PaymentStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
