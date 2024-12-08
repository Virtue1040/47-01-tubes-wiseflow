<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    return view('landing');
});

Route::get('cdn/icon/{filename}', function ($filename) {
    return view("components.icon." . $filename);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/template.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';
