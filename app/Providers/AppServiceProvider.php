<?php

namespace App\Providers;

use \App\Jwt\UserJwtCodec;
use \App\Jwt\UserJwtCodecInterface;
use \Illuminate\Support\ServiceProvider;
use \App\Http\Controllers\JsonApi\LaravelIntegration;
use \Neomerx\Limoncello\Contracts\IntegrationInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IntegrationInterface::class, function () {return new LaravelIntegration();});
        $this->app->bind(UserJwtCodecInterface::class, function () {return new UserJwtCodec();});
    }
}
