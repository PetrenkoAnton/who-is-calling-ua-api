<?php

use App\Core\CommentHandlers\CICommentHandler;
use App\Core\CommentHandlers\KZCommentHandler;
use App\Core\CommentHandlers\TDCommentHandler;
use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\CIUrlFormatter;
use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use App\Core\IgnoreComments\AbstractIgnoreComment;
use App\Core\IgnoreComments\CIIgnoreComment;
use App\Core\IgnoreComments\IgnoreCommentInterface;
use App\Core\IgnoreComments\TDIgnoreComment;
use App\Core\SearchProviders\AbstractSearchProvider;
use App\Core\SearchProviders\CISearchProvider;
use App\Core\SearchProviders\KZSearchProvider;
use App\Core\SearchProviders\SearchProviderCollection;
use App\Core\SearchProviders\SearchProviderInterface;
use App\Core\SearchProviders\TDSearchProvider;
use App\Core\SearchProviders\TestSearchProvider;
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

$app->bind(SearchProviderInterface::class, AbstractSearchProvider::class);

$app->bind(IgnoreCommentInterface::class,
    AbstractIgnoreComment::class);

$app->when(TDCommentHandler::class)
    ->needs(IgnoreCommentInterface::class)
    ->give(function (Application $app) {
        return $app->make(TDIgnoreComment::class);
    });

$app->when(CICommentHandler::class)
    ->needs(IgnoreCommentInterface::class)
    ->give(function (Application $app) {
        return $app->make(CIIgnoreComment::class);
    });

$app->bind(KZSearchProvider::class, function (Application $app) {
    return new KZSearchProvider(
        $app->make(DocumentFactory::class),
        $app->make(KZCommentHandler::class),
        $app->make(KZUrlFormatter::class),
    );
});

$app->bind(TDSearchProvider::class, function (Application $app) {
    return new TDSearchProvider(
        $app->make(DocumentFactory::class),
        $app->make(TDCommentHandler::class),
        $app->make(TDUrlFormatter::class),
    );
});

$app->bind(CISearchProvider::class, function (Application $app) {
    return new CISearchProvider(
        $app->make(DocumentFactory::class),
        $app->make(CICommentHandler::class),
        $app->make(CIUrlFormatter::class),
    );
});

$app->bind(SearchProviderCollection::class, function (Application $app) {
    return new SearchProviderCollection(
        $app->make(TDSearchProvider::class),
        $app->make(KZSearchProvider::class),
        $app->make(CISearchProvider::class),
        $app->make(TestSearchProvider::class),
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
], function () {
    require __DIR__ . '/../routes/web.php';
});

return $app;
