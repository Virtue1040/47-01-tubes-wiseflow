<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('landing');
});


Route::get('/test', function () {
    return view('test');
});


// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/view/dashboard', function () {
    return view('view.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/view/property', function () {
    return view('view.property');
})->middleware(['auth', 'verified'])->name('property');

Route::get('/view/home', function () {
    return view('view.home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
