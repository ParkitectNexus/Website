<?php

namespace PN\Users\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use PN\Users\Events\UserRegistered;
use PN\Users\Http\Controllers\AuthController;
use PN\Users\Http\Controllers\SocialAuthController;
use PN\Users\Http\Controllers\SteamController;
use PN\Users\Listeners\ConfirmWhenInDev;
use PN\Users\Listeners\EmailConfirm;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegistered::class => [
            EmailConfirm::class,
            ConfirmWhenInDev::class
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $router = $this->app['router'];

        $router->group(['middleware' => ['web']], function () use ($router) {
            $router->group(['prefix' => 'auth'], function () use ($router) {
                $router->get('login', [
                    'as' => 'auth.login',
                    'uses' => AuthController::class . '@getLogin'
                ]);
                $router->post('login', [
                    'as' => 'auth.login',
                    'uses' => AuthController::class . '@postLogin'
                ]);
                $router->get('register', [
                    'as' => 'auth.register',
                    'uses' => AuthController::class . '@getRegister'
                ]);
                $router->post('register', [
                    'as' => 'auth.register',
                    'uses' => AuthController::class . '@postRegister'
                ]);
                $router->get('forgot-password', [
                    'as' => 'auth.forgotpassword',
                    'uses' => AuthController::class . '@getForgotPassword'
                ]);
                $router->post('forgot-password', [
                    'as' => 'auth.forgotpassword',
                    'uses' => AuthController::class . '@postForgotPassword'
                ]);
                $router->get('new-password/{hash}', [
                    'as' => 'auth.newpassword',
                    'uses' => AuthController::class . '@getSetNewPassword'
                ]);
                $router->post('new-password/{hash}', [
                    'as' => 'auth.newpassword',
                    'uses' => AuthController::class . '@postSetNewPassword'
                ]);
                $router->get('logout', [
                    'as' => 'auth.logout',
                    'uses' => AuthController::class . '@getLogout'
                ]);
                $router->get('confirm', [
                    'as' => 'auth.confirm',
                    'uses' => AuthController::class . '@getConfirm'
                ]);
            });

            $router->group(['prefix' => 'social-auth'], function () use ($router) {
                $router->get('google', [
                    'as' => 'socialauth.google',
                    'uses' => SocialAuthController::class . '@getGoogle'
                ]);
                $router->get('google', [
                    'as' => 'socialauth.google',
                    'uses' => SocialAuthController::class . '@getGoogle'
                ]);
                $router->get('facebook', [
                    'as' => 'socialauth.facebook',
                    'uses' => SocialAuthController::class . '@getFacebook'
                ]);
                $router->get('github', [
                    'as' => 'socialauth.github',
                    'uses' => SocialAuthController::class . '@getGithub'
                ]);
                $router->get('steam', [
                    'as' => 'socialauth.steam',
                    'uses' => SocialAuthController::class . '@getSteam'
                ]);
                $router->get('google-callback', [
                    'as' => 'socialauth.google.callback',
                    'uses' => SocialAuthController::class . '@getGoogleCallback'
                ]);
                $router->get('facebook-callback', [
                    'as' => 'socialauth.facebook.callback',
                    'uses' => SocialAuthController::class . '@getFacebookCallback'
                ]);
                $router->get('github-callback', [
                    'as' => 'socialauth.github.callback',
                    'uses' => SocialAuthController::class . '@getGithubCallback'
                ]);
                $router->get('steam-callback', [
                    'as' => 'socialauth.steam.callback',
                    'uses' => SocialAuthController::class . '@getSteamCallback'
                ]);
                $router->get('set-username/{identifier}', [
                    'as' => 'socialauth.setusername',
                    'uses' => SocialAuthController::class . '@getSetUsername'
                ]);
                $router->post('set-username/{identifier}', [
                    'as' => 'socialauth.setusername',
                    'uses' => SocialAuthController::class . '@postSetUsername'
                ]);
            });
        });
    }
}
