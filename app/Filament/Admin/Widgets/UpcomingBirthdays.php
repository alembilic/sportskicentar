<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\PlayerResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class UpcomingBirthdays extends BaseWidget
{
    protected static ?string $heading = "Nadolazeći rođendani";

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PlayerResource::getEloquentQuery()
                    ->select(
                        '*',
                        DB::raw('DATEDIFF(
                            DATE_FORMAT(
                                IF(date_of_birth >= CURDATE(), date_of_birth, DATE_ADD(date_of_birth, INTERVAL YEAR(CURDATE()) - YEAR(date_of_birth) + 1 YEAR)),
                                CONCAT(YEAR(CURDATE()), "-", MONTH(date_of_birth), "-", DAY(date_of_birth))
                            ),
                            CURDATE()
                        ) AS days_until_birthday'
                        )
                    )
                    ->whereNotNull('date_of_birth')
                    ->whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') > ?", [now()->format('m-d')])
                    ->orderBy('days_until_birthday')
            )
            ->columns([
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date(),
                Tables\Columns\TextColumn::make('days_until_birthday'),
            ]);
    }
}
