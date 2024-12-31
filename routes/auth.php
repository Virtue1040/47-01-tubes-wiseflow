<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::get('/login/OAuth2/{provider}', [SocialiteController::class, 'redirect']);
    Route::get('/callback/OAuth2/{provider}', [SocialiteController::class, 'handleCallback']);

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('login', [LoginController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::get('/choose-role', function() {
    return view("view.chooseRole");
})->name('choose.role')->middleware('auth', 'hasNoRole');

Route::post('/choose-role', function(Request $request) {
    $request->validate([
        'role' => ['required', 'integer', 'max:255', 'exists:roles,id', 'different:1'],
    ]);
    $user = Auth::user();
    $user->assignRole([(int)$request->role]);
    return redirect(route('home', absolute: false));
})->name('choose.role.store')->middleware('auth', 'hasNoRole');

Route::post('logout', [LoginController::class, 'destroy'])
->name('logout')->middleware('auth');

Route::group(['middleware' => ['auth', 'hasRole', 'hasProperty']], function() {
    Route::get('view/property/{id}', [PropertyController::class, "showDetail"])
        ->name('property.detail');
    Route::get('view/property/{id}/edit', [PropertyController::class, "edit"])
        ->name('property.edit');
    Route::get('view/property/{id}/task', [PropertyController::class, "showGuest"])
        ->name('property.detail.task');
    Route::get('view/property/{id}/calendar', [PropertyController::class, "showCalendar"])
        ->name('property.detail.calendar');
    Route::get('view/property/{id}/transaction', [PropertyController::class, "showDetail"])
        ->name('property.detail.transaction');
    Route::get('view/property/{id}/reservation', [PropertyController::class, "showDetail"])
        ->name('property.detail.reservation');
    Route::get('view/property/{id}/iuran', [IuranController::class, "index"])
        ->name('property.detail.iuran');
    Route::get('view/property/{id}/rent/{id_rent?}', [RentController::class, "overview"])
        ->name('property.detail.rent.overview');
    Route::get('view/property/{id}/facility/{id_facility?}', [FacilityController::class, "overview"])
        ->name('property.detail.facility.overview');
});

Route::group(['middleware' => ['auth', 'hasRole']], function() {
    // View Route
    Route::get('/profile', [ProfileController::class, 'get'])->name('profile.edit');
    Route::get('view/profile/{id}/overview', [ProfileController::class, 'getProfile'])->name('profile.overview');
    Route::get('view/profile/{id}/property', [ProfileController::class, 'getProfile'])->name('profile.property');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('view/dashboard', [DashboardController::class, "index"])
        ->name('dashboard');
    Route::get('view/property', [PropertyController::class, "index"])
        ->name('property');
    Route::get('view/property/profile/{id}', [PropertyController::class, "profile"])
        ->name('property.profile');
    Route::get('view/home', [HomeController::class, "index"])
        ->name('home');
    Route::get('view/contact', [ContactController::class, "index"])
        ->name('contact');
    Route::get('view/chat', [CommunicationController::class, "index"])
        ->name('chat');
    Route::get('view/booking', [BookingController::class, "index"])
        ->name('booking');
    Route::get('view/all-booking', [BookingController::class, "index2"])
        ->name('all-booking');
    Route::get('view/calendar', [SchedulerController::class, "index"])
        ->name('calendar');
    Route::get('view/task', [SchedulerController::class, "showTask"])
        ->name('task');
    Route::get('view/find', function() {
        return view('view.findproperty');
    })->name('findproperty');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');


});
