<?php

Route::resource(
    '/posts',
    'Demo\PostsController',
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
