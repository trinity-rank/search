<?php

use Trinityrank\Search\SearchController;
use Illuminate\Support\Facades\Route;
use Trinityrank\Multilanguage\Frontend\Route as RouteLang;

// Multilanguage routes - if package is installed "trinity-rank/multilanguage"
if (class_exists(RouteLang::class)) {
    RouteLang::multilanguage('laravel-search/{searchFor}', [SearchController::class, 'searchAjax'])->name('search');
    RouteLang::multilanguage('view-all/{model}/page/{page}', [SearchController::class, 'singleViewAll'])->name('single-view-all');
    RouteLang::multilanguage('view-all/{model}', [SearchController::class, 'singleViewAll'])->name('single-view-all');
    RouteLang::multilanguage('view-all/', [SearchController::class, 'joinedViewAll'])->name('joined-view-all');
}
// Regular routes
else {
    Route::get('laravel-search/{searchFor}', [SearchController::class, 'searchAjax'])->name('search');
    Route::get('view-all/{model}/page/{page}', [SearchController::class, 'singleViewAll'])->name('single-view-all');
    Route::get('view-all/{model}', [SearchController::class, 'singleViewAll'])->name('single-view-all');
    Route::get('view-all/', [SearchController::class, 'joinedViewAll'])->name('joined-view-all');
}
