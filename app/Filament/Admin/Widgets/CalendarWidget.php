<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Reservation;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public string|null|\Illuminate\Database\Eloquent\Model $model = Reservation::class;
    public $field;
    public $duration;

    public function fetchEvents(array $fetchInfo): array
    {
        // You can use $fetchInfo to filter events by date.
        // This method should return an array of event-like objects. See: https://github.com/saade/filament-fullcalendar/blob/3.x/#returning-events
        // You can also return an array of EventData objects. See: https://github.com/saade/filament-fullcalendar/blob/3.x/#the-eventdata-class
        return Reservation::where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->where('field_id', $this->field)
            ->get()
            ->map(function (Reservation $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->name,
                    'start' => $task->start,
                    'end' => $task->end,
                ];
            })
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),

            Grid::make()
                ->schema([
                    DateTimePicker::make('start')
                        ->afterStateUpdated(function (Set $set, Get $get) {
                            $set('end', Carbon::create($get('start'))->addMinutes($this->duration)->format('Y-m-d H:i:s'));
                        })
                        ->live(),
                    DateTimePicker::make('end')
                        ->readOnly(),
                    Hidden::make('field_id')
                        ->default($this->field)
                ]),

            Textarea::make('notes'),
        ];
    }

    public static function canView(): bool
    {
        return false;
    }
}
