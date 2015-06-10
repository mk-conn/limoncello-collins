<?php

Route::get(
    'sites',
    ['uses' => 'Demo\SitesController@index']
);

Route::get(
    'sites/{id}',
    ['uses' => 'Demo\SitesController@show']
);

Route::post(
    '/sites',
    ['uses' => 'Demo\SitesController@store']
);

Route::delete(
    '/sites/{id}',
    ['uses' => 'Demo\SitesController@destroy']
);

Route::patch(
    '/sites/{id}',
    ['uses' => 'Demo\SitesController@update']
);
