<?php

use App\Http\Controllers\Api\BookingApiController;
use Illuminate\Support\Facades\Route;

Route::post('/bookings', [BookingApiController::class, 'store'])
    ->name('api.bookings.store');
