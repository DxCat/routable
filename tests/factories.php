<?php

$faktory->define(['post', 'Askaoru\Routable\Tests\Models\Post'], function ($f) {
    $f->id = 1;
    $f->title = 'Post Title';
    $f->body = 'Some Post Body Content';
});

$faktory->define(['route', 'Askaoru\Routable\Models\Route'], function ($f) {
    $f->url = 'post-title';
    $f->controller = '\Askaoru\Routable\Tests\Controllers\PostController@view';
    $f->controller_parameters = '[1]';
    $f->model = 'Askaoru\Routable\Tests\Models\Post';
    $f->model_id = 1;
});
