<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PlayerResource\Pages;
use App\Filament\Admin\Resources\PlayerResource\RelationManagers;
use App\Models\Player;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;
    public static ?string $label = 'Igrača';
    public static ?string $breadcrumb = 'Igrač';
    public static ?string $pluralModelLabel = 'Igrači';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make(__('Primary info'))
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
                                ])
                                    ->extraAttributes(['class' => 'no-border'])
                                    ->columnSpan(1)->columns(1),

                                Section::make([
                                    Forms\Components\TextInput::make('first_name')->required()->maxLength(50),
                                    Forms\Components\TextInput::make('last_name')->required()->maxLength(50),
                                    DatePicker::make('date_of_birth')
                                        ->native(false)
                                        ->required()
                                        ->prefixIcon('heroicon-s-calendar-days')
                                        ->maxDate(today()),
                                    Forms\Components\Select::make('membership_type_id')
                                        ->relationship('membershipType', 'full_name')
                                        ->required()
                                        ->native(false),
                                    Forms\Components\Select::make('selection_id')
                                        ->relationship('selection', 'name')
                                        ->required()
                                        ->native(false),
                                    Forms\Components\Select::make('gear_size')
                                        ->relationship('gearSize', 'value')
                                        ->native(false),
                                ])
                                    ->extraAttributes(['class' => 'no-border'])
                                    ->columnSpan(2)->columns(),
                            ])->columns([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 3,
                            ]),
                        Tabs\Tab::make(__('Additional'))
                            ->schema([
                                Forms\Components\TextInput::make('height')
                                    ->mask('999,9')
                                    ->suffix('cm')
                                    ->numeric(),
                                Forms\Components\TextInput::make('weight')
                                    ->mask('999,9')
                                    ->suffix('kg')
                                    ->numeric(),
                                Forms\Components\TextInput::make('number_on_jersey')
                                    ->numeric()
                                    ->maxValue(100),
                                Forms\Components\Select::make('dominant_leg')
                                    ->relationship('dominantLeg', 'value')
                                    ->native(false),

                                Forms\Components\DatePicker::make('date_joined')
                                    ->maxDate(today())
                                    ->native(false)
                                    ->prefixIcon('heroicon-s-calendar-days'),
                                Forms\Components\DatePicker::make('date_left')
                                    ->native(false)
                                    ->prefixIcon('heroicon-s-calendar-days'),
                                Forms\Components\Toggle::make('is_captain')
                                    ->inline(false)->columnSpan(2),

                                Forms\Components\TextInput::make('place_of_birth')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('jmb')
                                    ->maxLength(13),
                                Forms\Components\Toggle::make('is_foreigner')
                                    ->inline(false),

                                Forms\Components\Textarea::make('notes')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                            ])->columns([
                                'sm' => 1,
                                'md' => 1,
                                'xl' => 4,
                                '2xl' => 4,
                            ]),
                        Tabs\Tab::make(__('Contact'))
                            ->schema([
                                Forms\Components\TextInput::make('address')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('phone_number')
                                    ->tel()
                                    ->maxLength(16),
                                Forms\Components\TextInput::make('phone_number_secondary')
                                    ->tel()
                                    ->maxLength(16),
                            ])->columns(),
                        Tabs\Tab::make(__('Education'))
                            ->schema([
                                Forms\Components\Select::make('level_of_education')
                                    ->relationship('educationLevel', 'value')
                                    ->native(false),
                                Forms\Components\Select::make('education_institution')
                                    ->relationship('educationInstitution', 'value')
                                    ->native(false),
                                Forms\Components\Select::make('education_status')
                                    ->relationship('educationStatus', 'value')
                                    ->native(false),
                            ])->columns(),
                        Tabs\Tab::make(__('Health'))
                            ->schema([
                                Forms\Components\Toggle::make('is_sick')->inline(false),
                                Forms\Components\Textarea::make('health_notes')
                                    ->maxLength(65535)
                                    ->columnSpan(3),
                            ])->columns(4),
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('membershipType.full_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('selection.name')
                    ->searchable()
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


//                Tables\Columns\TextColumn::make('date_joined')
//                    ->date()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('date_left')
//                    ->date()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('height')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('weight')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('number_on_jersey')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\IconColumn::make('is_captain')
//                    ->boolean(),
//                Tables\Columns\IconColumn::make('is_foreigner')
//                    ->boolean(),
//                Tables\Columns\TextColumn::make('place_of_birth')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('jmb')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('address')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('email')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('phone_number')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('phone_number_secondary')
//                    ->searchable(),
//                Tables\Columns\IconColumn::make('is_sick')
//                    ->boolean(),
//                Tables\Columns\TextColumn::make('dominant_leg')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('gear_size')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('level_of_education')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('education_status')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('education_institution')
//                    ->numeric()
//                    ->sortable(),
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
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }
}
