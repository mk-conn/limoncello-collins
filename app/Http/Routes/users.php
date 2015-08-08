<?php

Route::resource(
    '/users',
    'Demo\UsersController',
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
