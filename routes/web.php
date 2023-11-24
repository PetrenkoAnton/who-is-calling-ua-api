<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('health-check', [
    'as' => 'healthCheck', 'uses' => 'HealthCheckController@check'
]);
