<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; 
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use App\Services\StreamChatService;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('microsoft', \SocialiteProviders\Microsoft\Provider::class);
        });
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user) {
                $view->with('streamToken', app(\App\Services\StreamChatService::class)->createToken($user->id_user));
            }
        });
    }
}
