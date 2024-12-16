<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    return view('landing');
});

Route::get('cdn/icon/{filename}', function ($filename) {
    return view("components.icon." . $filename);
});
Route::get("/.well-known/microsoft-identity-association.json", function () {
    return response()->json([
        "associatedApplications" => [
            [
                "applicationId" => env("AZURE_CLIENT_ID")
            ]
        ]
    ],200);
});

require __DIR__.'/template.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';
