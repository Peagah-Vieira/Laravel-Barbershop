<?php

namespace App\Models;

use Buildix\Timex\Models\Event as BaseEvent;
use Buildix\Timex\Traits\TimexTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends BaseEvent
{
    use HasUuids, TimexTrait, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
        'isAllDay' => 'boolean',
        'participants' => 'array',
        'attachments' => 'array',
    ];

    public function getTable()
    {
        return config('timex.tables.event.name', "timex_events");
    }

    public function __construct(array $attributes = [])
    {
        $attributes['organizer'] = \Auth::id();

        parent::__construct($attributes);

    }

    public function category()
    {
        return $this->hasOne(self::getCategoryModel());
    }
}
