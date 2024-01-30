<?php

declare(strict_types=1);

use App\Core\Formatters\UrlFormatters\CFUrlFormatter;
use App\Core\Formatters\UrlFormatters\KCUrlFormatter;
use App\Core\Formatters\UrlFormatters\SLUrlFormatter;
use App\Core\Formatters\UrlFormatters\UrlFormatterCollection;
use App\Core\HttpClient\DefaultHttpClient;
use App\Core\HttpClient\HttpClientInterface;
use App\Core\HttpClient\UserAgent\DefaultUserAgent;
use App\Core\HttpClient\UserAgent\UserAgentInterface;
use App\Core\IgnoreComments\CFIgnoreComment;
use App\Core\Parsers\AbstractParser;
use App\Core\Parsers\CFParser;
use App\Core\Parsers\CIParser;
use App\Core\Parsers\KCParser;
use App\Core\Parsers\ParserCollection;
use App\Core\Parsers\ParserInterface;
use App\Core\Parsers\KZParser;
use App\Core\Parsers\SLParser;
use App\Core\Parsers\TDParser;
use App\Core\Formatters\UrlFormatters\CIUrlFormatter;
use App\Core\Formatters\UrlFormatters\KZUrlFormatter;
use App\Core\Formatters\UrlFormatters\TDUrlFormatter;
use App\Core\IgnoreComments\DefaultIgnoreComment;
use App\Core\IgnoreComments\CIIgnoreComment;
use App\Core\IgnoreComments\IgnoreCommentInterface;
use App\Core\IgnoreComments\TDIgnoreComment;
use App\Core\Providers\AbstractProvider;
use App\Core\Providers\CIProvider;
use App\Core\Providers\CFProvider;
use App\Core\Providers\KCProvider;
use App\Core\Providers\KZProvider;
use App\Core\Providers\ProviderCollection;
use App\Core\Providers\ProviderInterface;
use App\Core\Providers\SLProvider;
use App\Core\Providers\TDProvider;
use App\Core\CommentsService\CommentsService;
use App\Core\CommentsService\CommentsServiceInterface;
use Laravel\Lumen\Application;

/** @var Application $app */

$app->bind(CommentsServiceInterface::class, CommentsService::class);

$app->bind(UserAgentInterface::class, DefaultUserAgent::class);

$app->bind(ProviderInterface::class, AbstractProvider::class);
$app->bind(IgnoreCommentInterface::class,DefaultIgnoreComment::class);
$app->bind(ParserInterface::class, AbstractParser::class);
$app->bind(HttpClientInterface::class, DefaultHttpClient::class);

$app->when(TDParser::class)
    ->needs(IgnoreCommentInterface::class)
    ->give(fn (Application $app) => $app->make(TDIgnoreComment::class));

$app->when(CIParser::class)
    ->needs(IgnoreCommentInterface::class)
    ->give(fn (Application $app) => $app->make(CIIgnoreComment::class));

$app->when(CFParser::class)
    ->needs(IgnoreCommentInterface::class)
    ->give(fn (Application $app) => $app->make(CFIgnoreComment::class));

$app->bind(UrlFormatterCollection::class, function (Application $app) {
    return new UrlFormatterCollection(
        $app->make(CFUrlFormatter::class),
        $app->make(CIUrlFormatter::class),
        $app->make(KCUrlFormatter::class),
        $app->make(KZUrlFormatter::class),
        $app->make(SLUrlFormatter::class),
        $app->make(TDUrlFormatter::class),
    );
});

$app->bind(ParserCollection::class, function (Application $app) {
    return new ParserCollection(
        $app->make(CFParser::class),
        $app->make(CIParser::class),
        $app->make(KCParser::class),
        $app->make(KZParser::class),
        $app->make(SLParser::class),
        $app->make(TDParser::class),
    );
});

$app->bind(ProviderCollection::class, function (Application $app) {
    return new ProviderCollection(
        $app->make(TDProvider::class),
        $app->make(KZProvider::class),
        $app->make(CIProvider::class),
        $app->make(SLProvider::class),
        $app->make(KCProvider::class),
        $app->make(CFProvider::class),
    );
});
