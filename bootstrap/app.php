<?php

use Laravel\Lumen\Application;

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

// $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->bind(\App\Models\SearchProviders\SearchProviderInterface::class, \App\Models\SearchProviders\TDSearchProvider::class);

$app->bind(\App\Helpers\IgnoreMessage\IgnoreMessageInterface::class,
    \App\Helpers\IgnoreMessage\AbstractIgnoreMessage::class);

$app->when(\App\Helpers\CommentFormatter\TDCommentFormatter::class)
    ->needs(\App\Helpers\IgnoreMessage\IgnoreMessageInterface::class)
    ->give(function (Application $app) {
        return $app->make(\App\Helpers\IgnoreMessage\TDIgnoreMessage::class);
    });

$app->when(\App\Helpers\CommentFormatter\CICommentFormatter::class)
    ->needs(\App\Helpers\IgnoreMessage\IgnoreMessageInterface::class)
    ->give(function (Application $app) {
        return $app->make(\App\Helpers\IgnoreMessage\CIIgnoreMessage::class);
    });

$app->bind(\App\Models\SearchProviders\KZSearchProvider::class, function (Application $app) {
    return new \App\Models\SearchProviders\KZSearchProvider(
        $app->make(\App\Models\DocumentFactory::class),
        $app->make(\App\Helpers\CommentFormatter\KZCommentFormatter::class),
        $app->make(\App\Helpers\UrlFormatter\KZUrlFormatter::class),
    );
});

$app->bind(\App\Models\SearchProviders\TDSearchProvider::class, function (Application $app) {
    return new \App\Models\SearchProviders\TDSearchProvider(
        $app->make(\App\Models\DocumentFactory::class),
        $app->make(\App\Helpers\CommentFormatter\TDCommentFormatter::class),
        $app->make(\App\Helpers\UrlFormatter\TDUrlFormatter::class),
    );
});

$app->bind(\App\Models\SearchProviders\CISearchProvider::class, function (Application $app) {
    return new \App\Models\SearchProviders\CISearchProvider(
        $app->make(\App\Models\DocumentFactory::class),
        $app->make(\App\Helpers\CommentFormatter\CICommentFormatter::class),
        $app->make(\App\Helpers\UrlFormatter\CIUrlFormatter::class),
    );
});

$app->bind(\App\Models\SearchProviders\SearchProviderCollection::class, function (Application $app) {
    return new \App\Models\SearchProviders\SearchProviderCollection(
        $app->make(\App\Models\SearchProviders\TDSearchProvider::class),
        $app->make(\App\Models\SearchProviders\KZSearchProvider::class),
        $app->make(\App\Models\SearchProviders\CISearchProvider::class),
        $app->make(\App\Models\SearchProviders\TestSearchProvider::class),
    );
});

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');
$app->configure('phone');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(Illuminate\Redis\RedisServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
