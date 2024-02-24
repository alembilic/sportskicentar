<?php

namespace App\Filament\Admin\Resources\CoachResource\Pages;

use App\Filament\Admin\Resources\CoachResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoach extends EditRecord
{
    protected static string $resource = CoachResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
