<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FieldResource\Pages;
use App\Filament\Admin\Resources\FieldResource\RelationManagers;
use App\Models\Field;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FieldResource extends Resource
{
    protected static ?string $model = Field::class;
    public static ?string $label = 'Teren';
    public static ?string $breadcrumb = 'Teren';
    public static ?string $pluralModelLabel = 'Tereni';

    protected static ?string $navigationIcon = 'tabler-soccer-field';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    SpatieMediaLibraryFileUpload::make('avatar')
                        ->collection('avatars')
                        ->imagePreviewHeight('400')
                        ->imageEditor()
                        ->image()
                        ->imageEditorMode(2),
                ])->columnSpan(1)->columns(1),

                Section::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(50),
                    Forms\Components\TextInput::make('address')
                        ->required()
                        ->maxLength(50),
                    Forms\Components\TextInput::make('duration')
                        ->required()
                        ->numeric()
                        ->maxValue(1000)
                        ->suffix('minutes'),
                    Forms\Components\TextInput::make('price_per_duration')
                        ->numeric()
                        ->required()
                        ->maxValue(1000)
                        ->suffix('KM'),
                    Forms\Components\Textarea::make('description')
                        ->maxLength(1000)
                        ->columnSpan(2),
                ])->columnSpan(2)->columns(2),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('avatars')
                    ->conversion('thumb')
                    ->height(50),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_per_duration')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
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
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
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
            'index' => Pages\ListFields::route('/'),
            'create' => Pages\CreateField::route('/create'),
            'edit' => Pages\EditField::route('/{record}/edit'),
        ];
    }
}
