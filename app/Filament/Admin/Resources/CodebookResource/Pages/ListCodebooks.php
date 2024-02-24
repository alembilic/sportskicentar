<?php

namespace App\Filament\Admin\Resources\CodebookResource\Pages;

use App\Filament\Admin\Resources\CodebookResource;
use App\Models\Codebook;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCodebooks extends ListRecords
{
    protected static string $resource = CodebookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->model(Codebook::class)
                ->form([
                    Select::make('code_type')
                        ->default($this->activeTab)
                        ->disabled((bool)$this->activeTab)
                        ->required()
                        ->options(fn() => Codebook::getOptions())
                        ->native(false)
                        ->extraInputAttributes(['readonly' => true])
                        ->preload(),
                    TextInput::make('value')
                        ->required()
                        ->maxLength(50),
//                Forms\Components\Toggle::make('is_global')
//                    ->required(),
                ])
                ->mutateFormDataUsing(function (array $data): array {
                    if (!isset($data['code_type'])) $data['code_type'] = $this->activeTab;

                    return $data;
                })
        ];
    }

    public function getTabs(): array
    {
        $codebookTypes = Codebook::getOptions();
        $tabs[''] = Tab::make('All');
        foreach ($codebookTypes as $key => $value) {
            $tabs[$key] = Tab::make($value)->modifyQueryUsing(function (Builder $query) use ($key) {
                $query->where('code_type', $key);
            });
        }

        return $tabs;
    }
}
