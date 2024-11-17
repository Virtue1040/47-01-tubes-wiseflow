<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function() {
    //API Route
    Route::get('api/booking/get', [BookingController::class, "get"])
    ->name('booking.get');
    Route::get('api/contact/remove', [ContactController::class, "destroy"])
    ->name('contact.remove');
    Route::get('api/contact/update', [ContactController::class, "update"])
    ->name('contact.update');
});
