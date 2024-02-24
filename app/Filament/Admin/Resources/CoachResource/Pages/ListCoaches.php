<?php

namespace App\Filament\Admin\Resources\CoachResource\Pages;

use App\Filament\Admin\Resources\CoachResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoaches extends ListRecords
{
    protected static string $resource = CoachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
