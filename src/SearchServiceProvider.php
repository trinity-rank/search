<?php

namespace Trinityrank\Search;

use Illuminate\Support\ServiceProvider;
use Trinityrank\Search\Console\Commands\ScoutImport;
use Trinityrank\Search\Console\Commands\ScoutDelete;
use Trinityrank\Search\Console\Commands\ScoutDeleteIndex;
use Trinityrank\Search\Console\Commands\ScoutUpdateFilters;
use Blade;

class SearchServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('searchJs', function ($string) {
            return "<script src='". asset('js/search.js') ."'></script>";
        });

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ ."/config/search.php" => 'config/search.php'], "search-config");

            $this->publishes([
                __DIR__ ."/database/migrations/2022_06_29_115398_add_search_exclude_column_to_tables.php" =>
                'database/migrations/2022_06_29_115398_add_search_exclude_column_to_tables.php',
            ], "search-migration");

            // Register the command if we are using the application via the CLI
            $this->commands([
                ScoutImport::class,
                ScoutDelete::class,
                ScoutDeleteIndex::class,
                ScoutUpdateFilters::class,
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
