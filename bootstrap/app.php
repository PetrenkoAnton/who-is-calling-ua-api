<?php

declare(strict_types=1);

use App\Core\Formatters\UrlFormatters\SLUrlFormatter;
use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\HttpClient\UserAgent\DefaultUserAgent;
use App\Core\HttpClient\UserAgent\UserAgentCollection;
use App\Core\HttpClient\UserAgent\UserAgentInterface;
use App\Core\Parsers\AbstractParser;
use App\Core\Parsers\CIParser;
use App\Core\Parsers\ParserInterface;
use App\Core\Parsers\KZParser;
use App\Core\Parsers\SLParser;
use App\Core\Parsers\TDParser;
use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\CIUrlFormatter;
use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use App\Core\IgnoreComments\AbstractIgnoreComment;
use App\Core\IgnoreComments\CIIgnoreComment;
use App\Core\IgnoreComments\IgnoreCommentInterface;
use App\Core\IgnoreComments\TDIgnoreComment;
use App\Core\Providers\AbstractProvider;
use App\Core\Providers\CIProvider;
use App\Core\Providers\KZProvider;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\ProviderInterface;
use App\Core\Providers\SLProvider;
use App\Core\Providers\TDProvider;
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

$app->bind(UserAgentInterface::class, DefaultUserAgent::class);

$app->bind(UserAgentCollection::class, function (Application $app) {
    return new UserAgentCollection(
        $app->make(DefaultUserAgent::class),
    );
});

$app->bind(ProviderInterface::class, AbstractProvider::class);
$app->bind(IgnoreCommentInterface::class,AbstractIgnoreComment::class);
$app->bind(ParserInterface::class, AbstractParser::class);
$app->bind(HttpClientInterface::class, DefaultHttpClient::class);

$app->when(TDParser::class)
    ->needs(IgnoreCommentInterface::class)
    ->give(function (Application $app) {
        return $app->make(TDIgnoreComment::class);
    });

$app->when(CIParser::class)
    ->needs(IgnoreCommentInterface::class)
    ->give(function (Application $app) {
        return $app->make(CIIgnoreComment::class);
    });

$app->bind(KZProvider::class, function (Application $app) {
    return new KZProvider(
        $app->make(HttpClientInterface::class),
        $app->make(DocumentFactory::class),
        $app->make(KZParser::class),
        $app->make(KZUrlFormatter::class),
    );
});

$app->bind(TDProvider::class, function (Application $app) {
    return new TDProvider(
        $app->make(HttpClientInterface::class),
        $app->make(DocumentFactory::class),
        $app->make(TDParser::class),
        $app->make(TDUrlFormatter::class),
    );
});

$app->bind(CIProvider::class, function (Application $app) {
    return new CIProvider(
        $app->make(HttpClientInterface::class),
        $app->make(DocumentFactory::class),
        $app->make(CIParser::class),
        $app->make(CIUrlFormatter::class),
    );
});

$app->bind(SLProvider::class, function (Application $app) {
    return new SLProvider(
        $app->make(HttpClientInterface::class),
        $app->make(DocumentFactory::class),
        $app->make(SLParser::class),
        $app->make(SLUrlFormatter::class),
    );
});

$app->bind(ProviderCollection::class, function (Application $app) {
    return new ProviderCollection(
        $app->make(TDProvider::class),
        $app->make(KZProvider::class),
        $app->make(CIProvider::class),
        $app->make(SLProvider::class),
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
