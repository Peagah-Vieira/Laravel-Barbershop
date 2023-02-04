<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use App\Models\Category;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Buildix\Timex\Traits\TimexTrait;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;

class EventResource extends Resource
{   
    use TimexTrait;
    
    protected static ?string $recordTitleAttribute = 'subject';
    
    protected $chosenStartTime;

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->subject;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Número' => $record->number,
            'Data' => Carbon::parse($record->start)->format('d-m-Y'),
            'Horário' => Carbon::parse($record->startTime)->format('H-i')
        ];
    }

    public static function getCategoryModel(): string
    {
        return Category::class;
    }

    public static function getModel(): string
    {
        return config('timex.models.event');
    }

    public static function getModelLabel(): string
    {
        return trans('timex::timex.model.label');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('timex::timex.model.pluralLabel');
    }

    public static function getSlug(): string
    {
        return config('timex.resources.slug');
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('timex.pages.group');
    }

    protected static function getNavigationSort(): ?int
    {
        return config('timex.resources.sort',1);
    }

    protected static function getNavigationIcon(): string
    {
        return config('timex.resources.icon');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        if (!config('timex.resources.shouldRegisterNavigation')){
            return false;
        }
        if (!static::canViewAny()){
            return false;
        }

        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('organizer'),
                TextInput::make('subject')
                    ->label(trans('timex::timex.event.subject'))
                    ->placeholder('John Doe')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('number')
                    ->label('Número')
                    ->placeholder('99843-8864')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->label(trans('timex::timex.event.body'))
                    ->placeholder('Chegarei atrasado')
                    ->columnSpanFull(),
                Select::make('participants')
                    ->label(trans('timex::timex.event.participants'))
                    ->options(function (){
                        return self::getUserModel()::all()
                            ->pluck(self::getUserModelColumn('name'),self::getUserModelColumn('id'));
                    })
                    ->multiple()->columnSpanFull()->hidden(!in_array('participants',\Schema::getColumnListing(self::getEventTableName()))),
                Select::make('category')
                    ->label(trans('timex::timex.event.category'))
                    ->columnSpanFull()
                    ->searchable()
                    ->preload()
                    ->options(function (){
                        return self::isCategoryModelEnabled() ? self::getCategoryModel()::all()
                            ->pluck(self::getCategoryModelColumn('value'),self::getCategoryModelColumn('key'))
                            : config('timex.categories.labels');
                    })
                    ->columnSpanFull(),
                    Grid::make(3)->schema([
                        DatePicker::make('start')
                            ->label(trans('timex::timex.event.start'))
                            ->columnSpan(function (){
                                return config('timex.resources.isStartEndHidden',false) ? 'full' : 2;
                            })
                            ->inlineLabel()
                            ->default(today())
                            ->minDate(today())
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($get,$set,$state){
                                if ($get('end') < $state){
                                    $set('end',$state);
                                }
                            })
                            ->extraAttributes([
                                'class' => '-ml-2'
                            ])
                            ->firstDayOfWeek(config('timex.week.start')),
                        TimePicker::make('startTime')
                            ->hidden(config('timex.resources.isStartEndHidden',false))
                            ->withoutSeconds()
                            ->disableLabel()
                            ->required()
                            ->default(now()->setMinutes(0)->addHour())
                            ->reactive()
                            ->extraAttributes([
                                'class' => '-ml-2'
                            ])
                            ->afterStateUpdated(function ($set,$state){
                                $set('endTime',Carbon::parse($state)->addMinutes(30));
                            })
                            ->disabled(function ($get){
                                return $get('isAllDay');
                            }),
                        DatePicker::make('end')
                            ->label(trans('timex::timex.event.end'))
                            ->inlineLabel()
                            ->columnSpan(function (){
                                return config('timex.resources.isStartEndHidden',false) ? 'full' : 2;
                            })
                            ->default(today())
                            ->minDate(today())
                            ->reactive()
                            ->extraAttributes([
                                'class' => '-ml-2'
                            ])
                            ->firstDayOfWeek(config('timex.week.start')),
                        TimePicker::make('endTime')
                            ->hidden(config('timex.resources.isStartEndHidden',false))
                            ->withoutSeconds()
                            ->disableLabel()
                            ->reactive()
                            ->extraAttributes([
                                'class' => '-ml-2'
                            ])
                            ->default(now()->setMinutes(0)->addHour()->addMinutes(30))
                            ->disabled(function ($get){
                                return $get('isAllDay');
                            }),
                        ]),
            ]);
    }
    
    public static function getCreateEditForm(): array
    {
        return [
            Grid::make(3)->schema([
                Card::make([
                    TextInput::make('subject')
                        ->label(trans('timex::timex.event.subject'))
                        ->placeholder('John Doe')
                        ->required(),
                    TextInput::make('number')
                        ->label('Número')
                        ->placeholder('998438864')
                        ->required(),
                    Textarea::make('body')
                        ->label(trans('timex::timex.event.body'))
                        ->placeholder('Chegarei atrasado'),
                ])->columnSpan(2),
                Card::make([
                    Grid::make(3)->schema([
                        DatePicker::make('start')
                            ->label(trans('timex::timex.event.start'))
                            ->inlineLabel()
                            ->columnSpan(function (){
                                return config('timex.resources.isStartEndHidden',false) ? 'full' : 2;
                            })
                            ->default(today())
                            ->minDate(today())
                            ->firstDayOfWeek(config('timex.week.start')),
                        TimePicker::make('startTime')
                            ->hidden(config('timex.resources.isStartEndHidden',false))
                            ->withoutSeconds()
                            ->disableLabel()
                            ->default(now()->setMinutes(0)->addHour())
                            ->reactive()
                            ->afterStateUpdated(function ($set,$state){
                                $set('endTime',Carbon::parse($state)->addMinutes(30));
                            }),
                        DatePicker::make('end')
                            ->label(trans('timex::timex.event.end'))
                            ->inlineLabel()
                            ->columnSpan(function (){
                                return config('timex.resources.isStartEndHidden',false) ? 'full' : 2;
                            })
                            ->default(today())
                            ->minDate(today())
                            ->firstDayOfWeek(config('timex.week.start')),
                        TimePicker::make('endTime')
                            ->hidden(config('timex.resources.isStartEndHidden',false))
                            ->withoutSeconds()
                            ->disableLabel()
                            ->reactive()
                            ->default(now()->setMinutes(0)->addHour()->addMinutes(30)),
                        Select::make('participants')
                            ->label(trans('timex::timex.event.participants'))
                            ->options(function (){
                                return self::getUserModel()::all()
                                    ->pluck(self::getUserModelColumn('name'),self::getUserModelColumn('id'));
                            })
                            ->multiple()->columnSpanFull()->hidden(!in_array('participants',\Schema::getColumnListing(self::getEventTableName()))),
                        Select::make('category')
                            ->label(trans('timex::timex.event.category'))
                            ->columnSpanFull()
                            ->disablePlaceholderSelection()
                            ->options(function (){
                                return self::isCategoryModelEnabled() ? self::getCategoryModel()::all()
                                    ->pluck(self::getCategoryModelColumn('value'),self::getCategoryModelColumn('key'))
                                    : config('timex.categories.labels');
                            })
                    ]),
                ])->columnSpan(1),
            ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->label('Nome'),
                BadgeColumn::make('number')
                    ->label('Número')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('body')
                    ->label(trans('timex::timex.event.body'))
                    ->wrap()
                    ->limit(100),
                BadgeColumn::make('category')
                    ->label(trans('timex::timex.event.category'))
                    ->enum(config('timex.categories.labels'))
                    ->formatStateUsing(function ($record){
                        if (\Str::isUuid($record->category)){
                            return self::getCategoryModel() == null ? "" : self::getCategoryModel()::findOrFail($record->category)->getAttributes()[self::getCategoryModelColumn('value')];
                        }else{
                            return config('timex.categories.labels')[$record->category] ?? "";
                        }
                    })
                    ->color(function ($record){
                        if (\Str::isUuid($record->category)){
                            return self::getCategoryModel() == null ? "primary" :self::getCategoryModel()::findOrFail($record->category)->getAttributes()[self::getCategoryModelColumn('color')];
                        }else{
                            return config('timex.categories.colors')[$record->category] ?? "primary";
                        }
                    }),
                TextColumn::make('start')
                    ->label(trans('timex::timex.event.start'))
                    ->date()
                    ->description(fn($record) => $record->startTime),
                TextColumn::make('end')
                    ->label(trans('timex::timex.event.end'))
                    ->date()
                    ->description(fn($record)=> $record->endTime),
            ])->defaultSort('start')
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
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }    
}
