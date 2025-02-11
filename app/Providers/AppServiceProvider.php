<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        FilamentView::registerRenderHook('panels::body.end',
            static fn(): string => Blade::render("@vite('resources/js/app.js')"));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Table::configureUsing(static function (Table $table): void {
            $table
                ->emptyStateHeading('No data yet')
                ->defaultPaginationPageOption(10)
                ->paginated([10, 25, 50, 100])
                ->extremePaginationLinks()
                ->defaultSort('created_at', 'desc');
        });
    }
}
