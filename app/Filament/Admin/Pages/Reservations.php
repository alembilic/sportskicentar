<?php

namespace App\Filament\Admin\Pages;

use App\Models\Field;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class Reservations extends Page
{
    protected static ?string $title = 'Rezervacije';
    public static ?string $label = 'Rezervaciju';
    public Collection|null $fields;
    public int $activeTab;
    public int $duration;
    public string $fieldName;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.admin.pages.reservations';

    public function mount()
    {
        $this->fields = Field::get();

        if (request()->input('field')) {
            $this->activeTab = intval(request()->input('field'));
            $this->duration = $this->fields->where('id', request()->input('field'))->first()->duration;
            $this->fieldName = $this->fields->where('id', request()->input('field'))->first()->name;

        } else if($this->fields->first()) {
            $this->activeTab = $this->fields->first()->id;
            $this->duration = $this->fields->first()->duration;
            $this->fieldName = $this->fields->first()->name;
        }
    }

    public function getTitle(): string
    {
        return '';
    }
}
