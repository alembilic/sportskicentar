<?php

namespace App\Filament\Admin\Resources\MembershipTypeResource\Pages;

use App\Filament\Admin\Resources\MembershipTypeResource;
use App\Models\MembershipType;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;

class ListMembershipTypes extends ListRecords
{
    protected static string $resource = MembershipTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->model(MembershipType::class)
                ->form([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(50),
                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->maxValue(1000)
                        ->suffix('KM'),
                ]),
        ];
    }
}
