<?php

use App\Http\Controllers\Api\V1\BookingController;
use Illuminate\Support\Facades\Route;

Route::prefix('bookings')
    ->name('bookings.')
    ->middleware('auth:sanctum')
    ->controller(BookingController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{booking}', 'show')->name('show');
    });
