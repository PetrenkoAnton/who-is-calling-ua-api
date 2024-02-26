<?php

declare(strict_types=1);

use Laravel\Lumen\Routing\Router;

// phpcs:ignore SlevomatCodingStandard.Commenting.InlineDocCommentDeclaration.MissingVariable
/** @var Router $router */
$router->get('/', fn () => $router->app->version());

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($router) {
    $router->group(['prefix' => 'v1', 'namespace' => 'v1'], function () use ($router) {
        $router->get('health-check', [
            'as' => 'v1/healthCheck',
            'uses' => 'HealthCheckController@check',
        ]);

        $router->get('comments', [
            'as' => 'v1/comments:index',
            'uses' => 'CommentController@index',
        ]);

        $router->get('comments_detailed', [
            'as' => 'v1/comments:detailed',
            'uses' => 'CommentController@detailed',
        ]);

        $router->get('info', [
            'as' => 'v1/info',
            'uses' => 'InfoController@info',
        ]);
    });
});
