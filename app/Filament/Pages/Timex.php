<?php

namespace App\Filament\Pages;

use Buildix\Timex\Pages\Timex as BaseTimex;
use Buildix\Timex\Events\EventItem;
use Buildix\Timex\Events\InteractWithEvents;
use Buildix\Timex\Traits\TimexTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Concerns\UsesResourceForm;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Timex extends BaseTimex
{
    use TimexTrait;
    use InteractWithEvents;
    use UsesResourceForm;

    protected static function shouldRegisterNavigation(): bool
    {
        if (!config('timex.pages.shouldRegisterNavigation')){
            return false;
        }
        if (config('timex.pages.enablePolicy',false) && \Gate::getPolicyFor(self::getModel()) && !\Gate::allows('viewAny',self::getModel())){
            return false;
        }

        return true;
    }

    protected function getHeading(): string|Htmlable
    {
        return " ";
    }

    public function monthNameChanged($data,$year)
    {
            $this->monthName = Carbon::create($data)->monthName.' '.$this->getYearFormat($data);
            $this->year = Carbon::create($data);
            $this->period = CarbonPeriod::create(Carbon::create($data)->firstOfYear(),'1 month',Carbon::create($data)->lastOfYear());
    }

    public function __construct()
    {
        $this->monthName = today()->monthName." ".today()->year;
        $this->year = today();
        $this->period = CarbonPeriod::create(Carbon::create($this->year->firstOfYear()),'1 month',$this->year->lastOfYear());

    }

    protected function getActions(): array
    {
        return [
                Action::make('openCreateModal')
                    ->label(trans('filament::resources/pages/create-record.title',
                            ['label' => Str::lower(__('timex::timex.model.label'))]))
                    ->icon(config('timex.pages.buttons.icons.createEvent'))
                    ->size('sm')
                    ->outlined(config('timex.pages.buttons.outlined'))
                    ->slideOver()
                    ->extraAttributes(['class' => '-mr-2'])
                    ->form($this->getResourceForm(2)->getSchema())
                    ->modalHeading(trans('timex::timex.model.label'))
                    ->modalWidth(config('timex.pages.modalWidth'))
                    ->action(fn(array $data) => $this->updateOrCreate($data))
                    ->modalActions([
                        Action::makeModalAction('submit')
                            ->label(trans('timex::timex.modal.submit'))
                            ->color(config('timex.pages.buttons.modal.submit.color','primary'))
                            ->outlined(config('timex.pages.buttons.modal.submit.outlined',false))
                            ->icon(config('timex.pages.buttons.modal.submit.icon.name',''))
                            ->submit(),
                        Action::makeModalAction('cancel')
                            ->label(trans('timex::timex.modal.cancel'))
                            ->color(config('timex.pages.buttons.modal.cancel.color','secondary'))
                            ->outlined(config('timex.pages.buttons.modal.cancel.outlined',false))
                            ->icon(config('timex.pages.buttons.modal.cancel.icon.name',''))
                            ->cancel(),
                    ]),
        ];
    }

    public static function getEvents(): array
    {
        $events = self::getModel()::orderBy('startTime')->get()
            ->map(function ($event){
                return EventItem::make($event->id)
                    ->body($event->body)
                    ->category($event->category)
                    ->color($event->category)
                    ->end(Carbon::create($event->end))
                    ->isAllDay($event->isAllDay)
                    ->subject($event->subject)
                    ->organizer($event->organizer)
                    ->participants($event?->participants)
                    ->start(Carbon::create($event->start))
                    ->startTime($event?->startTime);
            })->toArray();

        return collect($events)->filter(function ($event){
            return $event->organizer == \Auth::id() || in_array(\Auth::id(), $event?->participants ?? []);
        })->toArray();
    }

    public function updateOrCreate($data)
    {
        if ($data['organizer'] == null){
            $this->getModel()::query()->create([...$data,'organizer' => \Auth::id()]);
        }else{
            $this->getFormModel()::query()->find($this->getFormModel()->id)->update($data);
        }
        $this->dispatEventUpdates();
    }

    public function deleteEvent()
    {
        $this->getFormModel()->delete();
        $this->dispatEventUpdates();
    }

    public function dispatEventUpdates(): void
    {
        $this->emit('modelUpdated',['id' => $this->id]);
        $this->emit('updateWidget',['id' => $this->id]);
    }

    public function onEventClick($eventID)
    {
        $this->record = $eventID;
        $event = $this->getFormModel()->getAttributes();
        $this->mountAction('openCreateModal');

        if ($this->getFormModel()->getAttribute('organizer') !== \Auth::id()){
            $this->getMountedAction()
                ->modalContent(\view('timex::event.view',['data' => $event]))
                ->modalHeading($event['subject'])
                ->form([])
                ->modalActions([

                ]);
        }else{
            $this->getMountedActionForm()
                ->fill([
                    ...$event,
                    'participants' => self::getFormModel()?->participants,
                    'attachments' => self::getFormModel()?->attachments,
                ]);
        }
    }

    public function onDayClick($timestamp)
    {
        if (config('timex.isDayClickEnabled',true)){
            if (config('timex.isPastCreationEnabled',false)){
                $this->onCreateClick($timestamp);
            }else{
                Carbon::createFromTimestamp($timestamp)->isBefore(Carbon::today()) ? '' : $this->onCreateClick($timestamp);
            }
        }
    }

    public function onCreateClick(int | string | null $timestamp = null)
    {
        $this->mountAction('openCreateModal');
        $this->getMountedActionForm()
            ->fill([
                'startTime' => Carbon::now()->setMinutes(0)->addHour(),
                'endTime' => Carbon::now()->setMinutes(0)->addHour()->addMinutes(30),
                'start' => Carbon::createFromTimestamp(isset($timestamp) ? $timestamp : today()->timestamp),
                'end' => Carbon::createFromTimestamp(isset($timestamp) ? $timestamp : today()->timestamp)
            ]);
    }

    protected function getHeader(): ?View
    {
        return \view('timex::header.header');
    }

    public function onNextDropDownYearClick()
    {
        $this->year = $this->year->addYear();
        $this->period = CarbonPeriod::create(Carbon::create($this->year->firstOfYear()),'1 month',$this->year->lastOfYear());
    }

    public function onPrevDropDownYearClick()
    {
        $this->year = $this->year->subYear();
        $this->period = CarbonPeriod::create(Carbon::create($this->year->firstOfYear()),'1 month',$this->year->lastOfYear());
    }


    public function getYearFormat($data)
    {
        return Carbon::create($data)->year;
    }

    public function loadAttachment($file): void
    {
        $this->redirect(Storage::url($file));
    }

}
