<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SelectionResource\Pages;
use App\Filament\Admin\Resources\SelectionResource\RelationManagers;
use App\Models\Codebook;
use App\Models\Selection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SelectionResource extends Resource
{
    protected static ?string $model = Selection::class;
    public static ?string $label = 'Selekciju';
    public static ?string $breadcrumb = 'Selekcija';
    public static ?string $pluralModelLabel = 'Selekcije';

    protected static ?string $navigationGroup = 'Postavke';

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(191),
                    Forms\Components\Select::make('coach_id')
                        ->relationship('coach', 'full_name')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'value')
                        ->createOptionForm([
                            Forms\Components\TextInput::make('value')
                                ->required(),
                            Forms\Components\Hidden::make('code_type')
                                ->default(Codebook::CATEGORY)
                        ])
                        ->required(),
                    Forms\Components\Select::make('league_id')
                        ->relationship('league', 'value')
                        ->createOptionForm([
                            Forms\Components\TextInput::make('value')
                                ->required(),
                            Forms\Components\Hidden::make('code_type')
                                ->default(Codebook::LEAGUE)
                        ])
                        ->required(),
                    Forms\Components\ColorPicker::make('color'),
                ])->columns()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coach.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('league.value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ColorColumn::make('color'),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation()
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
            'index' => Pages\ListSelections::route('/'),
            'create' => Pages\CreateSelection::route('/create'),
            'edit' => Pages\EditSelection::route('/{record}/edit'),
        ];
    }
}
