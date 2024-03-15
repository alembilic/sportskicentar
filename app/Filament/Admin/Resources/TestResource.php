<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TestResource\Pages;
use App\Filament\Admin\Resources\TestResource\RelationManagers;
use App\Models\Codebook;
use App\Models\Test;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestResource extends Resource
{
    protected static ?string $model = Test::class;
    public static ?string $label = 'Testiranje';
    public static ?string $breadcrumb = 'Testiranje';
    public static ?string $pluralModelLabel = 'Testiranja';

    protected static ?string $navigationGroup = 'Treneri';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('player_id')
                    ->prefixIcon('heroicon-s-user')
                    ->relationship('player', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('test_type')
                    ->relationship('testType', 'value')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('value')
                            ->required(),
                        Forms\Components\Hidden::make('code_type')
                            ->default(Codebook::TEST_TYPE)
                    ]),
                Forms\Components\TextInput::make('result')
                    ->required()
                    ->maxLength(191),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('player.full_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('testType.value')
                    ->sortable(),
                Tables\Columns\TextColumn::make('result')
                    ->searchable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
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
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
        ];
    }
}
