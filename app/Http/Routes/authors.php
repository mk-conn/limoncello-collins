<?php

Route::get(
    'authors',
    ['uses' => 'Demo\AuthorsController@index']
);

Route::get(
    'authors/{id}',
    ['uses' => 'Demo\AuthorsController@show']
);

Route::post(
    '/authors',
    ['uses' => 'Demo\AuthorsController@store']
);

Route::delete(
    '/authors/{id}',
    ['uses' => 'Demo\AuthorsController@destroy']
);

Route::patch(
    '/authors/{id}',
    ['uses' => 'Demo\AuthorsController@update']
);
