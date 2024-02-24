<?php

namespace App\Filament\Admin\Resources\CodebookResource\Pages;

use App\Filament\Admin\Resources\CodebookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCodebook extends EditRecord
{
    protected static string $resource = CodebookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
