<?php

Route::resource(
    '/authors',
    'Demo\AuthorsController',
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
