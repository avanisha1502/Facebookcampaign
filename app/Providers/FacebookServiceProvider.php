<?php

namespace App\Providers;

use Facebook\Facebook;
use Illuminate\Support\ServiceProvider;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Facebook::class, function ($app) {
            return new Facebook([
                'app_id' => '804648215068607',
                'app_secret' => '7f5e81190b2553966b4106105761b7a6',
                'default_graph_version' => 'v16.0',
                'default_access_token' => 'EAAGZC6MK3BcUBO1SjpWy9SXOuXqilr9FeSC1sEJZCON32ddtrYEwae8r2pLKeGSGvSYV9lRcAR4pAhEDZAhZCa1DKdOOC4gk7zJCXKAWwL58MZAPSx2STOV0rUUUkKzgy4IrzrRMOB8ySYDXd5BFzH1oJGT2VzseARWPaEuCfh3mOpHwhGgQfEw4LSKnIv4udaOJ3ubPvhUQpaaocFgZDZD',
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
