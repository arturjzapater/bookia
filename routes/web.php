<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([ 'prefix' => 'api/authors' ], function () use ($router) {
    $router->get('/', [ 'uses' => 'AuthorController@readAll' ]);
    $router->get('/{id}', [ 'uses' => 'AuthorController@readOne' ]);
    $router->post('/', [ 'uses' => 'AuthorController@create' ]);
    $router->put('/{id}', [ 'uses' => 'AuthorController@update' ]);
    $router->delete('/{id}', [ 'uses' => 'AuthorController@delete' ]);
});

$router->group([ 'prefix' => 'api/books' ], function () use ($router) {
    $router->get('/', [ 'uses' => 'BookController@readAll' ]);
    $router->get('/{id}', [ 'uses' => 'BookController@readOne' ]);
    $router->post('/', [ 'uses' => 'BookController@create' ]);
    $router->put('/{id}', [ 'uses' => 'BookController@update' ]);
    $router->delete('/{id}', [ 'uses' => 'BookController@delete' ]);
});
