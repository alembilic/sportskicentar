<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MembershipResource\Pages;
use App\Filament\Admin\Resources\MembershipResource\RelationManagers;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\Player;
use Carbon\Carbon;
use Closure;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;
    public static ?string $label = 'Članarinu';
    public static ?string $breadcrumb = 'Članarina';
    public static ?string $pluralModelLabel = 'Članarine';

    protected static ?string $navigationIcon = 'tabler-report-money';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('player_id')
                    ->prefixIcon('heroicon-s-user')
                    ->relationship('player', 'full_name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->afterStateHydrated(function (Set $set, Get $get) {
                        $player = Player::with('membershipType')->where('id', $get('player_id'))->first();
                        if ($player) {
                            $set('price', $player->membershipType->price);
                            $set('membership_type_id', $player->membershipType->id);
                            $set('membership_type', $player->membershipType->name);
                        }
                    })
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $player = Player::with('membershipType')->where('id', $get('player_id'))->first();
                        if ($player) {
                            $set('price', $player->membershipType->price);
                            $set('membership_type_id', $player->membershipType->id);
                        }
                    })
                    ->live(),
                Forms\Components\DatePicker::make('valid_for')
                    ->native(false)
                    ->required()
                    ->prefixIcon('heroicon-s-calendar-days'),

//                Flatpickr::make('valid_for')
//                    ->allowInput(false)
//                    ->monthSelect()
//                    ->dateFormat('Y-m-d')
//                    ->default(Carbon::now()->toISOString())
//                    ->required()
//                    ->rules([
//                        function (\Filament\Forms\Get $get) {
//                            return function (string $attribute, $value, Closure $fail) use ($get) {
//                                $membership = Membership::where('player_id', $get('player_id'))
//                                    ->where('valid_for', Carbon::make($value)->firstOfMonth()->format('Y-m-d'))
//                                    ->first();
//
//                                if ($membership) {
//                                    $fail('Record with this value exists.');
//                                }
//                            };
//                        },
//                    ])
//                    ->maxDate(Carbon::now()->addMonth()),

                Forms\Components\Select::make('membership_type_id')
                    ->prefixIcon('heroicon-s-currency-dollar')
                    ->relationship('membershipType', 'full_name')
                    ->native(false)
                    ->required(),
                Forms\Components\Toggle::make('paid')->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('player.full_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_for')
                    ->sortable(),
                Tables\Columns\TextColumn::make('membershipType.name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('paid')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('BAM')
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
            'index' => Pages\ListMemberships::route('/'),
            'create' => Pages\CreateMembership::route('/create'),
            'edit' => Pages\EditMembership::route('/{record}/edit'),
        ];
    }
}
