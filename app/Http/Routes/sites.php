<?php

Route::resource(
    '/sites',
    'Demo\SitesController',
    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
);
