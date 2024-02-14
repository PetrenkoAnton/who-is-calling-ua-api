<?php

declare(strict_types=1);

use App\Core\DocumentFactory;
use App\Core\Formatters\UrlFormatters\CFUrlFormatter;
use App\Core\Formatters\UrlFormatters\KCUrlFormatter;
use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use App\Core\Formatters\UrlFormatters\SLUrlFormatter;
use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use App\Core\Formatters\UrlFormatters\UrlFormatterInterface;
use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\HttpClient\UserAgent\DefaultUserAgent;
use App\Core\HttpClient\UserAgent\UserAgentInterface;
use App\Core\Parsers\CFParser;
use App\Core\Parsers\CIParser;
use App\Core\Parsers\KCParser;
use App\Core\Parsers\KZParser;
use App\Core\Parsers\ParserInterface;
use App\Core\Parsers\SLParser;
use App\Core\Parsers\TDParser;
use App\Core\Providers\CFProvider;
use App\Core\Providers\CIProvider;
use App\Core\Providers\KCProvider;
use App\Core\Providers\KZProvider;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\SLProvider;
use App\Core\Providers\TDProvider;
use App\Exceptions\Handler;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Redis\RedisServiceProvider;
use Laravel\Lumen\Application;
use Laravel\Lumen\Bootstrap\LoadEnvironmentVariables;

require_once __DIR__ . '/../vendor/autoload.php';

(new LoadEnvironmentVariables(
    dirname(__DIR__),
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

$app = new Application(
    dirname(__DIR__),
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
    ExceptionHandler::class,
    Handler::class,
);

$app->singleton(
    Kernel::class,
    App\Console\Kernel::class,
);

$app->bind(UserAgentInterface::class, DefaultUserAgent::class);
$app->bind(HttpClientInterface::class, DefaultHttpClient::class);

$app->bind(CFProvider::class, fn (Application $app) => new CFProvider(
    httpClient: $app->make(HttpClientInterface::class),
    documentFactory: $app->make(DocumentFactory::class),
    parser: $app->make(CFParser::class),
    urlFormatter: $app->make(CFUrlFormatter::class),
));

$app->bind(CIProvider::class, fn (Application $app) => new CIProvider(
    httpClient: $app->make(HttpClientInterface::class),
    documentFactory: $app->make(DocumentFactory::class),
    parser: $app->make(CIParser::class),
    urlFormatter: $app->make(CFUrlFormatter::class),
));

$app->bind(KCProvider::class, fn (Application $app) => new KCProvider(
    httpClient: $app->make(HttpClientInterface::class),
    documentFactory: $app->make(DocumentFactory::class),
    parser: $app->make(KCParser::class),
    urlFormatter: $app->make(KCUrlFormatter::class),
));

$app->bind(KZProvider::class, fn (Application $app) => new KZProvider(
    httpClient: $app->make(HttpClientInterface::class),
    documentFactory: $app->make(DocumentFactory::class),
    parser: $app->make(KZParser::class),
    urlFormatter: $app->make(KZUrlFormatter::class),
));

$app->bind(SLProvider::class, fn (Application $app) => new SLProvider(
    httpClient: $app->make(HttpClientInterface::class),
    documentFactory: $app->make(DocumentFactory::class),
    parser: $app->make(SLParser::class),
    urlFormatter: $app->make(SLUrlFormatter::class),
));

$app->when(TDProvider::class)
    ->needs(ParserInterface::class)
    ->give(TDParser::class);

$app->when(TDProvider::class)
    ->needs(UrlFormatterInterface::class)
    ->give(TDUrlFormatter::class);

$app->bind(ProviderCollection::class, fn (Application $app) => new ProviderCollection(
    $app->make(TDProvider::class),
    $app->make(KZProvider::class),
    $app->make(CIProvider::class),
    $app->make(SLProvider::class),
    $app->make(KCProvider::class),
    $app->make(CFProvider::class),
));

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
$app->configure('pn');
$app->configure('user_agent');
$app->configure('database');

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
$app->register(RedisServiceProvider::class);

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
