<?php

namespace App\Providers;

use \App\Jwt\UserJwtCodec;
use \App\Jwt\UserJwtCodecInterface;
use \Illuminate\Support\ServiceProvider;
use \App\Http\Controllers\JsonApi\LaravelIntegration;
use \Neomerx\Limoncello\Http\AppServiceProviderTrait;
use \Neomerx\Limoncello\Contracts\IntegrationInterface;

/**
 * @package Neomerx\LimoncelloCollins
 */
class AppServiceProvider extends ServiceProvider
{
    use AppServiceProviderTrait;

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
        $integration = new LaravelIntegration();

        $this->registerResponses($integration);
        $this->registerCodecMatcher($integration);
        $this->registerExceptionThrower($integration);

        $this->app->bind(IntegrationInterface::class, function () {
            return new LaravelIntegration();
        });
        $this->app->bind(UserJwtCodecInterface::class, function () {
            return new UserJwtCodec();
        });
    }
}
