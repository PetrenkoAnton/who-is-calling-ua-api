<?php

declare(strict_types=1);

use App\Core\Formatters\UrlFormatters\KCUrlFormatter;
use App\Core\Formatters\UrlFormatters\SLUrlFormatter;
use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\HttpClient\UserAgent\DefaultUserAgent;
use App\Core\HttpClient\UserAgent\UserAgentCollection;
use App\Core\HttpClient\UserAgent\UserAgentInterface;
use App\Core\Parsers\AbstractParser;
use App\Core\Parsers\CIParser;
use App\Core\Parsers\KCParser;
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
use App\Core\Providers\KCProvider;
use App\Core\Providers\KZProvider;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\ProviderInterface;
use App\Core\Providers\SLProvider;
use App\Core\Providers\TDProvider;
use Laravel\Lumen\Application;

/** @var Application $app */

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

$app->bind(TDProvider::class, function (Application $app) {
    return new TDProvider(
        $app->make(HttpClientInterface::class),
        $app->make(DocumentFactory::class),
        $app->make(TDParser::class),
        $app->make(TDUrlFormatter::class),
    );
});

$app->bind(KZProvider::class, function (Application $app) {
    return new KZProvider(
        $app->make(HttpClientInterface::class),
        $app->make(DocumentFactory::class),
        $app->make(KZParser::class),
        $app->make(KZUrlFormatter::class),
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

$app->bind(KCProvider::class, function (Application $app) {
    return new KCProvider(
        $app->make(HttpClientInterface::class),
        $app->make(DocumentFactory::class),
        $app->make(KCParser::class),
        $app->make(KCUrlFormatter::class),
    );
});

$app->bind(ProviderCollection::class, function (Application $app) {
    return new ProviderCollection(
        $app->make(TDProvider::class),
        $app->make(KZProvider::class),
        $app->make(CIProvider::class),
        $app->make(SLProvider::class),
        $app->make(KCProvider::class),
    );
});
