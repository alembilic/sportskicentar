<?php

namespace App\Filament\Admin\Resources\MembershipResource\Pages;

use App\Filament\Admin\Resources\MembershipResource;
use App\Filament\Admin\Widgets\MembershipsWidget;
use App\Models\Player;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListMemberships extends ListRecords
{
    protected static string $resource = MembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Excel')->exports([
                ExcelExport::make('table')->fromTable(),
            ]),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        $first = Player::whereDoesntHave('memberships', function ($q) {
            return $q->whereMonth('valid_for', Carbon::now()->subMonths(2)->month)
                ->where('paid', 1);
        })->count();

        $second = Player::whereDoesntHave('memberships', function ($q) {
            return $q->whereMonth('valid_for', Carbon::now()->subMonths(1)->month)
                ->where('paid', 1);
        })->count();

        $third = Player::whereDoesntHave('memberships', function ($q) {
            return $q->whereMonth('valid_for', Carbon::now()->month)
                ->where('paid', 1);
        })->count();

        $total = Player::whereNull('date_left')->count();

        return [
            MembershipsWidget::make([
                'title' => 'Neplaćene članarine',
                'first' => $first,
                'second' => $second,
                'third' => $third,
                'total' => $total
            ]),
        ];
    }

    #[On('updateTableFilters')]
    public function updateFilters(array $filters): void
    {
        $this->filters = $filters;

        $this->resetTable();
    }
}
