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


$router->group(['prefix' => 'api/v1'], function() use($router) {

    $router->post('login', 'AuthController@login');

    $router->get('/tasks/{offset}', 'TaskController@index');
    $router->get('/task/{task}', 'TaskController@show');
    $router->delete('/task/delete/{task}', 'TaskController@destroy');

});
