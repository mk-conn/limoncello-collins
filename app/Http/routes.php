<?php

use \App\Http\Kernel;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    'login/basic',
    ['middleware' => Kernel::JSON_API_BASIC_AUTH, 'uses' => 'Demo\UsersController@getSignedInUserJwt']
);

Route::group([
    'prefix'     => 'api/v1',
    'middleware' => [
        Kernel::JSON_API_JWT_AUTH, // comment out this line if you want to disable authentication
    ]
], function () {

    Route::get('login/refresh', 'Demo\UsersController@getSignedInUserJwt');

    include  __DIR__ . '/Routes/authors.php';
    include  __DIR__ . '/Routes/comments.php';
    include  __DIR__ . '/Routes/posts.php';
    include  __DIR__ . '/Routes/sites.php';
    include  __DIR__ . '/Routes/users.php';

});
