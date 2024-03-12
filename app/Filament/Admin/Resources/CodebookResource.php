<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CodebookResource\Pages;
use App\Filament\Admin\Resources\CodebookResource\RelationManagers;
use App\Models\Codebook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CodebookResource extends Resource
{
    protected static ?string $model = Codebook::class;
    public static ?string $label = 'Šifrarnik';
    public static ?string $breadcrumb = 'Šifrarnik';
    public static ?string $pluralModelLabel = 'Šifrarnici';

    protected static ?string $navigationGroup = 'Postavke';


    protected static ?string $navigationIcon = 'heroicon-c-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code_type')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->searchable()
                    ->sortable(),
//                Tables\Columns\IconColumn::make('is_global')
//                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Select::make('code_type')
//                            ->default()
                            ->required()
                            ->options(fn() => Codebook::getOptions())
                            ->native(false),
                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->maxLength(50),
                    ])
                    ->mutateRecordDataUsing(function (array $data): array {
                        $options = Codebook::getOptions();
                        $data['code_type'] = array_search($data['code_type'], $options);;

                        return $data;
                    }),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCodebooks::route('/'),
//            'create' => Pages\CreateCodebook::route('/create'),
//            'edit' => Pages\EditCodebook::route('/{record}/edit'),
        ];
    }
}
