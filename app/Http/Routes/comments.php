<?php

Route::get(
    'comments',
    ['uses' => 'Demo\CommentsController@index']
);

Route::get(
    'comments/{id}',
    ['uses' => 'Demo\CommentsController@show']
);

Route::post(
    '/comments',
    ['uses' => 'Demo\CommentsController@store']
);

Route::delete(
    '/comments/{id}',
    ['uses' => 'Demo\CommentsController@destroy']
);

Route::patch(
    '/comments/{id}',
    ['uses' => 'Demo\CommentsController@update']
);
