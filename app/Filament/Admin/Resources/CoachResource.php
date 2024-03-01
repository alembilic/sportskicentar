<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CoachResource\Pages;
use App\Filament\Admin\Resources\CoachResource\RelationManagers;
use App\Models\Coach;
use App\Models\Player;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoachResource extends Resource
{
    protected static ?string $model = Coach::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        ->imageEditorMode(2)
                        ->imageEditorAspectRatios([
                            '1:1',
                        ]),
                ])->columnSpan(1)->columns(1),

                Section::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(50),
                    Forms\Components\TextInput::make('surname')
                        ->required()
                        ->maxLength(50),
                    Forms\Components\DatePicker::make('date_of_birth')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(50),
                    Forms\Components\TextInput::make('phone_number')
                        ->tel()
                        ->maxLength(16),
                    Forms\Components\TextInput::make('address')
                        ->maxLength(50),
                    Forms\Components\Select::make('gear_size')
                        ->relationship('gearSize', 'value')
                        ->native(false)
                        ->required(),
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
                    ->height(40),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('surname')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gearSize.value')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListCoaches::route('/'),
            'create' => Pages\CreateCoach::route('/create'),
            'edit' => Pages\EditCoach::route('/{record}/edit'),
        ];
    }
}
