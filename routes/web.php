<?php

declare(strict_types=1);

use Laravel\Lumen\Routing\Router;

// phpcs:ignore SlevomatCodingStandard.Commenting.InlineDocCommentDeclaration.MissingVariable
/** @var Router $router */
$router->get('/', fn () => $router->app->version());

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($router) {
    $router->group(['prefix' => 'v1', 'namespace' => 'v1'], function () use ($router) {
        $router->get('health-check', [
            'as' => 'healthCheck', 'uses' => 'HealthCheckController@check',
        ]);

        $router->get('search', [
            'as' => 'v1/search', 'uses' => 'SearchController@search',
        ]);

        $router->get('info', [
            'as' => 'v1/info', 'uses' => 'InfoController@info',
        ]);
    });
});
