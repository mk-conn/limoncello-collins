<?php namespace App\Http;

use \Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /** Middleware key */
    const JSON_API_BASIC_AUTH = 'jsonapi.basicAuth';

    /** Middleware key */
    const JSON_API_JWT_AUTH = 'jsonapi.jwtAuth';

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\CorsMiddleware::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'       => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,

        self::JSON_API_BASIC_AUTH => \App\Http\Middleware\JsonApiBasicAuth::class,
        self::JSON_API_JWT_AUTH   => \App\Http\Middleware\JsonApiJwtAuth::class,
    ];
}
