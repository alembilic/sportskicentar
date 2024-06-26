<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PlayerResource\Pages;
use App\Filament\Admin\Resources\PlayerResource\RelationManagers;
use App\Models\Codebook;
use App\Models\Player;
use Carbon\Carbon;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

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
                                        ->required()
                                        ->maxDate(today()),
                                    Forms\Components\Select::make('membership_type_id')
                                        ->relationship('membershipType', 'full_name')
                                        ->required(),
                                    Forms\Components\Select::make('selection_id')
                                        ->relationship('selection', 'name')
                                        ->required(),
                                    Forms\Components\Select::make('gear_size')
                                        ->relationship('gearSize', 'value')
                                        ->createOptionForm([
                                            Forms\Components\TextInput::make('value')
                                                ->required(),
                                            Forms\Components\Hidden::make('code_type')
                                                ->default(Codebook::GEAR_SIZE)
                                        ]),
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
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('value')
                                            ->required(),
                                        Forms\Components\Hidden::make('code_type')
                                            ->default(Codebook::DOMINANT_LEG)
                                    ]),

                                Forms\Components\DatePicker::make('date_joined')
                                    ->maxDate(today()),
                                Forms\Components\DatePicker::make('date_left'),
                                Forms\Components\Toggle::make('is_captain')
                                    ->inline(false)
                                    ->columnSpan(2),

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
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('value')
                                            ->required(),
                                        Forms\Components\Hidden::make('code_type')
                                            ->default(Codebook::LEVEL_OF_EDUCATION)
                                    ]),
                                Forms\Components\Select::make('education_institution')
                                    ->relationship('educationInstitution', 'value')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('value')
                                            ->required(),
                                        Forms\Components\Hidden::make('code_type')
                                            ->default(Codebook::EDUCATION_INSTITUTION)
                                    ]),
                                Forms\Components\Select::make('education_status')
                                    ->relationship('educationStatus', 'value')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('value')
                                            ->required(),
                                        Forms\Components\Hidden::make('code_type')
                                            ->default(Codebook::EDUCATION_STATUS)
                                    ]),
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
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('pastThreeMemberships'))
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('avatars')
                    ->conversion('thumb')
                    ->height(50),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (Model $record): View => view(
                        'filament.tables.columns.username',
                        ['state' => $record],
                    )),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('membershipType.full_name')
                    ->searchable()
                    ->badge()
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
                Tables\Columns\TextColumn::make('place_of_birth')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('jmb')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
//                Tables\Columns\TextColumn::make('phone_number_secondary')
//                    ->searchable(),
                Tables\Columns\IconColumn::make('is_sick')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
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
                SelectFilter::make('Slekcija')
                    ->relationship('selection', 'name'),
                SelectFilter::make('Trener')
                    ->relationship('selection.coach', 'full_name'),
                SelectFilter::make('Članarina')
                    ->relationship('membershipType', 'name'),
                TernaryFilter::make('Plaćeno')
                    ->queries(
                        true: fn(Builder $query) => $query->whereHas('memberships', fn($q) => $q->where('paid', 1)),
                        false: fn(Builder $query) => $query->whereDoesntHave('memberships', fn($q) => $q->where('paid', 0)),
                        blank: fn(Builder $query) => $query,
                    ),
                Filter::make('is_featured')
                    ->form([TextInput::make('month')->label('Članarina za')->type('month')])
                    ->query(fn(Builder $query, array $data): Builder => $query->when(isset($data['month']), function ($q) use ($data) {
                        $q->whereHas('memberships', fn($q) => $q->where('valid_for', Carbon::make($data['month'])));
                    })),
                DateRangeFilter::make('date_of_birth'),
                TernaryFilter::make('is_sick'),
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
