<?php

namespace App\Filament\Admin\Resources\PlayerResource\Pages;

use App\Filament\Admin\Resources\PlayerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()->label('Excel')->exports([
                ExcelExport::make('table')->fromTable()->except('avatar'),
            ]),
            Actions\CreateAction::make(),
        ];
    }
}
