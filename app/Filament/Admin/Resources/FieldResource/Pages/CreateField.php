<?php

namespace App\Filament\Admin\Resources\FieldResource\Pages;

use App\Filament\Admin\Resources\FieldResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateField extends CreateRecord
{
    protected static string $resource = FieldResource::class;
}
