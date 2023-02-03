<?php

namespace App\Filament\Resources\EventResource\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Buildix\Timex\Traits\TimexTrait;
use App\Filament\Resources\EventResource;

class ListEvents extends ListRecords
{
    use TimexTrait;
    protected static string $resource = EventResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        if (in_array('participants',\Schema::getColumnListing(self::getEventTableName()))){
            return parent::getTableQuery()
                ->where('organizer','=',\Auth::id())
                ->orWhereJsonContains('participants', \Auth::id());
        }else{
            return parent::getTableQuery();
        }
    }
}
