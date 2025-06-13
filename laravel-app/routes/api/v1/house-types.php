<?php

use App\Http\Controllers\Api\V1\HouseTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('house-types')
    ->name('house-types.')
    ->middleware('auth:sanctum')
    ->controller(HouseTypeController::class)
    ->group(function () {
        Route::get('/{house_type}', 'show')->name('show');
    });
