<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Reservation;
use Carbon\Carbon;
use Closure;
use Saade\FilamentFullCalendar\Actions;
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
    public int $field;
    public int $duration;
    public string $fieldName;

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
                        ->required()
                        ->prefixIcon('heroicon-s-calendar-days')
                        ->displayFormat('d. F Y H:i')
                        ->seconds(false)
                        ->minutesStep(15)
                        ->native(false)
                        ->rules([
                            function (\Filament\Forms\Get $get) {
                                return function (string $attribute, $value, Closure $fail) use ($get) {
                                    $reservation = Reservation::isAvailable(Carbon::make($get('start')), Carbon::create($get('start'))->addMinutes($this->duration))
                                        ->where('field_id', $this->field)
                                        ->first();
                                    if ($reservation) $fail('Postoji termin u odabrano vrijeme.');
                                };
                            },
                        ])
                        ->live(debounce: 1500),
                    DateTimePicker::make('end')
                        ->prefixIcon('heroicon-s-calendar-days')
                        ->displayFormat('d. F Y H:i')
                        ->seconds(false)
                        ->native(false)
                        ->readOnly(),
                    Hidden::make('field_id')
                        ->default($this->field)
                ]),

            Textarea::make('notes'),
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading('Dodaj rezervaciju za ' . $this->fieldName)
        ];
    }

    protected function viewAction(): \Filament\Actions\Action
    {
        return Actions\EditAction::make()
            ->modalHeading('Uredi rezervaciju za ' . $this->fieldName);
    }

    public static function canView(): bool
    {
        return false;
    }
}
