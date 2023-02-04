<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $breadcrumb = 'Categorias';

    protected static ?string $label = 'Categorias';

    protected static ?string $slug = 'categorias';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Categorias';

    protected static ?string $navigationGroup = 'Recursos';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome da Categoria')
                        ->placeholder('Corte Estiloso')
                        ->required(),
                    Forms\Components\TextInput::make('amount')
                        ->label('Valor')
                        ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                            ->money(prefix: 'R$', isSigned: false)
                        )
                        ->required(),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nome da Categoria')
                ->searchable()
                ->sortable(),
            Tables\Columns\BadgeColumn::make('amount')
                ->label('Valor')
                ->prefix('R$')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Data de Criação')
                ->searchable()
                ->sortable()
                ->date()
                ->description(fn($record) => Carbon::parse($record->created_at)->format('H:i:s')),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Data de Atualização')
                ->searchable()
                ->sortable()
                ->date()
                ->description(fn($record) => Carbon::parse($record->updated_at)->format('H:i:s')),
            ])->defaultSort('amount')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }    
}
