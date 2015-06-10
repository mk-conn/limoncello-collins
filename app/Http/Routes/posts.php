<?php

Route::get(
    'posts',
    ['uses' => 'Demo\PostsController@index']
);

Route::get(
    'posts/{id}',
    ['uses' => 'Demo\PostsController@show']
);

Route::post(
    '/posts',
    ['uses' => 'Demo\PostsController@store']
);

Route::delete(
    '/posts/{id}',
    ['uses' => 'Demo\PostsController@destroy']
);

Route::patch(
    '/posts/{id}',
    ['uses' => 'Demo\PostsController@update']
);
