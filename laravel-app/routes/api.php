<?php

use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        require_once __DIR__.'/api/v1/auth.php';
        require_once __DIR__.'/api/v1/home.php';
        require_once __DIR__.'/api/v1/house-types.php';
        require_once __DIR__.'/api/v1/house-units.php';
        require_once __DIR__.'/api/v1/bookings.php';

        Route::post('/midtrans/token', [PaymentController::class, 'getSnapToken'])
            ->middleware('auth:sanctum');

        Route::get('/payments/{payment}', [PaymentController::class, 'show'])
            ->middleware('auth:sanctum');

        Route::get('/getBookingId/{house_unit}', [BookingController::class, 'getBookingId'])
            ->middleware('auth:sanctum');

        Route::get('/getPaymentId/{booking}', [PaymentController::class, 'getPaymentId'])
            ->middleware('auth:sanctum');
    });
