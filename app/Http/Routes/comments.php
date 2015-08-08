<?php

Route::resource(
    '/comments',
    'Demo\CommentsController',
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
