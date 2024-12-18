<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\ContactInformation;
use App\Models\RentFacility;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::group(['prefix' => 'v1'], function () {
    Route::get('api/swagger', [Documentation\SwaggerController::class, 'dummy']);
});

Route::group(['middleware' => ['auth', 'auth:sanctum', 'hasRole']], function () {
    //Misc Route
    Route::get('api/user/search', function() {
        $q = request()->q;
        $getUser = ContactInformation::select(DB::raw('CONCAT(first_name, " ", last_name) as name'), 'users.id_user', 'profilePath', 'social_avatar', 'contact_information.email')
            ->join('users', 'users.id_user', '=', 'contact_information.id_user')
            ->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', "%$q%")->get();
        $data = $getUser;
        foreach ($data as $key => $value) {
          
            if ($value['id_user'] === 4) {

            }
            $data[$key]['profile'] = $value->profilePath === null ? $value->social_avatar : asset('storage/' . $value->profilePath);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data user',
            'data' => $data
        ]);
    })->name('user.search');

    //Payment Route
    Route::get('api/payment/checkout', [PaymentController::class, 'store'])->name('payment.store');

    //Booking Route
    Route::get('api/booking', [BookingController::class, "get"])
        ->name('booking.get');
    Route::get('api/booking/getAll', [BookingController::class, "getAll"])
        ->name('booking.getAll');

    //Chat route
    Route::post('api/chat/generate-token', [CommunicationController::class, 'generateToken'])->name('chat.token');
    Route::get('api/chat/get-users', [CommunicationController::class, 'getUsers']);
    Route::get('api/chat/get-channels', [CommunicationController::class, 'getUserChannel'])->name('chat.getChannel');
    Route::post('api/chat/create-channel-private', [CommunicationController::class, 'createChannelPrivate'])->name('chat.createChannelPrivate');
    Route::post('api/chat/send-message', [CommunicationController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::post('api/chat/reset-channel', [CommunicationController::class, 'resetChannel'])->name('chat.resetChannel');

    //Profile Route
    Route::get('api/profile/image', [CommunicationController::class, "getImage"])
        ->name('profile.getImage');
    Route::get('api/profile/fullname', [CommunicationController::class, "getFullName"])
        ->name('profile.getFullName');
    Route::get('api/profile/getProfile', [CommunicationController::class, "getProfile"])
        ->name('profile.getProfile');

    // Route for Rent Album
    Route::get('api/album', [AlbumController::class, "get"])
        ->name('album.getAll');
    Route::post('api/album', [AlbumController::class, "store"])
        ->name('album.store');
    Route::delete('api/album/{id}', [AlbumController::class, "destroy"])
        ->name('album.delete');

    // Route for Rent Album
    Route::get('api/rentalbum/byRent/{id}', [RentalbumController::class, "getHasRent"])
        ->name('rentalbum.getHasRent');
    Route::get('api/rentalbum/{id}', [RentalbumController::class, "getById"])
        ->name('rentalbum.getById');
    Route::get('api/rentalbum', [RentalbumController::class, "get"])
        ->name('rentalbum.getAll');
    Route::post('api/rentalbum', [RentalbumController::class, "store"])
        ->name('rentalbum.store');
    Route::delete('api/rentalbum/{id}', [RentalbumController::class, "destroy"])
        ->name('rentalbum.delete');

    // Route for Calendar
    Route::get('api/calendar/', [RentalbumController::class, "index"])
        ->name('events.store');

    // Route for Rent
    Route::get('api/rent/byProperty/{id}', [RentController::class, "getHasProperty"])
        ->name('rent.getHasProperty');
    Route::get('api/rent/{id}', [RentController::class, "getById"])
        ->name('rent.getById');
    Route::get('api/rent', [RentController::class, "get"])
        ->name('rent.getAll');
    Route::get('api/rent/guest/{id}', [RentController::class, "getGuest"])
        ->name('rent.getGuest');
    Route::post('api/rent', [RentController::class, "store"])
        ->name('rent.store');
    Route::put('api/rent/{id}', [RentController::class, "update"])
        ->name('rent.update');
    Route::delete('api/rent/{id}', [RentController::class, "destroy"])
        ->name('rent.delete');
    Route::post('api/rent/cover/{id}', [RentController::class, "updateCover"])
        ->name('rent.store.cover');

    // Route for Facility
    Route::post('api/facility', [FacilityController::class, "store"])
        ->name('facility.store');
    Route::get('api/facility/{id}', [FacilityController::class, "getById"])
        ->name('facility.getById');
    Route::delete('api/facility/{id}', [FacilityController::class, "destroy"])
        ->name('facility.delete');
    Route::put('api/facility/{id}', [FacilityController::class, "update"])
        ->name('facility.update');

    // Route for RentFacility
    Route::get('api/rentfacility', [RentFacilityController::class, "get"])
        ->name('rentfacility.getAll');
    Route::post('api/rentfacility/{id}', [RentFacilityController::class, "store"])
        ->name('rentfacility.store');
    Route::delete('api/rentfacility/{id}', [RentFacilityController::class, "destroy"])
        ->name('rentfacility.delete');
    Route::put('api/rentfacility/{id}', [RentFacilityController::class, "update"])
        ->name('rentfacility.update');
        
    // Route for Rent Tags
    Route::get('api/renttag/{id}', [RenttagController::class, "get"])
        ->name('renttag');
    Route::post('api/renttag/{id}', [RenttagController::class, "store"])
        ->name('renttag.store');
    Route::delete('api/renttag/{id}', [RenttagController::class, "destroy"])
        ->name('renttag.delete');

    // Route for Property
    Route::get('api/property/{id}', [PropertyController::class, "getById"])
        ->name('property.getById');
    Route::get('api/property/search/{category}', [PropertyController::class, "search"])
        ->name('property.search');
    Route::get('api/property/byUserAll/{id}', [PropertyController::class, "getAllById"])
        ->name('property.get');
    Route::put('api/property/{id}', [PropertyController::class, "update"])
        ->name('property.update');
    Route::get('api/property', [PropertyController::class, "get"])
        ->name('property.getAll');
    Route::post('api/property', [PropertyController::class, "store"])
        ->name('property.store');
    Route::get('api/property/getguest/{id}', [PropertyController::class, "getGuests"])
        ->name('property.getGuest');
    Route::get('api/gettype/property', [PropertyController::class, "getOwnType"])
        ->name('property.getOwnType');
    Route::delete('api/property/{id}', [PropertyController::class, "destroy"])
        ->name('property.delete');

    // Route for ContactController
    Route::delete('api/contact/{id}', [ContactController::class, "destroy"])
        ->name('contact.delete');
    Route::put('api/contact/{id}', [ContactController::class, "update"])
        ->name('contact.update');
    Route::get('api/contact', [ContactController::class, "get"])
        ->name('contact.get');
    Route::get('api/contact/get', [ContactController::class, "getAll"])
        ->name('contact.getAll');
    Route::post('api/contact', [ContactController::class, "store"])
        ->name('contact.store');

    // Route for IuranController
    Route::delete('api/iuran/{id}', [IuranController::class, "destroy"])
        ->name('iuran.delete');
    Route::put('api/iuran/{id}', [IuranController::class, "update"])
        ->name('iuran.update');
    Route::get('api/iuran', [IuranController::class, "get"])
        ->name('iuran.get');
    Route::post('api/iuran', [IuranController::class, "store"])
        ->name('iuran.store');

    // Route for CommunicationController
    Route::delete('api/communication/{id}', [CommunicationController::class, "destroy"])
        ->name('communication.remove');
    Route::put('api/communication/{id}', [CommunicationController::class, "update"])
        ->name('communication.update');
    Route::get('api/communication', [CommunicationController::class, "get"])
        ->name('communication.get');
    Route::post('api/communication}', [CommunicationController::class, "store"])
        ->name('communication.store');

});
