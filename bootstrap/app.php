<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

$app->configureMonologUsing(function (\Monolog\Logger $monolog) use ($app) {
    if (env('APP_USE_LOG_SERVER', false) === true) {
        $logServer = env('APP_LOG_SERVER', 'logs');
        $publisher = new \Gelf\Publisher(new \Gelf\Transport\UdpTransport($logServer));
        $handler   = new \Monolog\Handler\GelfHandler($publisher);
        $handler->pushProcessor(new \Monolog\Processor\WebProcessor());
        $handler->pushProcessor(new \Monolog\Processor\UidProcessor());
        $monolog->pushHandler($handler);
    } else {
        $monolog->pushHandler($handler = new \Monolog\Handler\StreamHandler($app->storagePath() . '/logs/laravel.log'));
        $handler->setFormatter(new \Monolog\Formatter\LineFormatter(null, null, true, true));
    }
});

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
