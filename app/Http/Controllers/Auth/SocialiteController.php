<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Models\ContactInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect(Request $request)
    {
        return Socialite::driver($request->provider)->redirect();
    }

    public function handleCallback(Request $request)
    {
        try {
            $user = Socialite::driver($request->provider)->user();
            $finduser = User::where('username', $user->id)->first();

            if ($finduser)
            {
                Auth::login($finduser);
                return redirect('/view/home');
            }   
            else
            {
                $newUser = User::create([
                    'id_role' => 3,
                    'social_id' => $user->id,
                    'social_type' => $request->provider,
                    'password' => Hash::make('my-' . $request->provider . '-' . $user->id),
                ]);
                $nameParts = explode(' ', $user->name);
                $firstName = $nameParts[0];
                $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
                $contact = ContactInformation::create([
                    'id_user' => $newUser->id_user,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $user->email,
                    'gender' => 'Other',
                    'no_hp' => ''
                ]);

                event(new Registered($newUser));
                event(new Registered($contact));

                Auth::login($newUser);

                return redirect('/view/home');
            }

        }
        catch (Exception $e)
        {
            dd($e->getMessage());
        }
    }
}