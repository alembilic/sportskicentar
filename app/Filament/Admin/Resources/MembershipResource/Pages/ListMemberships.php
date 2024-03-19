<?php

namespace App\Filament\Admin\Resources\MembershipResource\Pages;

use App\Filament\Admin\Resources\MembershipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
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
}
