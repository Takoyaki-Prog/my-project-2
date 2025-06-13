<?php

use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\HouseUnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('house-units')
    ->name('house-units.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/{house_unit}', [HouseUnitController::class, 'show'])->name('show');
        Route::post('/{house_unit}/bookings', [BookingController::class, 'store'])->name('bookings.store');
    });
