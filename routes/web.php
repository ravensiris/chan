<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'boards'], function () use ($router) {
    $router->get('/', 'BoardController@list');
    $router->get('/{board_uuid}/threads', 'ThreadController@list');
    $router->post('/{board_uuid}/threads', 'ThreadController@create');
    $router->get('/{board_uuid}/threads/{uuid}', 'ThreadController@show');
    // TODO: this is getting ridiculous. Find a better way. I beg of you
    $router->get('/{board_uuid}/threads/{thread_uuid}/replies', 'ReplyController@list');
    $router->post('/{board_uuid}/threads/{thread_uuid}/replies', 'ReplyController@create');
    $router->get('/{board_uuid}/threads/{thread_uuid}/replies/{uuid}', 'ReplyController@show');
    $router->get('/{uuid}', 'BoardController@show');
});
