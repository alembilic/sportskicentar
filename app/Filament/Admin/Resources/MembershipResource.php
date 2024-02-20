<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MembershipResource\Pages;
use App\Filament\Admin\Resources\MembershipResource\RelationManagers;
use App\Models\Membership;
use Carbon\Carbon;
use Closure;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('player_id')
                    ->relationship('player', 'first_name')
                    ->required(),
                Forms\Components\Select::make('membership_type_id')
                    ->relationship('membershipType', 'name')
                    ->required(),
//                Forms\Components\TextInput::make('field')
//                    ->required(),
                Flatpickr::make('valid_for')
                    ->allowInput(false)
                    ->monthSelect()
                    ->dateFormat('Y-m-d')
                    ->default(Carbon::now()->toISOString())
                    ->required()
                    ->rules([
                        function (\Filament\Forms\Get $get) {
                            return function (string $attribute, $value, Closure $fail) use ($get) {
                                $membership = Membership::where('player_id', $get('player_id'))
                                    ->where('valid_for', Carbon::make($value)->firstOfMonth()->format('Y-m-d'))
                                    ->first();

                                if ($membership) {
                                    $fail('Record with this value exists.');
                                }
                            };
                        },
                    ])
                    ->maxDate(Carbon::now()->addMonth()),
                Forms\Components\Toggle::make('paid'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('player.first_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('membershipType.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_for')
                    ->sortable(),
                Tables\Columns\IconColumn::make('paid')
                    ->boolean(),
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
