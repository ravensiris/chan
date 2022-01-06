<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'boards'], function () use ($router) {
    $router->get('/', 'BoardController@list');
    $router->get('/{id}', 'BoardController@show');
});
