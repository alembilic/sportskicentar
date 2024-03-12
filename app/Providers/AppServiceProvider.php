<?php

namespace App\Providers;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        $this->autoTranslateLabels();
        Table::configureUsing(function (Table $table): void {
            Table::$defaultDateDisplayFormat = 'd.m.Y';
            Table::$defaultDateTimeDisplayFormat = 'd.m.Y H:i:s';
        });
        Select::configureUsing(function (Select $select): void {
            $select->native(false);
        });
        DatePicker::configureUsing(function (Select $select): void {
            $select->native(false);
        });
    }

    private function autoTranslateLabels()
    {
        $this->translateLabels([
            Field::class,
            BaseFilter::class,
            Placeholder::class,
            Column::class,
//            Action::class,
        ]);
    }

    private function translateLabels(array $components = [])
    {
        foreach($components as $component) {
            $component::configureUsing(function ($c): void {
                $c->translateLabel();
            });
        }
    }
}
