<?php

namespace App\Filament\Admin\Widgets;

use Carbon\Carbon;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class MembershipsWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.memberships-widget';
    public string $title;
    public $first;
    public $second;
    public $third;
    public $total;
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return request()->route()->getName() !== 'filament.admin.pages.dashboard';
    }

    #[On('set-filter')]
    public function setFilter($subMonths = 0)
    {
        redirect(route('filament.admin.resources.memberships.index') . "?tableFilters[valid_for][month]=" . Carbon::now()->subMonths($subMonths)->format('Y-m') . "&tableFilters[Plaćeno][value]=0");
    }
}
