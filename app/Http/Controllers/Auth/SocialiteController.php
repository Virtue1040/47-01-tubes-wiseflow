<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Services\StreamChatService;
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
        return Socialite::driver($request->provider)->with(['prompt' => 'select_account'])->redirect();
    }

    public function callAvatar($provider, $user) 
    {
        $urlAvatar = $user->getAvatar();
        switch ($provider) {
            case "Facebook":
                $url = $user->getAvatar() . '?type=normal&redirect=false&access_token=' . $user->token;
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

                $res = curl_exec($ch);
                $data = json_decode($res, true);
                if (isset($data['data']['url'])) {
                    $urlAvatar = $data['data']['url'];
                }
                
            default: 
                break;
        }
        return $urlAvatar;
    }

    public function handleCallback(Request $request)
    {
        try {
            $user = Socialite::driver($request->provider)->user();
            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser)
            {
                Auth::login($finduser);
                $finduser->social_avatar = $this->callAvatar($request->provider, $user);
                $finduser->save();
                return redirect(route('home'));
            }   
            else
            {
                $request['email'] = $user->email;
                $request->validate([
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                ]);

                $newUser = User::create([
                    'id_role' => 3,
                    'email' => $request->email,
                    'social_id' => $user->id,
                    'social_type' => $request->provider,
                    'social_avatar' => $this->callAvatar($request->provider, $user),
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

                $streamChatService = new StreamChatService;
                $streamChatService->createUser(strval($newUser->id_user), $firstName . ' ' . $lastName, $this->callAvatar($request->provider, $user));

                event(new Registered($newUser));
                event(new Registered($contact));

                Auth::login($newUser);

                return redirect(route('home'));
            }

        }
        catch (Exception $e)
        {
            switch ($e->getCode()) {
                case 0:
                    $message = 'This email is already associated with another sign-in method. Please choose a different method to continue.';
                    break;
                default:
                    $message = $e->getMessage();
                    break;
            }
            session()->flash('alert', [
                'type' => 'error',
                'message' => $message,
            ]);
            return redirect()->route('login');
        }
    }
}