<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('health-check', [
    'as' => 'healthCheck', 'uses' => 'HealthCheckController@check'
]);

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($router) {
    $router->group(['prefix' => 'v1', 'namespace' => 'v1'], function () use ($router) {
        $router->get('phone/{phone}', [
            'as' => 'v1/phone', 'uses' => 'PhoneController@get'
        ]);
    });
});
