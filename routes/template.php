<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('component/modal', function () {
    return view('components.card.form-create-modal');
})->name("component/modal");

?>