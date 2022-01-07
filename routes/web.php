<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'boards'], function () use ($router) {
    $router->get('/', 'BoardController@list');
    $router->get('/{uuid}/threads', 'ThreadController@list');
    $router->get('/{board_uuid}/threads/{uuid}', 'ThreadController@show');
    $router->get('/{uuid}', 'BoardController@show');
});
